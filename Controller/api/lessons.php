<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Course, Lesson, LessonViews, StudentCourse};

use Controller\Helper;

use Aws\S3\S3Client;

$course = new Course;
$lesson = new Lesson;
$lesson_view = new LessonViews;
$student_course = new StudentCourse;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get-classes':
        if (empty($data['course_id']) || empty($data['lesson_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = clean_string($data);
        $results = $lesson_view->get_lessons_views_students($data['course_id'], $data['lesson_id']);
        echo json_encode($results);
        break;

    case 'join-class':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        if ($_SESSION['user_type'] != 'administrador') {
            $data['zoom_view'] = 1;
            $data['video_view'] = 0;
            $data['completed'] = 1;
            $data['certified_url'] = '';
            $data['requireCertifiedPaid'] = 2;
            $result = $lesson_view->update_view(clean_string($query), $_SESSION['user_id'], $data);
            if (!$result) {
                $helper->response_message('Error', 'No se pudo ingresar a la clase', 'error');
            }

            $update_progress = $student_course->update_course_progress(clean_string($data['slug']), $_SESSION['user_id'], true);
            if ($data['completed']) {
                $course_selected = $course->get_by_lesson_id($query);
                if (!empty($course_selected)) {
                    $isCertifiedPaid = !empty($course_selected['paid_certified']) ? true : false;
                    $canGetCertified = $isCertifiedPaid ? false : true;
                    if ($isCertifiedPaid) {
                        require_once "models/Orders.php";
                        $order = new Orders;
                        $canGetCertified = !empty($order->get_course_orders($_SESSION['user_id'], $course_selected['course_id'], status:1)) ? true : false;
                        require_once "models/QuestionAttempts.php";

                        $question_attempt = new QuestionAttempt;
                        $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes_approved = 0;
                        $total_quizzes = count($quizzes);
                        foreach ($quizzes as $quiz) {
                            if (!empty($quiz['approved'])) {
                                $quizzes_approved++;
                            }
                        }
                        $progress_data = [
                            'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                            'quizzes_approved' => $quizzes_approved,
                            'total_quizzes' => $total_quizzes,
                            'quizzes' => $quizzes,
                        ];
                        if ($progress_data['progress'] == 100 && $progress_data['total_quizzes'] == $progress_data['quizzes_approved']) {
                            $data['requireCertifiedPaid'] = 1;
                        }
                    }
                    if ($canGetCertified) {
                        require_once "models/QuestionAttempts.php";

                        $question_attempt = new QuestionAttempt;
                        $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes_approved = 0;
                        $total_quizzes = count($quizzes);
                        foreach ($quizzes as $quiz) {
                            if (!empty($quiz['approved'])) {
                                $quizzes_approved++;
                            }
                        }
                        $progress_data = [
                            'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                            'quizzes_approved' => $quizzes_approved,
                            'total_quizzes' => $total_quizzes,
                            'quizzes' => $quizzes,
                        ];
                        $isApprovedByQuizzes = round(($progress_data['quizzes_approved'] / $progress_data['total_quizzes']) * 100) >= 60 ? true : false;
                        if ($isApprovedByQuizzes) {
                            require_once "models/CourseCertifieds.php";

                            $course_certified = new CourseCertified;
                            $certified = $course_certified->get_by_course($course_selected['course_id'], $_SESSION['user_id']);
                            if (empty($certified) && !empty($course_selected['certified_template'])) {

                                $student = $_SESSION;
                                $file_name = $helper->convert_slug($student['first_name'] . ' ' . $student['last_name']) . '-' . $course_selected['course_id'] . '-' . time();
                                $tmp_dir = DIRECTORY . "/public/course-certifieds/";
                                $helper->generate_pdf(
                                    new Template(
                                        "document_templates/certified_templates/{$course_selected['certified_template']}",
                                        ['first_name' => $student['first_name'], 'last_name' => $student['last_name']]
                                    ), $file_name, $tmp_dir
                                );
                                $file_name .= '.pdf';
                                $path = $tmp_dir . $file_name;
                                $source = @fopen($path, 'r');
                                if (!empty($source)) {

                                    $credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'us-east-2',
                                        'credentials' => $credentials,
                                    ]);

                                    try {
                                        $result = $s3->putObject([
                                            'Bucket' => AWS_S3_BUCKET,
                                            'Key' => AWS_CC_FOLDER . $file_name,
                                            'Body' => $source,
                                            'ACL' => 'public-read',
                                        ]);
                                        unlink($path);
                                        $data['certified_url'] = $result['ObjectURL'];

                                        $student_data = [
                                            'user_id' => $student['user_id'],
                                            'certified_url' => $data['certified_url'],
                                            'course_id' => $course_selected['course_id'],
                                        ];
                                        $course_certified->create($student_data);
                                    } catch (Aws\S3\Exception\S3Exception$e) {
                                        unlink($path);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $helper->response_message('Éxito', 'Se unió a la clase correctamente',
            data: [
                'certified_url' => $data['certified_url'],
                'requireCertifiedPaid' => $data['requireCertifiedPaid']
            ]
        );
        break;

    case 'save-video-progress':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $query = clean_string($query);
        if ($_SESSION['user_type'] != 'administrador') {
            $data['video_view'] = 1;
            $total_percent = 100 - $data['video_missing'];
            $data['completed'] = $total_percent > 60 ? 1 : 0;
            $data['certified_url'] = '';
            $data['requireCertifiedPaid'] = 2;
            $result = $lesson_view->update_video_view($query, $_SESSION['user_id'], $data);
            if (!$result) {
                $helper->response_message('Error', 'No se pudo ingresar a la clase', 'error');
            }
            $update_progress = $student_course->update_course_progress(clean_string($data['slug']), $_SESSION['user_id'], true);
            if ($data['completed']) {
                $course_selected = $course->get_by_lesson_id($query);
                if (!empty($course_selected)) {
                    $isCertifiedPaid = !empty($course_selected['paid_certified']) ? true : false;
                    $canGetCertified = $isCertifiedPaid ? false : true;
                    if ($isCertifiedPaid) {
                        require_once "models/Orders.php";
                        $order = new Orders;
                        $canGetCertified = !empty($order->get_course_orders($_SESSION['user_id'], $course_selected['course_id'], status:1)) ? true : false;
                        require_once "models/QuestionAttempts.php";

                        $question_attempt = new QuestionAttempt;
                        $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes_approved = 0;
                        $total_quizzes = count($quizzes);
                        foreach ($quizzes as $quiz) {
                            if (!empty($quiz['approved'])) {
                                $quizzes_approved++;
                            }
                        }
                        $progress_data = [
                            'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                            'quizzes_approved' => $quizzes_approved,
                            'total_quizzes' => $total_quizzes,
                            'quizzes' => $quizzes,
                        ];
                        if ($progress_data['progress'] == 100 && $progress_data['total_quizzes'] == $progress_data['quizzes_approved']) {
                            $data['requireCertifiedPaid'] = 1;
                        }
                    }
                    if ($canGetCertified) {
                        require_once "models/QuestionAttempts.php";

                        $question_attempt = new QuestionAttempt;
                        $course_percent = $student_course->get_user_progress($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes = $question_attempt->get_my_grades($course_selected['course_id'], $_SESSION['user_id']);
                        $quizzes_approved = 0;
                        $total_quizzes = count($quizzes);
                        foreach ($quizzes as $quiz) {
                            if (!empty($quiz['approved'])) {
                                $quizzes_approved++;
                            }
                        }
                        $progress_data = [
                            'progress' => count($course_percent) > 0 ? $course_percent[0]['progress'] : 'N/A',
                            'quizzes_approved' => $quizzes_approved,
                            'total_quizzes' => $total_quizzes,
                            'quizzes' => $quizzes,
                        ];
                        $isApprovedByQuizzes = round(($progress_data['quizzes_approved'] / $progress_data['total_quizzes']) * 100) >= 60 ? true : false;
                        if ($isApprovedByQuizzes) {
                            require_once "models/CourseCertifieds.php";

                            $course_certified = new CourseCertified;
                            $certified = $course_certified->get_by_course($course_selected['course_id'], $_SESSION['user_id']);
                            if (empty($certified) && !empty($course_selected['certified_template'])) {

                                $student = $_SESSION;
                                $file_name = $helper->convert_slug($student['first_name'] . ' ' . $student['last_name']) . '-' . $course_selected['course_id'] . '-' . time();
                                $tmp_dir = DIRECTORY . "/public/course-certifieds/";
                                $helper->generate_pdf(
                                    new Template(
                                        "document_templates/certified_templates/{$course_selected['certified_template']}",
                                        ['first_name' => $student['first_name'], 'last_name' => $student['last_name']]
                                    ), $file_name, $tmp_dir
                                );
                                $file_name .= '.pdf';
                                $path = $tmp_dir . $file_name;
                                $source = @fopen($path, 'r');
                                if (!empty($source)) {

                                    $credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'us-east-2',
                                        'credentials' => $credentials,
                                    ]);

                                    try {
                                        $result = $s3->putObject([
                                            'Bucket' => AWS_S3_BUCKET,
                                            'Key' => AWS_CC_FOLDER . $file_name,
                                            'Body' => $source,
                                            'ACL' => 'public-read',
                                        ]);
                                        unlink($path);
                                        $data['certified_url'] = $result['ObjectURL'];

                                        $student_data = [
                                            'user_id' => $student['user_id'],
                                            'certified_url' => $data['certified_url'],
                                            'course_id' => $course_selected['course_id'],
                                        ];
                                        $course_certified->create($student_data);
                                    } catch (Aws\S3\Exception\S3Exception$e) {
                                        unlink($path);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $helper->response_message('Éxito', 'Registro del video de la clase guardado',
            data: [
                'certified_url' => $data['certified_url'],
                'requireCertifiedPaid' => $data['requireCertifiedPaid']
            ]
        );
        break;

    case 'delete':
        $result = $lesson_view->delete(intval($data['lesson_id']), intval($data['user_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la vista de la clase correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la vista de la clase correctamente');
        break;
}

<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Course, CourseMeta, CourseCategory, LessonMeta, StudentCourse, Section, Lesson, Member};

use Controller\Helper;

use Aws\S3\S3Client;

$credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'us-east-2',
    'credentials' => $credentials,
]);

$course = new Course;
$section = new Section;
$lesson = new Lesson;
$lesson_meta = new LessonMeta;
$course_meta = new CourseMeta;
$member = new Member;
$helper = new Helper;
$course_category = new CourseCategory;
$student_course = new StudentCourse;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        $results = $course->get($query);
        $courses = [];
        if (count($results) > 0) {
            foreach ($results as $course) {
                $result['active'] = $course['active'];
                $result['course_id'] = $course['course_id'];
                $result['duration'] = $course['duration'];
                $result['price'] = $course['price'];
                $result['featured_image'] = $course['featured_image'];
                $result['level'] = $course['level'];
                $result['published_at'] = $course['published_at'];
                $result['slug'] = $course['slug'];
                $result['title'] = $course['title'];
                $result['user_id'] = $course['user_id'];
                $result['platform_owner'] = $course['platform_owner'];
                $result['category_id'] = isset($course['category_id']) ? $course['category_id'] : '';
                $result['subcategory_id'] = isset($course['subcategory_id']) ? $course['subcategory_id'] : '';

                $meta = $course_meta->get($result['course_id']);
                $result['meta'] = [];
                foreach ($meta as $i => $e) {
                    $result['meta'][$e['course_meta_name']] = $e['course_meta_val'];
                }
                $courses[] = $result;
            }
        }
        echo json_encode($courses);
        break;

    case 'get-instructors':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $instructors = $student_course->get_instructors($query);
        echo json_encode($instructors);
        break;

    case 'get-courses':
        $columns = ['course_id, title'];
        $query = empty($query) ? 0 : clean_string($query);
        $results = $course->get_courses($query, $columns);
        echo json_encode($results);
        break;

    case 'get-my-courses':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $query = $helper->decrypt($query);
        $query = intval($query);
        $results = $course->get_my_courses($query);
        echo json_encode($results);
        break;

    case 'get-new-courses':
        $results = $course->get_recent_courses();
        echo json_encode($results);
        break;

    case 'get-total-views':
        $total_video_views = 0;
        $total_zoom_views = 0;
        $total_quizzes_done = 0;
        foreach ($data['sections'] as $section_item) {
            $video_and_zoom_views = $section->get_total_views($section_item['section_id'], $data['course_id']);
            foreach ($video_and_zoom_views as $view) {
                $total_video_views = $total_video_views + $view['video_views'];
                $total_zoom_views = $total_zoom_views + $view['zoom_views'];
            }
            $quizzes_done = $section->get_total_quizzes_done($section_item['section_id'], $data['course_id']);
            foreach ($quizzes_done as $quiz_lesson) {
                $total_quizzes_done = $total_quizzes_done + $quiz_lesson['students'];
            }
        }
        echo json_encode(
            [
                'total_video_views' => $total_video_views,
                'total_zoom_views' => $total_zoom_views,
                'total_quizzes_done' => $total_quizzes_done,
            ]
        );
        break;

    case 'get-coming-live-classes':
        $user_id = !empty($query) ? $query : $_SESSION['user_id'];
        $results = $course->get_my_courses($user_id);
        $coming_lessons = [];
        foreach ($results as $course_selected) {
            foreach ($section->get(0, $course_selected['course_id']) as $section_selected) {
                $lessons = $lesson->get_by_type($section_selected['section_id']);
                foreach ($lessons as $lesson_selected) {
                    $lesson_selected['meta'] = [];
                    $lesson_metas = $lesson_meta->get($lesson_selected['lesson_id']);
                    foreach ($lesson_metas as $meta_val) {
                        if ($meta_val['lesson_meta_name'] == 'class_type' && $meta_val['lesson_meta_val'] != 'zoom_meeting') {
                            continue;
                        }

                        $lesson_selected['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                    }
                    $meta = $lesson_selected['meta'];
                    $timezone = !empty($meta['zoom_timezone']) ? $meta['zoom_timezone'] : 'UTC';
                    date_default_timezone_set($timezone);
                    if (empty($meta['zoom_start_time'])) {
                        continue;
                    }

                    $class_date = new DateTime($meta['zoom_start_time']);
                    $server_date = new DateTime();
                    $is_current_date = date('Y-m-d', $class_date->format('U')) === date('Y-m-d', $server_date->format('U')) ? true : false;
                    if (!$is_current_date) {
                        continue;
                    }

                    $diff = $class_date->diff($server_date);
                    $minutes = $diff->i;
                    $hours = $diff->h;
                    $lesson_data = [
                        'course_image' => $course_selected['featured_image'],
                        'course_name' => $course_selected['title'],
                        'section_name' => $section_selected['section_name'],
                        'lesson_name' => $lesson_selected['lesson_name'],
                        'lesson_url' => SITE_URL . "/courses/{$course_selected['slug']}/{$lesson_selected['lesson_id']}/",
                        'lesson_date' => $meta['zoom_date'] . ' ' . $meta['zoom_time'] . ' ' . $meta['zoom_timezone'],
                    ];
                    $coming_lessons[] = $lesson_data;
                }
            }
        }
        echo json_encode($coming_lessons);
        break;

    case 'create':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $data['slug'] = $helper->convert_slug($data['title']);
        $tmp_file = $_FILES['featured_image']['tmp_name'];
        $ext = explode(".", $_FILES['featured_image']['name']);
        $file_name = time() . '.' . $ext[1];
        $path = DIRECTORY . "/public/img/featured_image/$file_name";
        $data['featured_image'] = null;
        if (move_uploaded_file($tmp_file, $path)) {
            $source = @fopen($path, 'r');
            try {
                $result = $s3->putObject([
                    'Bucket' => AWS_S3_BUCKET,
                    'Key' => AWS_CFI_FOLDER . $data['slug'] . '.' . $ext[1],
                    'Body' => $source,
                    'ACL' => 'public-read',
                ]);
                unlink($path);
                $data['featured_image'] = $result['ObjectURL'];
            } catch (Aws\S3\Exception\S3Exception$e) {
                unlink($path);
                $helper->response_message('Error', 'No se pudo subir la portada del curso, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.\n']);
            }
        } else {
            if (!$result) {
                $helper->response_message('Error', 'No se pudo subir la portada del curso, intente nuevamente', 'error');
            }

        }
        $columns = ['featured_image', 'title', 'slug', 'duration', 'price', 'level', 'user_id', 'active', 'platform_owner'];
        if (empty($data['user_id'])) {
            $data['user_id'] = $_SESSION['user_id'];
        }

        $data['price'] = floatval($data['price']);
        $result = $course->create($data, $columns);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo crear el curso correctamente', 'error');
        }

        if (isset($data['category_id'])) {
            $data['course_id'] = $result;
            $course_category->create($data);
        }
        if (isset($data['meta']) && !empty($data['meta'])) {
            $data['meta'] = json_decode($data['meta'], true);
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value, 'course_id' => $result];
                $course_meta->create($meta);
            }
        }
        $helper->response_message('Éxito', 'Se creó el curso correctamente', data:['featured_image' => $data['featured_image'], 'user_id' => $data['user_id'], 'course_id' => $result, 'slug' => $data['slug']]);
        break;

    case 'add-instructor':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data['user_rol'] = 'profesor';
        $result = $student_course->create($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo añadir el profesor al curso', 'error');
        }

        $helper->response_message('Éxito', 'Se añadió el profesor correctamente');
        break;

    case 'add-student':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $student_course->create(sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo añadir el estudiante al curso', 'error');
        }

        $helper->response_message('Éxito', "Se añadió el {$data['user_rol']} correctamente");
        break;

    case 'update':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        $data['slug'] = $helper->convert_slug($data['title']);
        if (isset($_FILES['featured_image'])) {
            $tmp_file = $_FILES['featured_image']['tmp_name'];
            $ext = explode(".", $_FILES['featured_image']['name']);
            $file_name = time() . '.' . $ext[1];
            $path = DIRECTORY . "/public/img/featured_image/$file_name";
            if (move_uploaded_file($tmp_file, $path)) {
                $source = fopen($path, 'r');
                try {
                    $result = $s3->putObject([
                        'Bucket' => AWS_S3_BUCKET,
                        'Key' => AWS_CFI_FOLDER . $data['slug'] . '.' . $ext[1],
                        'Body' => $source,
                        'ACL' => 'public-read',
                    ]);
                    unlink($path);
                    $data['featured_image'] = $result['ObjectURL'];
                } catch (Aws\S3\Exception\S3Exception$e) {
                    unlink($path);
                    $helper->response_message('Error', 'No se pudo subir la portada del curso, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.']);
                }
            }
        }
        $data['active'] = intval($data['active']);
        $data['user_id'] = intval($data['user_id']);
        $data['price'] = floatval($data['price']);
        $result = $course->edit($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar el curso correctamente', 'error');
        }

        if (isset($data['category_id'])) {
            $check_category = $course_category->get($data['course_id']);
            $data['course_id'] = intval($data['course_id']);
            $data['category_id'] = intval($data['category_id']);
            if (empty($check_category)) {
                $course_category->create($data);
            } else {
                $course_category->edit($data['course_id'], $data);
            }
        }
        if (isset($data['meta']) && !empty($data['meta'])) {
            $data['meta'] = json_decode($data['meta'], true);
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value];
                if (isset($_FILE[$meta_key])) {
                    $tmp_file = $_FILES[$meta_key]['tmp_name'];
                    $ext = explode(".", $_FILES[$meta_key]['name']);
                    $file_name = time() . '.' . $ext[1];
                    $path = DIRECTORY . "/public/img/$file_name";
                    if (move_uploaded_file($tmp_file, $path)) {
                        $source = fopen($path, 'r');
                        try {
                            $result = $s3->putObject([
                                'Bucket' => AWS_S3_BUCKET,
                                'Key' => AWS_MEDIA_FOLDER . $data['slug'] . '-certified-by.' . $ext[1],
                                'Body' => $source,
                                'ACL' => 'public-read',
                            ]);
                            unlink($path);
                            $meta_value = $result['ObjectURL'];
                        } catch (Aws\S3\Exception\S3Exception$e) {
                            unlink($path);
                            $helper->response_message('Error', 'No se pudo subir el archivo, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.']);
                        }
                    }
                }
                $check_meta = $course_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value, 'course_id' => $id];
                    $course_meta->create($meta_data);
                    continue;
                }
                $course_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Éxito', 'Se editó el curso correctamente', data:['featured_image' => $data['featured_image'], 'slug' => $data['slug']]);
        break;

    case 'update-meta':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        $data['meta'] = json_decode($data['meta'], true);
        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                if (is_array($meta_value)) {
                    $meta_value = json_encode($meta_value, JSON_UNESCAPED_UNICODE);
                }

                $meta = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value, 'course_id' => $id];
                $check_meta = $course_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value, 'course_id' => $id];
                    $course_meta->create($meta_data);
                    continue;
                }
                $course_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Éxito', 'Se actualizó la información correctamente');
        break;

    case 'update-cover':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        if (isset($_FILES['featured_image'])) {
            $tmp_file = $_FILES['featured_image']['tmp_name'];
            $ext = explode(".", $_FILES['featured_image']['name']);
            $file_name = time() . '.' . $ext[1];
            $path = DIRECTORY . "/public/img/featured_image/$file_name";
            if (move_uploaded_file($tmp_file, $path)) {
                $source = fopen($path, 'r');
                try {
                    $result = $s3->putObject([
                        'Bucket' => AWS_S3_BUCKET,
                        'Key' => AWS_CFI_FOLDER . $data['slug'] . '.' . $ext[1],
                        'Body' => $source,
                        'ACL' => 'public-read',
                    ]);
                    unlink($path);
                    $data['featured_image'] = $result['ObjectURL'];
                } catch (Aws\S3\Exception\S3Exception$e) {
                    unlink($path);
                    $helper->response_message('Error', 'No se pudo subir la portada del curso, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.']);
                }
            }
        }
        $result = $course->edit_cover($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo actualizar la portada del curso correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó la portada del curso correctamente', data:['featured_image' => $data['featured_image']]);
        break;

    case 'update-certified-by':
        if (empty($_POST)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $course_id = intval($data['course_id']);
        if (isset($_FILES['certified_by_image'])) {
            $tmp_file = $_FILES['certified_by_image']['tmp_name'];
            $ext = explode(".", $_FILES['certified_by_image']['name']);
            $file_name = time() . '.' . $ext[1];
            $path = DIRECTORY . "/public/img/certified_by/$file_name";
            if (move_uploaded_file($tmp_file, $path)) {
                $source = fopen($path, 'r');
                try {
                    $result = $s3->putObject([
                        'Bucket' => AWS_S3_BUCKET,
                        'Key' => AWS_CCBI_FOLDER . $data['slug'] . '-certified-by.' . $ext[1],
                        'Body' => $source,
                        'ACL' => 'public-read',
                    ]);
                    unlink($path);
                    $data['certified_by_image'] = $result['ObjectURL'];
                } catch (Aws\S3\Exception\S3Exception$e) {
                    unlink($path);
                    $helper->response_message('Error', 'No se pudo subir la imágen, intente nuevamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.']);
                }
            }
        }
        $check_meta = $course_meta->get_meta($course_id, 'certified_by');
        $meta_data = ['course_meta_name' => 'certified_by', 'course_meta_val' => $data['certified_by_image'], 'course_id' => $course_id];
        if (empty($check_meta)) {
            $result = $course_meta->create($meta_data);
        } else {
            $result = $course_meta->edit($course_id, $meta_data);
        }
        if (!$result) {
            $helper->response_message('Error', 'No se pudo actualizar la imágen de la institución certificada correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó la imágen de la institución certificada correctamente', data:['certified_by_image' => $data['certified_by_image']]);
        break;

    case 'delete':
        $result = $course->delete(intval($data['course_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar el curso correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó el curso correctamente');
        break;

    case 'remove-instructor':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $student_course->delete($data['user_id'], $data['course_id']);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar el profesor del curso', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó el profesor correctamente');
        break;

}

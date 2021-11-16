<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Course, StudentCourse, Lesson, LessonMeta, Media, Notification};

use Controller\Helper;
use Controller\ZoomInstance;

use Aws\S3\S3Client;

$credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'us-east-2',
    'credentials' => $credentials,
]);

$course = new Course;
$student_course = new StudentCourse;
$lesson = new Lesson;
$zoom_instance = new ZoomInstance;
$lesson_meta = new LessonMeta;
$media = new Media;
$notification = new Notification;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get-meta-info':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $lesson_meta->get(clean_string($query));
        echo json_encode($data);
        die();
        break;

    case 'create':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $lesson->create(sanitize($data), intval($data['section_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo registrar la lección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se registró la lección correctamente', data:['lesson_id' => $result]);
        break;

    case 'update-class-lesson-meta':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $data_vars = [];
        $notify = !empty($data['send_publish_email']) ? $data['send_publish_email'] : false;
        if ($data['class_type'] == 'video') {
            set_time_limit(25600);
            if (isset($_FILES['video']['tmp_name'])) {
                $tmp_video_file = $_FILES['video']['tmp_name'];
                $ext_video = explode(".", $tmp_video_file);
                $main_video_name = "fl-{$data['course_id']}-{$data['lesson_id']}";
                $data['video_url'] = '';
                $media_data = ['course_id' => $data['course_id'], 'lesson_id' => $data['lesson_id'], 'user_id' => $_SESSION['user_id'], 'main_url' => ''];
                $ffmpeg = FFMpeg\FFMpeg::create(['timeout' => 25600]);
                $codec = new FFMpeg\Format\Video\X264();
                $video = $ffmpeg->open($tmp_video_file);
                $video
                    ->filters()
                    ->synchronize();
                foreach ($helper->array_sort($helper->video_resolution(), 'order', SORT_DESC) as $resolution) {  
                    $temp_path = "public/media/video-{$resolution['name']}-". time() .".mp4";
                    $absolute_temp_path = DIRECTORY . "/$temp_path";
                    $codec
                        ->setKiloBitrate($resolution['bitrate']);
                    $video
                        ->save($codec, $temp_path);
                    if (file_exists($absolute_temp_path)) {
                        $source = fopen($absolute_temp_path, 'r');
                        try {
                            $video_upload = $s3->putObject([
                                'Bucket' => AWS_S3_BUCKET,
                                'Key' => AWS_MEDIA_FOLDER . "fl-{$data['course_id']}-{$data['lesson_id']}-{$resolution['name']}.mp4",
                                'Body' => $source,
                                'ACL' => 'public-read',
                            ]);
                            unlink($absolute_temp_path);
                            $media_data['url'] = $video_upload['ObjectURL'];
                            if ($resolution['name'] == '1080p') {
                                $data['video_url'] = $media_data['url'];
                                $media_data['main_url'] = $media_data['url'];
                            }
                            $media_data['resource_type'] = 'class';
                            $media_update = $media->update($media_data);
                            if ($media_update) {
                                $meta_name = "video_url_{$resolution['name']}";
                                $meta_val = $media_data['url'];
                                $check_meta = $lesson_meta->get_meta($data['lesson_id'], $meta_name);
                                $meta_data = ['lesson_meta_name' => $meta_name, 'lesson_meta_val' => $meta_val, 'lesson_id' => $data['lesson_id']];
                                if (empty($check_meta)) {
                                    $result = $lesson_meta->create($meta_data);
                                } else {
                                    $result = $lesson_meta->edit($check_meta['lesson_id'], $meta_data);
                                }
                                if (!$result) {
                                    $helper->response_message('Error', "No se pudo actualizar el siguiente campo: $meta_name", 'error');
                                }
                            }
                        } catch (Aws\S3\Exception\S3Exception$e) {
                            unlink($absolute_temp_path);
                            $helper->response_message('Error', "No se pudo subir el video en resolución {$resolution['name']} correctamente", 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.\n']);
                        }
                    }
                }
            }
            if (isset($_FILES['poster']['tmp_name'])) {
                $tmp_poster_file = $_FILES['poster']['tmp_name'];
                $ext_poster = explode(".", $_FILES['poster']['name']);
                $file_poster_name = 'poster-' . time() . '.' . end($ext_poster);
                $poster_path = DIRECTORY . "/public/media/$file_poster_name";
                if (move_uploaded_file($tmp_poster_file, $poster_path)) {
                    try {
                        $source = fopen($poster_path, 'r');
                        $poster_upload = $s3->putObject([
                            'Bucket' => AWS_S3_BUCKET,
                            'Key' => AWS_MEDIA_FOLDER . "fl-poster-{$data['course_id']}-{$data['lesson_id']}." . end($ext_poster),
                            'Body' => $source,
                            'ACL' => 'public-read',
                        ]);
                        unlink($poster_path);
                        $data['poster_url'] = $poster_upload['ObjectURL'];
                        $media_data['url'] = $data['poster_url'];
                        $media_data['resource_type'] = 'general';
                        $media_update = $media->update($media_data);
                        $data_vars = ['video_url' => $data['video_url'], 'poster_url' => $data['poster_url']];
                    } catch (Aws\S3\Exception\S3Exception$e) {
                        unlink($poster_path);
                        $helper->response_message('Error', 'No se pudo subir el poster del video correctamente', 'error', ['err' => 'Hubo un error al intentar subir el archivo a Amazon S3.\n']);
                    }
                }
            }
        } else if ($data['class_type'] == 'zoom_meeting') {
            $meeting_data = [
                'zoom_jwt' => $data['zoom_jwt'],
                'zoom_host' => $data['zoom_host'],
                'topic' => $data['zoom_topic'],
                'agenda' => $data['zoom_agenda'],
                'duration' => $data['zoom_duration'],
                'start_time' => $data['zoom_start_time'],
                'password' => $helper->rand_string(10),
            ];
            if (isset($data['meeting_id'])) {
                $meeting_data['meeting_id'] = $data['meeting_id'];
            }

            $data_vars = $zoom_instance->create_meeting($meeting_data);
            if (!is_object($data_vars)) {
                if ($data_vars == 400) {
                    $helper->response_message('Error', 'El host alternativo debe ser otra cuenta con licencia', 'error');
                }
            }
            $notify = false;
            $data['zoom_url'] = isset($data_vars->join_url) ? $data_vars->join_url : null;
            $data['zoom_id'] = isset($data_vars->id) ? $data_vars->id : null;
            $data['zoom_password'] = $meeting_data['password'];
        }
        foreach ($data as $meta_name => $meta_val) {
            if ($meta_name == 'lesson_id' or $meta_name == 'course_id' or $meta_name == 'video' or $meta_name == 'poster') {
                continue;
            }

            $check_meta = $lesson_meta->get_meta($data['lesson_id'], $meta_name);
            $meta_data = ['lesson_meta_name' => $meta_name, 'lesson_meta_val' => $meta_val, 'lesson_id' => $data['lesson_id']];
            if (empty($check_meta)) {
                $result = $lesson_meta->create($meta_data);
            } else {
                $result = $lesson_meta->edit($check_meta['lesson_id'], $meta_data);
            }
            if (!$result) {
                $helper->response_message('Error', "No se pudo actualizar el siguiente campo: $meta_name", 'error');
            }

        }
        if ($notify) {
            $course_selected = $course->get(clean_string($data['course_id']));
            $course_selected = $course_selected[0];
            $lesson_selected = $lesson->get_by_id(clean_string($data['lesson_id']));
            $lesson_selected = $lesson_selected[0];

            $students = $student_course->get_students($course_selected['course_id']);
            $template_data = [
                'title' => 'Clase subida en ' . $course_selected['title'],
                'course' => $course_selected,
                'lesson' => $lesson_selected,
            ];
            $notification_data = [
                'description' => "El video de la clase <b>{$lesson_selected['lesson_name']}</b> ha sido subido",
                'course_id' => $course_selected['course_id'],
                'lesson_id' => $lesson_selected['lesson_id'],
            ];
            foreach ($students as $student) {
                $template_data['student'] = $student;
                $template = new Controller\Template('email_templates/video_class_reminder', $template_data);
                $sendEmail = $helper->send_mail($template_data['title'], [['email' => $student['email'], 'full_name' => $student['first_name'] . ' ' . $student['last_name']]], $template);
                $notification_data['user_id'] = $student['user_id'];
                $notification->create($notification_data);
            }
        }
        $helper->response_message('Éxito', 'Se actualizó la lección correctamente', data:$data_vars);
        break;

    case 'update-quiz-lesson-meta':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data_vars = [];
        $lesson = $data['lesson'];
        $course = $data['course'];
        foreach ($lesson['meta'] as $meta_name => $meta_val) {
            if ($meta_name == 'send_publish_email' && $meta_val == 1) {
                $students = $student_course->get_students($course['course_id']);
                $template_data = [
                    'title' => 'Quiz subido en ' . $course['title'],
                    'course' => $course,
                    'lesson' => $lesson,
                ];
                $notification_data = [
                    'description' => "El quiz <b>{$lesson['lesson_name']}</b> ha sido subido",
                    'course_id' => $course['course_id'],
                    'lesson_id' => $lesson['lesson_id'],
                ];
                foreach ($students as $student) {
                    $template_data['student'] = $student;
                    $template = new Controller\Template('email_templates/quiz_class_reminder', $template_data);
                    $sendEmail = $helper->send_mail($template_data['title'], [['email' => $student['email'], 'full_name' => $student['first_name'] . ' ' . $student['last_name']]], $template);
                    $notification_data['user_id'] = $student['user_id'];
                    $notification->create($notification_data);
                }
                $meta_val = 0;
            }
            $check_meta = $lesson_meta->get_meta($lesson['lesson_id'], $meta_name);
            $meta_data = ['lesson_meta_name' => $meta_name, 'lesson_meta_val' => $meta_val, 'lesson_id' => $lesson['lesson_id']];
            if (empty($check_meta)) {
                $result = $lesson_meta->create($meta_data);
            } else {
                $result = $lesson_meta->edit($check_meta['lesson_id'], $meta_data);
            }
            if (!$result) {
                $helper->response_message('Error', "No se pudo actualizar el siguiente campo: $meta_name", 'error');
            }

        }
        $helper->response_message('Éxito', 'Se actualizó la lección correctamente', data:$data_vars);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $lesson_id = intval($data['lesson_id']);
        $section_id = intval($data['section_id']);
        if ($data['lesson_order'] != $data['old_lesson_order']) {
            $old_lesson = $lesson->get_lesson_by_order($section_id, intval($data['lesson_order']));
            if (!empty($old_lesson)) {
                $old_lesson = $old_lesson[0];
                $old_lesson['lesson_order'] = $data['old_lesson_order'];
                $lesson->edit(intval($old_lesson['lesson_id']), $old_lesson);
            }
        }
        $result = $lesson->edit($lesson_id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar la lección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó la lección correctamente');
        break;

    case 'delete':
        $result = $lesson->delete(intval($data['lesson_id']), intval($data['section_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la lección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la lección correctamente');
        break;
}

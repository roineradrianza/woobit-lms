<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\{Course, CourseMeta, Section, Lesson, LessonMeta, Member, StudentCourse, Notification};

use Controller\{Helper, Template};

$course = New Course;
$course_meta = New CourseMeta;
$section = New Section;
$lesson = New Lesson;
$lesson_meta = New LessonMeta;
$member = New Member;
$student_course = New StudentCourse;
$notification = New Notification;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;


switch ($method) {

	case 'remind-zoom-classes':
		$courses = $course->get();
		foreach ($courses as $course_selected) {
			if ($course_selected['course_id'] == 6 || $course_selected['course_id'] == 10 || $course_selected['course_id'] == 11) continue;
			$students = $student_course->get_all_users($course_selected['course_id']);
			$sections = [];
			foreach ($section->get(course_id: $course_selected['course_id']) as $section_selected) {
				$lessons = $lesson->get_by_type($section_selected['section_id']);
				$section_selected['items'] = [];
				foreach ($lessons as $lesson_selected) {
					$lesson_selected['meta'] = [];
					$lesson_metas = $lesson_meta->get($lesson_selected['lesson_id']);
					foreach ($lesson_metas as $meta_val) {
						if ($meta_val['lesson_meta_name'] == 'class_type' && $meta_val['lesson_meta_val'] != 'zoom_meeting') continue;
						$lesson_selected['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
					}
					$meta = $lesson_selected['meta'];
					$timezone = !empty($meta['zoom_timezone']) ? $meta['zoom_timezone'] : 'UTC';
					date_default_timezone_set($timezone);
					if (empty($meta['zoom_start_time'])) continue;
					$class_date  = new DateTime($meta['zoom_start_time']);
					$server_date = new DateTime();
					$is_current_date = date('Y-m-d', $class_date->format( 'U' )) === date('Y-m-d', $server_date->format( 'U' )) ? true : false;
					if (!$is_current_date || $class_date->format( 'U' ) < $server_date->format( 'U' )) continue;
					$section_selected['items'][] = $lesson_selected;
          $diff = $class_date->diff($server_date);
        	$minutes = $diff->i;
          $hours = $diff->h;
					print_r(["Fecha de la clase" => $class_date, "Fecha del servidor" => $server_date, "Horas restantes" => $hours, "Minutos faltantes" => $minutes]);
					$template_data = [
						'title' => 'Recordatorio de clases en ' . $course_selected['title'],
						'course' => $course_selected,
						'section' => $section_selected,
						'lesson' => $lesson_selected,
						'course_sponsors' => $course_meta->get_meta($course_selected['course_id'], 'sponsors_logo_email_url')
					];
					$notification_data = [
						'description' => "Recuerda asistir a tu clase: {$lesson_selected['lesson_name']}",
						'course_id' => $course_selected['course_id'],
						'lesson_id' => $lesson_selected['lesson_id'],
					];
          if($hours == 12) {
            foreach ($students as $student) {
            	$template_data['student'] = $student;
            	$template = new Template('email_templates/zoom_class_reminder', $template_data);
							$sendEmail = $helper->send_mail($template_data['title'], [['email' => $student['email'], 'full_name' => $student['first_name'] . ' ' . $student['last_name']]], $template);
							$notification_data['user_id'] = $student['user_id'];
							$notification->create($notification_data);
            }
          }
          else if ($hours == 1 AND $minutes == 0) {
            foreach ($students as $student) {
							$template_data['student'] = $student;
          		$template = new Template('email_templates/zoom_class_reminder', $template_data);
              $sendEmail = $helper->send_mail($template_data['title'], [['email' => $student['email'], 'full_name' => $student['first_name'] . ' ' . $student['last_name']]], $template);
            	$notification_data['description'] = "Pronto comenzará la clase de '{$lesson_selected['lesson_name']}', ¡No olvides asistir!";
							$notification_data['user_id'] = $student['user_id'];
							$notification->create($notification_data);
            }
          }
          else if($hours == 0 AND $minutes >= 1 AND $minutes <= 59) {
            foreach ($students as $student) {
							$template_data['student'] = $student;
							$template = new Template('email_templates/zoom_class_reminder', $template_data);
          		$sendEmail = $helper->send_mail($template_data['title'], [['email' => $student['email'], 'full_name' => $student['first_name'] . ' ' . $student['last_name']]], $template);
							$notification_data['description'] = "Pronto comenzará la clase de '{$lesson_selected['lesson_name']}', ¡No olvides asistir!";
							$notification_data['user_id'] = $student['user_id'];
							$notification->create($notification_data);
            }
          }
				}
				$sections[] = $section;
			}
		}
		break;
	
}
<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\{Course, StudentCourse, Lesson, LessonComments, LessonCommentsAnswers, Notification};

use Controller\Helper;

$course = New Course;
$student_course = New StudentCourse;
$lesson = New Lesson;
$lesson_comment = New LessonComments;
$lesson_comment_answer = New LessonCommentsAnswers;
$notification = New Notification;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {

	case 'get':
		$results = $lesson_comment->get_lesson_comments($query);
		$items = [];
		$course_result = $course->get_by_slug($data['course_slug']);
		$course_selected = empty($course_result[0]) ? [] : $course_result[0];
		$canManage = $course->user_has_access($course_selected['course_id'], $_SESSION);
		foreach ($results as $item) {
			$item['editable'] = false;
			if ($canManage || $item['user_id'] == $_SESSION['user_id']) $item['editable'] = true;
			$answers = [];
			foreach ($lesson_comment_answer->get($item['lesson_comment_id']) as $answer) {
				$answer['editable'] = false;
				if ($canManage || $item['user_id'] == $_SESSION['user_id']) $answer['editable'] = true;
				$answers[] = $answer;
			}
			$item['answers'] = $answers;
			$items[] = $item;
		}
		echo json_encode($items);
		break;

	case 'create':
		if (empty($data) || empty($_SESSION['user_id'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data['user_id'] = $_SESSION['user_id'];
		$result = $lesson_comment->create($data);
		if (!$result) $helper->response_message('Error', 'No se pudo publicar', 'error');
		$comment_data = ['lesson_comment_id' => $result, 'avatar' => $_SESSION['avatar'], 'first_name' => $_SESSION['first_name'], 'last_name' => $_SESSION['last_name'], 'username' => $_SESSION['username']];
		if ($data['comment_type'] == 'question') {
			$template_data = $comment_data;
			$template_data['comment'] = $data['comment'];
			$template_data['course'] = $course->get_by_lesson_id($data['lesson_id']);
			$template_data['course'] = $template_data['course'];
			$template_data['lesson'] = $lesson->get_by_id($data['lesson_id']);
			$template_data['lesson'] = $template_data['lesson'][0];
			$template_data['title'] = "Nueva pregunta publicada - {$template_data['course']['title']}";
			$instructors = $student_course->get_instructors($template_data['course']['course_id']);
			$template = new Template('email_templates/lesson_question_published', $template_data);
			$notification_data = [
				'description' => "Nueva pregunta publicada en la clase <b>'{$template_data['lesson']['lesson_name']}'</b> de <b>{$template_data['course']['title']}</b>.<br> {$comment_data['first_name']} {$comment_data['last_name']} pregunta: {$template_data['comment']}",
				'course_id' => $template_data['course']['course_id'],
				'lesson_id' => $data['lesson_id'],
			];
			foreach ($instructors as $instructor) {
				$sendEmail = $helper->send_mail($template_data['title'], [['email' => $instructor['email'], 'full_name' => $instructor['first_name'] . ' ' . $instructor['last_name']]], $template);

				$notification_data['user_id'] = $instructor['user_id'];
				$notification->create($notification_data);
			}
		}
		$helper->response_message('Éxito', 'Se publicó correctamente', data: $comment_data);
		break;

	case 'update':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$result = $lesson_comment->edit(clean_string($data['lesson_comment_id']), $data);
		if (!$result) $helper->response_message('Error', 'No se pudo editar correctamente', 'error');
		$helper->response_message('Éxito', 'Se editó correctamente');
		break;

	case 'delete':
		$result = $lesson_comment->delete($data['lesson_comment_id']);
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó correctamente');
		break;
}
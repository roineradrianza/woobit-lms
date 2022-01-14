<?php 
/*
*	@var method
*   @var query
*/
if (empty($method)) die(403);
use Model\{LessonComments, LessonCommentsAnswers};

use Controller\Helper;

$lesson_comment = New LessonComments;
$lesson_comment_answer = New LessonCommentsAnswers;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {

	case 'get':
		$results = $lesson_comment_answer->get($query);
		echo json_encode($results);
		break;

	case 'create':
		if (empty($data) || empty($_SESSION['user_id'])) $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
		$data['user_id'] = $_SESSION['user_id'];
		$result = $lesson_comment_answer->create($data);
		if (!$result) $helper->response_message('Error', 'Nu a putut fi publicat', 'error');
		$helper->response_message('Succes', 'Răspunsul a fost publicat corect', data: ['lesson_comment_answer_id' => $result, 'avatar' => $_SESSION['avatar'], 'first_name' => $_SESSION['first_name'], 'last_name' => $_SESSION['last_name']]);
		break;

	case 'update':
		if (empty($data)) $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
		$result = $lesson_comment_answer->edit(clean_string($data['lesson_comment_answer_id']), $data);
		if (!$result) $helper->response_message('Error', 'Nu s-a putut edita corect răspunsul', 'error');
		$helper->response_message('Succes', 'Editat corect');
		break;

	case 'delete':
		$result = $lesson_comment_answer->delete($data['lesson_comment_answer_id']);
		if (!$result) $helper->response_message('Error', 'Nu s-a putut șterge răspunsul corect', 'error');
		$helper->response_message('Succes', 'Corect șters');
		break;
}
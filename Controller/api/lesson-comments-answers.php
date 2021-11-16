<?php 
/*
*	@var method
* @var query
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
		if (empty($data) || empty($_SESSION['user_id'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data['user_id'] = $_SESSION['user_id'];
		$result = $lesson_comment_answer->create($data);
		if (!$result) $helper->response_message('Error', 'No se pudo publicar', 'error');
		$helper->response_message('Éxito', 'Se publicó la respuesta correctamente', data: ['lesson_comment_answer_id' => $result, 'avatar' => $_SESSION['avatar'], 'first_name' => $_SESSION['first_name'], 'last_name' => $_SESSION['last_name'], 'username' => $_SESSION['username']]);
		break;

	case 'update':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$result = $lesson_comment_answer->edit(clean_string($data['lesson_comment_answer_id']), $data);
		if (!$result) $helper->response_message('Error', 'No se pudo editar la respuesta correctamente', 'error');
		$helper->response_message('Éxito', 'Se editó correctamente');
		break;

	case 'delete':
		$result = $lesson_comment_answer->delete($data['lesson_comment_answer_id']);
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar la respuesta correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó correctamente');
		break;
}
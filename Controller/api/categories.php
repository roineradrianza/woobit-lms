<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);
use Model\Category;

use Controller\Helper;

$category = New Category;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {
	case 'get':
		$results = $category->get($query);
		echo json_encode($results);
		break;

	case 'create':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrador') {
			die(403);
		}
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$columns = ['name'];
		$result = $category->create(sanitize($data), $columns);
		if (!$result) $helper->response_message('Error', 'No se pudo registrar la categoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se registró la categoría correctamente', data: ['category_id' => $result]);
		break;

	case 'update':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrador') {
			die(403);
		}
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');;
		$id = intval($data['category_id']);
		$result = $category->edit($id, sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar la categoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se editó la categoría correctamente');
		break;	

	case 'delete':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrador') {
			die(403);
		}
		$result = $category->delete(intval($data['category_id']));
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar la categoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó la categoría correctamente');
		break;
}
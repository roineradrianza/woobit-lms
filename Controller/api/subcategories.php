<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\SubCategory;

use Controller\Helper;

$subcategory = New SubCategory;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {
	case 'get':
		$results = $subcategory->get($query);
		echo json_encode($results);
		break;

	case 'create':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrator') {
			die(403);
		}
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$columns = ['category_id','name'];
		$data['category_id'] = intval($data['category_id']);
		$result = $subcategory->create(sanitize($data), $columns);
		if (!$result) $helper->response_message('Error', 'No se pudo registrar la subcategoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se registró la subcategoría correctamente', data: ['subcategory_id' => $result]);
		break;

	case 'update':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrator') {
			die(403);
		}
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');;
		$id = intval($data['subcategory_id']);
		$data['category_id'] = intval($data['category_id']);
		$result = $subcategory->edit($id, sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar la subcategoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se editó la subcategoría correctamente');
		break;	

	case 'delete':
		if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrator') {
			die(403);
		}
		$result = $subcategory->delete(intval($data['subcategory_id']));
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar la subcategoría correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó la subcategoría correctamente');
		break;
}
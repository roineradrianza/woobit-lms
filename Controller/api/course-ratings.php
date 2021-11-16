<?php
/**Course Ratings API*/
/*@var method @var query*/
if (empty($method)) {
    die(403);
}

use Model\CourseRating;

use Controller\Helper;

$course_rating = new CourseRating;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':
        $query = clean_string($query);
        $results = $course_rating->get($query);
        echo json_encode($results);
        break;

    case 'get-mine':
        $query = clean_string($query);
        $results = $course_rating->get_by_user_and_course($query, $_SESSION['user_id']);
        echo json_encode($results);
        break;
    
    case 'create':
        if (empty($data) || empty($data['course_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = sanitize($data);
        $data['user_id'] = $_SESSION['user_id'];
        $result = $course_rating->create($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo crear el comentario correctamente', 'error');
        }
        $helper->response_message('Éxito', 'Se creó el comentario correctamente', data: ['course_rating_id' => $result]);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $data['user_id'] = $_SESSION['user_id'];
        $result = $course_rating->edit($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar el comentario, intente de nuevo.', 'error');
        }
        $helper->response_message('Éxito', 'Se editó el comentario correctamente');
        break;

    case 'delete':
        $result = $course_rating->delete(intval($data['course_rating_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar el comentario correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó el comentario correctamente');
        break;
}

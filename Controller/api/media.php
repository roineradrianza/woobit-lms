<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\Media;

use Controller\Helper;





$helper = new Helper;
$media = new Media;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get-by-courses':
        $columns = ['media_id'];
        $results = $media->get_by_courses($query, $columns);
        echo json_encode($results);
        break;

    case 'get-lesson-resources':
        $columns = ['media_id'];
        $results = $media->get_by_lesson(clean_string($query), 'material');
        echo json_encode($results);
        break;

    case 'create':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $tmp_file = $_FILES['media']['tmp_name'];
        $ext = explode(".", $_FILES['media']['name']);
        $file_name = time() . '.' . $ext[1];
        $path = DIRECTORY . "/public/media/$file_name";
        $data['url'] = null;
        if (move_uploaded_file($tmp_file, $path)) {
            $data['url'] = "media/$file_name";
        }
        $data['course_id'] = !empty($data['course_id']) ? $data['course_id'] : 'NULL';
        $data['lesson_id'] = !empty($data['lesson_id']) ? $data['lesson_id'] : 'NULL';
        $data['user_id'] = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';

        $result = $media->update($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo registrar el archivo correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se registró el archivo correctamente', data:['url' => $data['url'], 'media_id' => $result]);
        break;

    case 'update':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = $_POST;
        $data['url'] = !empty($data['url']) ? $data['url'] : null;
        if ($data['media'] !== 'undefined' && !empty($_FILES['media'])) {
            $tmp_file = $_FILES['media']['tmp_name'];
            $ext = explode(".", $_FILES['media']['name']);
            $file_name = time() . '.' . $ext[1];
            $path = DIRECTORY . "/public/media/$file_name";
            if (move_uploaded_file($tmp_file, $path)) {
                $data['url'] = "media/$file_name";
            } else {
                if (!$result) {
                    $helper->response_message('Error', 'No se pudo procesar el archivo correctamente', 'error');
                }

            }
            $result = $media->update($data);
            if (!$result) {
                $helper->response_message('Error', 'No se pudo actualizar el archivo correctamente', 'error');
            }
        } elseif (!empty($data['media_id'])) {
            $result = $media->update($data);
            if (!$result) {
                $helper->response_message('Error', 'No se pudo actualizar el archivo correctamente', 'error');
            }
        } else {
            $helper->response_message('Error', 'Debe subir un archivo antes de ser procesado', 'error');
        }

        $helper->response_message('Éxito', 'Se actualizó el archivo correctamente', data:['url' => $data['url'], 'media_id' => $result]);
        break;

    case 'delete':
        unlink(DIRECTORY . $data['url']);
        $result = $media->delete(intval($data['media_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar el archivo correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó el archivo correctamente');
        break;

}

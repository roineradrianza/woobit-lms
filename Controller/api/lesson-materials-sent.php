<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\Helper;
use Model\LessonMaterialSent;

$helper = new Helper;
$material = new LessonMaterialSent;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':
        $results = $material->get($query, !empty($data['child_id']) ? clean_string($data['child_id']) : 0);
        echo json_encode($results);
        break;

    case 'create':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        
        $sender_type = $data['sender'] == '2' ? 'student' : 'instructor';
        $tmp_file = $_FILES['material']['tmp_name'];
        $ext = explode(".", $_FILES['material']['name']);
        $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
        $folder = "lesson-materials/{$data['lesson_id']}/$sender_type";
        $path_name = "public/$folder";
        $path = DIRECTORY . "/$path_name/$file_name";
        !file_exists(DIRECTORY . "/$path_name") ? mkdir(DIRECTORY . "/$path_name", recursive: true) : '';

        $data['url'] = null;
        if (move_uploaded_file($tmp_file, $path)) {
            $data['url'] = "/$folder/$file_name";
        }

        $result = $material->update($data);
        if (!$result) {
            $helper->response_message('Error', 'Materialul nu a putut fi înregistrat corect', 'error');
        }

        $helper->response_message('Éxito', 'Materialul a fost înregistrat corect', data:['url' => $data['url'], 'material_id' => $result]);
        break;

    case 'update':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;

        $sender_type = $data['sender'] == '2' ? 'student' : 'instructor';
        $data['url'] = !empty($data['url']) ? $data['url'] : null;
        if (!empty($_FILES['material'])) {
            $tmp_file = $_FILES['material']['tmp_name'];
            $ext = explode(".", $_FILES['material']['name']);
            $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
            $folder = "lesson-materials/{$data['lesson_id']}/$sender_type";
            $path_name = "public/$folder";

            $path = DIRECTORY . "/$path_name/$file_name";
            !file_exists(DIRECTORY . "/$path_name") ? mkdir(DIRECTORY . "/$path_name", recursive: true) : '';

            if (move_uploaded_file($tmp_file, $path)) {
                unlink(DIRECTORY . "/public/{$data['url']}");
                $data['url'] = "/$folder/$file_name";
            } else {
                if (!$result) {
                    $helper->response_message('Error', 'Fișierul nu a putut fi procesat corect', 'error');
                }

            }

            $result = $material->update($data);
            if (!$result) {
                $helper->response_message('Error', 'Fișierul nu a putut fi actualizat corect', 'error');
            }

        } elseif (!empty($data['material_id'])) {

            $result = $material->update($data);
            if (!$result) {
                $helper->response_message('Error', 'Fișierul nu a putut fi actualizat corect', 'error');
            }

        } else {
            $helper->response_message('Error', 'Trebuie să încărcați un fișier înainte de procesare', 'error');
        }

        $helper->response_message('Éxito', 'Fișierul a fost actualizat cu succes', data:['url' => $data['url'], 'material_id' => $result]);
        break;

    case 'delete':

        unlink(DIRECTORY . "/public/{$data['url']}");
        $result = $material->delete(intval($data['material_id']));
        if (!$result) {
            $helper->response_message('Error', 'Fișierul nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Éxito', 'Fișierul a fost șters cu succes');
        break;

}
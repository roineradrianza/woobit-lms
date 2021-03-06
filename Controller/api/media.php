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
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $tmp_file = $_FILES['media']['tmp_name'];
        $ext = explode(".", $_FILES['media']['name']);
        $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
        $path = DIRECTORY . "/public/media/$file_name";
        $data['url'] = null;
        if (move_uploaded_file($tmp_file, $path)) {
            $data['url'] = "/media/$file_name";
        }
        $data['course_id'] = !empty($data['course_id']) ? $data['course_id'] : 'NULL';
        $data['lesson_id'] = !empty($data['lesson_id']) ? $data['lesson_id'] : 'NULL';
        $data['user_id'] = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';

        $result = $media->update($data);
        if (!$result) {
            $helper->response_message('Error', 'Materialul nu a putut fi înregistrat corect', 'error');
        }

        $helper->response_message('Éxito', 'Materialul a fost înregistrat corect', data:['url' => $data['url'], 'media_id' => $result]);
        break;

    case 'update':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $data['url'] = !empty($data['url']) ? $data['url'] : null;
        if (!empty($_FILES['media'])) {
            $tmp_file = $_FILES['media']['tmp_name'];
            $ext = explode(".", $_FILES['media']['name']);
            $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
            $path = DIRECTORY . "/public/media/$file_name";
            if (move_uploaded_file($tmp_file, $path)) {
                unlink(DIRECTORY . "/public/{$data['url']}");
                $data['url'] = "/media/$file_name";
            } else {
                if (!$result) {
                    $helper->response_message('Error', 'Fișierul nu a putut fi procesat corect', 'error');
                }

            }
            $result = $media->update($data);
            if (!$result) {
                $helper->response_message('Error', 'Fișierul nu a putut fi actualizat corect', 'error');
            }
        } elseif (!empty($data['media_id'])) {
            $result = $media->update($data);
            if (!$result) {
                $helper->response_message('Error', 'Fișierul nu a putut fi actualizat corect', 'error');
            }
        } else {
            $helper->response_message('Error', 'Trebuie să încărcați un fișier înainte de procesare', 'error');
        }

        $helper->response_message('Éxito', 'Fișierul a fost actualizat cu succes', data:['url' => $data['url'], 'media_id' => $result]);
        break;

    case 'delete':
        unlink(DIRECTORY . "/public/{$data['url']}");
        $result = $media->delete(intval($data['media_id']));
        if (!$result) {
            $helper->response_message('Error', 'Fișierul nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Éxito', 'Fișierul a fost șters cu succes');
        break;

}

<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\Helper;

use Model\Application;
use Model\Member;
use Model\MemberMeta;

$application = new Application;
$member = new Member;
$user_meta = new MemberMeta;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        $query = is_numeric($query) ? $query : $helper->decrypt($query);
        $results = $application->get($query);
        $members = [];
        if ($results > 0) {
            foreach ($results as $application) {
                $item = $application;
                $user = $member->get($application['user_id'])[0];

                $item['first_name'] = $user['first_name'];
                $item['last_name'] = $user['last_name'];

                $meta = $user_meta->get($user['user_id']);
                $item['meta'] = [];
                foreach ($meta as $i => $e) {
                    $item['meta'][$e['meta_name']] = $helper->is_json($e['meta_val']) ? $helper->clean_json($e['meta_val']) : $e['meta_val'];
                }
                $members[] = $item;
            }
        }
        echo json_encode($members);
        break;

    case 'create':
        if (empty($_SESSION['user_id'])) {
            die(403);
        } else if (empty($_POST)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $data['meta'] = isset($data['meta']) ? json_decode($data['meta'], true) : [];

        if (!empty($_FILES['id_front_file']['name'])) {
            $ext = explode(".", $_FILES['id_front_file']['name']);
            $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
            if (!move_uploaded_file($_FILES["id_front_file"]["tmp_name"], DIRECTORY . "/public/docs/ids/$file_name")) {
                $helper->response_message('Error', 'Documentul de identitate nu a putut fi salvat corect, vă rugăm să încercați din nou.', 'error');
            }
            $data['meta']['id_front_url'] = "/docs/ids/$file_name";
        }
        
        if (!empty($_FILES['id_back_file']['name'])) {
            $ext = explode(".", $_FILES['id_back_file']['name']);
            $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
            if (!move_uploaded_file($_FILES["id_back_file"]["tmp_name"], DIRECTORY . "/public/docs/ids/$file_name")) {
                $helper->response_message('Error', 'Documentul de identitate nu a putut fi salvat corect, vă rugăm să încercați din nou.', 'error');
            }
            $data['meta']['id_back_url'] = "/docs/ids/$file_name";
        }

        if (!empty($_FILES['video_file']['name'])) {
            $ext = explode(".", $_FILES['video_file']['name']);
            $file_name = "{$helper->convert_slug($ext[0])}-" . time() . '.' . end($ext);
            if (!move_uploaded_file($_FILES["video_file"]["tmp_name"], DIRECTORY . "/public/docs/personal-videos/$file_name")) {
                $helper->response_message('Error', 'Videoclipul personal nu a putut fi procesat corect, vă rugăm să încercați din nou.', 'error');
            }
            $data['meta']['video_url'] = "/docs/personal-videos/$file_name";
        }

        $user_id = $_SESSION['user_id'];

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $check_meta = $user_meta->get_meta($user_id, $meta_key);

                $meta = [
                    'meta_name' => $meta_key,
                    'meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                    'user_id' => $user_id,
                ];

                if (empty($check_meta)) {
                    $user_meta->create($meta);
                } else {
                    $user_meta->edit($user_id, $meta);
                }

            }
        }

        $data['user_id'] = $user_id;
        $data['status'] = 0;
        $application_result = $application->create($data);

        if (!$application_result) {
            $helper->response_message('Error', 'Cererea nu a putut fi procesată, vă rugăm să încercați din nou.', 'error');
        }

        $helper->response_message('Succes', 'Cererea a fost depusă ', data:[
            'application_id' => $application_result,
            'id_front_url' => !empty($data['meta']['id_front_url']) ? $data['meta']['id_front_url'] : '',
            'id_back_url' => !empty($data['meta']['id_back_url']) ? $data['meta']['id_back_url'] : '',
            'video_url' => !empty($data['meta']['video_url']) ? $data['meta']['video_url'] : '',
        ]);
        break;

    case 'update':
        if (empty($_SESSION['user_id'])) {
            die(403);
        } else if (empty($data) || empty($data['application_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }
        $id = $data['application_id'];
        $_SESSION['user_type'] == 'administrator' && isset($data['status']) ? 
        (!$application->update($id, $data) ? $helper->response_message('Error', 'Statutul nu poate fi actualizat', 'error') : '')
        : $helper->response_message('Error', 'Nu sunteți autorizat să efectuați această acțiune', 'error');

        $helper->response_message('Succes', 'Aplicația a fost actualizată cu succese');
        break;
    case 'delete':
        $result = $member->delete(intval($data['user_id']));
        if (!$result) {
            $helper->response_message('Error', 'Membrul nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Succes', 'Membru șters corect');
        break;

}

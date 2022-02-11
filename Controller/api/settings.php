<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\Setting;

use Controller\Helper;

$setting = new Setting;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $setting->get(clean_string($query));
        echo json_encode($data);
        break;

    case 'save':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data['name'] = clean_string($data['name']);

        $check_meta = $setting->get($data['name']);
        $meta_data = [
            'name' => $data['name'], 
            'val' => is_array($data['val']) ? json_encode($data['val'], JSON_UNESCAPED_UNICODE) : $data['val']
        ];
        $result = empty($check_meta) ? $result = $setting->create($meta_data) : $result = $setting->edit($meta_data);
        if (!$result) {
            $helper->response_message('Error', "Nu se poate actualiza", 'error');
        }
        $helper->response_message('Succes', 'Acesta a fost actualizat cu succes');
        break;
}

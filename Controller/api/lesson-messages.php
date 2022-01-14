<?php
/**Lesson Messages API*/
/*  @var method 
    @var query
*/
if (empty($method)) {
    die(403);
}

use Model\LessonMessages;

use Controller\Helper;

$lesson_messages = new LessonMessages;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':
        echo json_encode($lesson_messages->get($query));
        break;

    case 'create':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data['user_id'] = !is_numeric($data['user_id']) ? $helper->decrypt($data['user_id']) : $data['user_id'];
        $result = $lesson_messages->create($data);
        if (!$result) {
            $helper->response_message('Error', 'Nu a fost posibil să se adauge înregistrarea', 'error');
        }
        $helper->response_message('Éxito', 'Adăugat corect', data: [
            'id' => $result
        ]);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $id = $data['lesson_message_id'];
        $result = $lesson_messages->update($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'Nu s-a putut actualiza corect', 'error');
        }
        $helper->response_message('Éxito', 'Acesta a fost actualizat cu succes');
        break;  
     
    case 'delete':
        $result = $lesson_messages->delete($data['lesson_message_id']);
        if (!$result) {
            $helper->response_message('Error', 'Comanda nu a putut fi ștearsă cu succes', 'error');
        }

        $helper->response_message('Éxito', 'Corect șters');
        break;
}
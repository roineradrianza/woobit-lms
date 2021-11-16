<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\Notification;

use Controller\Helper;

$notification = New Notification;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {
    case 'get':
        if (empty($_SESSION['user_id'])) return [];
        $results = $notification->get_by_user($_SESSION['user_id']);
        echo json_encode($results);
        break;

	case 'mark-seen':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		foreach ($data['notifications'] as $notification_selected) {
			$result = $notification->switch_notification_status(clean_string($notification_selected['notification_id']));
		}
		$helper->response_message('Éxito', 'Notificaciones actualizadas');
		break;	

}
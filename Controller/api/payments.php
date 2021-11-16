<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\{Payment, PaymentsMeta};

use Controller\Helper;

$payment = New Payment;
$payment_meta = New PaymentsMeta;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

	case 'get':
		$results = $payment->get($query);
		$payments = [];
		if (count($results) > 0) {
			foreach ($results as $payment) {
				$result['payment_method_id'] = $payment['payment_method_id'];
				$result['name'] = $payment['name'];

				$meta = $payment_meta->get($result['payment_method_id']);
				$result['meta'] = [];
				foreach ($meta as $i => $e) {
					$result['meta'][$e['payment_method_meta_name']] = $e['payment_method_meta_val'];
				}
				$payments[] = $result;
			}
		}
		echo json_encode($payments);
		break;
	
	case 'update':
		if (empty($_POST)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data = $_POST;
		$id = intval($data['payment_method_id']);
		$data['meta'] = json_decode($data['meta'], true);
		if (isset($data['meta']) && !empty($data['meta'])) {
			foreach ($data['meta'] as $meta_key => $meta_value) {
				if (is_array($meta_value)) $meta_value = json_encode($meta_value, JSON_UNESCAPED_UNICODE);
				$meta = ['payment_method_meta_name' => $meta_key, 'payment_method_meta_val' => $meta_value, 'payment_method_id' => $id];
				$check_meta = $payment_meta->get_meta($id, $meta_key);
				if (empty($check_meta)) {
					$meta_data = ['payment_method_meta_name' => $meta_key, 'payment_method_meta_val' => $meta_value, 'payment_method_id' => $id];
					$payment_meta->create($meta_data);
					continue;
				}
				$payment_meta->edit($id, $meta);
			}
		}
		$helper->response_message('Éxito', 'Se actualizó la información correctamente');
		break;


}
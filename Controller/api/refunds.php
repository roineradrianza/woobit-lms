<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\{Orders, OrdersMeta, OrderChild, StudentCourse};

use Controller\Helper;

$student_course = New StudentCourse;
$order_child = New OrderChild;
$order = New Orders;
$order_meta = New OrdersMeta;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

	case 'paypal':
        if (empty($query) || $_SESSION['user_type'] != 'administrator') {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }
		$results = $order->get($query);
		$order_item = [];
		if (count($results) > 0) {
			foreach ($results as $result) {

				$meta = $order_meta->get($result['order_id']);
				$result['meta'] = [];
				foreach ($meta as $i => $e) {
					$result['meta'][$e['order_meta_name']] = $e['order_meta_val'];
				}
				$order_item[] = $result;
			}
            $order_item = $order_item[0];
		} else {
            $helper->response_message('Avertisment', 'Nu există niciun ordin de plată cu id-ul trimis', 'warning');
        }
        $paypal_base_url = DEV_ENV ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';
        $client = new \GuzzleHttp\Client(['base_uri' => $paypal_base_url]);
        try {
            $get_token = $client->request('POST', "/v1/oauth2/token", [
                "headers" => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'auth' => [PAYPAL_CLIENT_ID, PAYPAL_SECRET, 'basic'],
                'body' => 'grant_type=client_credentials'
            ]);
            $data = json_decode($get_token->getBody());
            $token = $data->access_token;

            try {
                $process_refund = $client->request('POST', "/v2/payments/captures/{$order_item['meta']['pp_transaction_id']}/refund", [
                    "headers" => [
                        "Authorization" => "Bearer " . $token,
                        'Content-Type' => 'application/json'
                    ]
                ]);
                $data = json_decode($process_refund->getBody());
                if ($data->status == 'COMPLETED') {
                    $order->change_status($order_item['order_id'], 3);
                    $order_childs = $order_child->get_by_order($order_item['order_id']);
                    foreach ($order_childs as $enrollment) {
                        $student_course->delete_by_enrollment($enrollment['course_user_id']);
                    }
                }
                $meta_info = [
                    'pp_refund_id' => $data->id, 
                    'pp_refund_status' => $data->status,
                    'pp_refund_create_time' => gmdate(DATE_W3C)
                ];
                foreach ( $meta_info as $meta_key => $meta_value) {
                    $meta = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value];
                    $id = $order_item['order_id'];
                    $check_meta = $order_meta->get_meta($id, $meta_key);
                    if (empty($check_meta)) {
                        $meta_data = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $id];
                        $order_meta->create($meta_data);
                        continue;
                    }
                    $order_meta->edit($id, $meta);
                }
                $helper->response_message('Success', 'Ordinul de plată a fost rambursat', data: $meta_info);
            } catch (\Exception $e) {
                $helper->response_message(
                    'Error', 
                    'Ordinul de plată nu a putut fi rambursat, încercați din nou.', 
                    'error', 
                    $e->getCode()
                );
            }
            
        } catch (\Exception $e) {
            $helper->response_message(
                'Error', 
                'Nu a putut fi obținut simbolul pentru procesarea ordinului de rambursare, verificați-vă acreditările și încercați din nou.',
                'error', 
                $e->getCode()
            );
        }
		break;

}
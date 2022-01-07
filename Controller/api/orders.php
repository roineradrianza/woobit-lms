<?php
/**Orders API*/
/*@var method @var query*/
if (empty($method)) {
    die(403);
}

use Controller\Helper;
use Model\Course;
use Model\Member;
use Model\Notification;
use Model\Orders;
use Model\OrdersMeta;

use Model\StudentCourse;

$member = new Member;
$student_course = new StudentCourse;
$order = new Orders;
$order_meta = new OrdersMeta;
$course = new Course;
$notification = new Notification;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':
        $results = $order->get($query);
        $orders = [];
        $timezone = new DateTimeZone($data['timezone']);
        if (count($results) > 0) {
            foreach ($results as $order) {
                $datetime = new DateTime($order['registered_at']);
                $datetime = $datetime->setTimezone($timezone);
                $meta = $order_meta->get($order['order_id']);
                $order['amount'] = number_format($order['total_pay'], 2, '.', '') . " RON";
                $order['registered_at'] = $datetime->format('Y-m-d H:i:s');
                $order['meta'] = [];
                $order['instructor'] = $member->get($course->get($order['course_id'])[0]['user_id'], ['user_id', 'first_name', 'last_name'])[0];
                foreach ($meta as $i => $e) {
                    $order['meta'][$e['order_meta_name']] = $e['order_meta_val'];
                }
                $orders[] = $order;
            }
        }
        echo json_encode($orders);
        break;

    case 'get-my-orders':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $query = $helper->decrypt($query);
        $query = intval($query);
        $results = $order->get_my_orders($query);
        $orders = [];
        $timezone = new DateTimeZone($data['timezone']);
        if (count($results) > 0) {
            foreach ($results as $order) {
                $datetime = new DateTime($order['registered_at']);
                $datetime = $datetime->setTimezone($timezone);
                $meta = $order_meta->get($order['order_id']);
                $order['amount'] = number_format($order['total_pay'], 2, '.', '') . " RON";
                $order['registered_at'] = $datetime->format('Y-m-d H:i:s');
                $order['meta'] = [];
                $order['instructor'] = $member->get($course->get($order['course_id'])[0]['user_id'], ['user_id', 'first_name', 'last_name'])[0];
                foreach ($meta as $i => $e) {
                    $order['meta'][$e['order_meta_name']] = $e['order_meta_val'];
                }
                $orders[] = $order;
            }
        }
        echo json_encode($orders);
        break;

    case 'get-course-orders':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }
        $query = clean_string($query);
        $results = $order->get_course_orders(course_id:$query, order_type:'', status:1);
        $orders = [];
        $timezone = new DateTimeZone($data['timezone']);
        if (count($results) > 0) {
            foreach ($results as $order) {
                $datetime = new DateTime($order['registered_at']);
                $datetime = $datetime->setTimezone($timezone);
                $meta = $order_meta->get($order['order_id']);
                $order['amount'] = '$ ' . number_format($order['total_pay'], 2, '.', '');
                $order['registered_at'] = $datetime->format('Y-m-d H:i:s');
                $order['meta'] = [];
                foreach ($meta as $i => $e) {
                    $order['meta'][$e['order_meta_name']] = $e['order_meta_val'];
                }
                $orders[] = $order;
            }
        }
        echo json_encode($orders);
        break;

    case 'create':
        if (empty($data) || empty($data['course_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data['user_id'] = $_SESSION['user_id'];
        $data['status'] = 1;
        $result = $order->create($data);
        if (!$result) {
            $helper->response_message('Error', 'Ordinul de plată nu a putut fi creat corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $result];
                $order_meta->create($meta);
            }
        }
        if ($data['payment_method'] == 'Paypal' && $data['type'] == 1) {
            $user_id = $_SESSION['user_id'];
            foreach ($data['children'] as $child) {
                $has_enroll = $student_course->has_enroll($data['course_id'], $child['children_id']);
                if (empty($has_enroll)) {
                    $enrollment = $student_course->create(
                        [
                            'course_id' => $data['course_id'], 
                            'children_id' => $child['children_id'],
                            'section_id' => $data['section']['section_id'],
                        ]
                    );
                    if ($enrollment) {
                        $full_name = "{$child['first_name']} {$child['last_name']}";
                        $notification_data = [
                            'description' => "$full_name a fost înscrisă la curs:
                                <b>{$data['meta']['course']}</b>",
                            'course_id' => $data['course_id'],
                            'user_id' => $user_id,
                        ];
                        $notification->create($notification_data);
                    }
                }
            }

        }
        $helper->response_message('Succes', 'Plata a fost efectuată corect');
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $id = intval($data['order_id']);
        $data['slug'] = $helper->convert_slug($data['title']);
        $data['active'] = intval($data['active']);
        $data['user_id'] = intval($data['user_id']);
        $data['price'] = floatval($data['price']);
        $result = $order->edit($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'Ordinul de plată nu a putut fi editat corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            $data['meta'] = json_decode($data['meta'], true);
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value];
                $check_meta = $order_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $id];
                    $order_meta->create($meta_data);
                    continue;
                }
                $order_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Succes', 'Ordinul de plată a fost editat corect');
        break;

    case 'update-meta':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $id = intval($data['order_id']);
        $data['meta'] = json_decode($data['meta'], true);
        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                if (is_array($meta_value)) {
                    $meta_value = json_encode($meta_value, JSON_UNESCAPED_UNICODE);
                }

                $meta = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $id];
                $check_meta = $order_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $id];
                    $order_meta->create($meta_data);
                    continue;
                }
                $order_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Succes', 'Informațiile au fost actualizate corect');
        break;

    case 'delete':
        $result = $order->delete(intval($data['order_id']));
        if (!$result) {
            $helper->response_message('Error', 'Ordinul de plată nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Succes', 'Ordinul de plată a fost șters corect');
        break;
}

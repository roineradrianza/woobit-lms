<?php
/**Orders API*/
/*@var method @var query*/
if (empty($method)) {
    die(403);
}

use Model\{Member, StudentCourse, Orders, Notification, OrdersMeta, Course};

use Controller\Helper;

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

    case 'get-my-orders':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
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

    case 'get-course-orders':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $query = clean_string($query);
        $results = $order->get_course_orders(course_id: $query, order_type: '', status: 1);
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
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data = sanitize($data);
        $data['user_id'] = $_SESSION['user_id'];
        $data['status'] = $data['payment_method'] == 'Zelle' 
        || $data['payment_method'] == 'Bank Transfer(Bs)' 
        || $data['payment_method'] == 'PagoMovil' ? 0 : 1;
        $data['total_pay_bs_formatted'] = $data['payment_method'] == 'Bank Transfer(Bs)' 
            || $data['payment_method'] == 'PagoMovil' ? 
            number_format($data['meta']['total_pay_bs'] + ($data['meta']['total_pay_bs'] * 0.16), 2) . ' Bs.S' : '';
        $result = $order->create($data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo crear la orden correctamente', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = ['order_meta_name' => $meta_key, 'order_meta_val' => $meta_value, 'order_id' => $result];
                $order_meta->create($meta);
            }
        }
        if ($data['payment_method'] == 'Zelle' || $data['payment_method'] == 'Bank Transfer(Bs)' || $data['payment_method'] == 'PagoMovil') {
            
            $admins = $member->get_by_admins();
            $recipients = [];
            $data['order_id'] = $result;
            foreach ($admins as $admin) {
                $recipient = ['email' => $admin['email'],
                    'full_name' => $admin['first_name']
                    . " " . $admin['last_name']];
                $recipients[] = $recipient;
            }
            $template = new Template('email_templates/order_processing', $data);
            $sendEmail = $helper->send_mail(
                'Nueva Orden Pendiente',
                $recipients,
                $template
            );
        } else if ($data['payment_method'] == 'Paypal') {
            $user_id = $_SESSION['user_id'];
            $has_enroll = $student_course->has_enroll($data['course_id'], $user_id);
            if ($data['type'] == 1) {
                if (empty($has_enroll)) {
                    $enrollment = $student_course->create(['user_rol' => 'estudiante', 'course_id' => $data['course_id'], 'user_id' => $user_id]);
                    if ($enrollment) {
                        $notification_data = [
                            'description' => "Te has inscrito correctamente al curso:
							<b>{$data['meta']['course']}</b>",
                            'course_id' => $data['course_id'],
                            'user_id' => $user_id,
                        ];
                        $notification->create($notification_data);
                    }
                }
            } else if ($data['type'] == 2) {
                $notification_data = [
                    'description' => "Pago procesado exitosamente:
					<b>{$data['meta']['course']}</b>",
                    'course_id' => $data['course_id'],
                    'user_id' => $user_id,
                ];
                $notification->create($notification_data);
            }
        }
        $helper->response_message('Éxito', 'Se creó la orden correctamente');
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $id = intval($data['order_id']);
        $data['slug'] = $helper->convert_slug($data['title']);
        $data['active'] = intval($data['active']);
        $data['user_id'] = intval($data['user_id']);
        $data['price'] = floatval($data['price']);
        $result = $order->edit($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar la orden correctamente', 'error');
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
        $helper->response_message('Éxito', 'Se editó la orden correctamente');
        break;

    case 'update-meta':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
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
        $helper->response_message('Éxito', 'Se actualizó la información correctamente');
        break;

    case 'approve':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $id = clean_string($query);
        $result = $order->change_status($id, 1);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo aprobar la orden, intente de nuevo.');
        }
        if (intval($data['type']) == 1) {
            $has_enroll = $student_course->has_enroll($data['course_id'], $data['user_id']);
            if (empty($has_enroll)) {
                $enrollment = $student_course->create(['user_rol' => 'estudiante', 'course_id' => $data['course_id'], 'user_id' => $data['user_id']]);
                if ($enrollment) {
                    $notification_data = [
                        'description' => "Te has inscrito correctamente al curso: <b>{$data['course_title']}</b>",
                        'course_id' => $data['course_id'],
                        'user_id' => $data['user_id'],
                    ];
                    $notification->create($notification_data);
                }
            }
        } else if ($data['type'] == 2) {
            $notification_data = [
                'description' => "Pago procesado exitosamente:
                <b>{$data['course_title']}</b>",
                'course_id' => $data['course_id'],
                'user_id' => $data['user_id'],
            ];
            $notification->create($notification_data);
        }
        $course_info = $course->get($data['course_id']);
        $data['course'] = $course_info[0];
        $template = new Template('email_templates/order_approved', $data);
        $sendEmail = $helper->send_mail(
            'Orden de Pago Aprobada',
            [
                [
                    'full_name' => "{$data['meta']['first_name']} {$data['meta']['first_name']}",
                    'email' => $data['meta']['user_email'],
                ]
            ],
            $template
        );
        $helper->response_message('Éxito', 'Se aprobó la orden correctamente');
        break;

    case 'reject':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $id = clean_string($query);
        $result = $order->change_status($id, 2);
        $order->edit_note($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo rechazar la orden, intente de nuevo.');
        }
        if (intval($data['type']) == 1) {
            $notification_data = [
                'description' => "Se ha rechazado el pago de la inscripción al curso: <b>{$data['course_title']}</b>",
                'course_id' => $data['course_id'],
                'user_id' => $data['user_id'],
            ];
            $notification->create($notification_data);
        } else if ($data['type'] == 2) {
            $notification_data = [
                'description' => "Pago rechazado:
                <b>{$data['course_title']}</b>",
                'course_id' => $data['course_id'],
                'user_id' => $data['user_id'],
            ];
            $notification->create($notification_data);
        }
        $course_info = $course->get($data['course_id']);
        $data['course'] = $course_info[0];
        $template = new Template('email_templates/order_rejected', $data);
        $sendEmail = $helper->send_mail(
            'Orden de Pago Rechazada',
            [
                [
                    'full_name' => "{$data['meta']['first_name']} {$data['meta']['first_name']}",
                    'email' => $data['meta']['user_email'],
                ]
            ],
            $template
        );
        $helper->response_message('Éxito', 'Se rechazó la orden correctamente');
        break;       
    case 'delete':
        $result = $order->delete(intval($data['order_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la orden correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la orden correctamente');
        break;
}
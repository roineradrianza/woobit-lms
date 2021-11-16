<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);
use Model\{Coupon, StudentCoupon, StudentCourse};

use Controller\Helper;

$coupon = New Coupon;
$student_coupon = New StudentCoupon;
$student_course = New StudentCourse;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {
	case 'get':
		$results = $coupon->get($query);
		echo json_encode($results);
		break;

	case 'get-by-course':
		$results = $coupon->get_by_course($query);
		echo json_encode($results);
		break;

	case 'apply-coupon':
		if (empty($data) || empty($data['course_id'] || empty($data['coupon_code']))) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$results = $student_coupon->get($query, clean_string($data['coupon_code']));
		if (!empty($results[0])) {
			$result = $results[0];
			if (intval($result['already_used'])) $helper->response_message('Advertencia', 'El cupón ya ha sido aplicado', 'warning');
			$course_coupon = $coupon->get($result['coupon_id']);
			$course_coupon = $course_coupon[0];
			$student_info = [
				'course_id' => $data['course_id'],
				'user_id' => $result['user_id'],
				'user_rol' => $course_coupon['student_rol']
			];
			if ($course_coupon['discount'] >= 100) {
				$cupon_applied = $student_course->create($student_info);
				if (!$cupon_applied) $helper->response_message('Error', 'No se aplicó el cupón correctamente, intenta de nuevo', 'success');
				$student_coupon->disable_coupon($data['coupon_code']);
				$helper->response_message('Éxito', 'Te has inscrito al curso! Espera un momento', 'success');
			}
			$student_coupon->disable_coupon(clean_string($data['coupon_code']));

			$helper->response_message('Éxito', 'Se ha aplicado el descuento', 'success');
		}
		else {
			$results = $coupon->get_by_name(clean_string($data['course_id']), clean_string($data['coupon_code']));
			if (empty($results[0])) $helper->response_message('Advertencia', 'El cupón no existe o ha caducado', 'error');
			$course_coupon = $results[0];
			if ($course_coupon['discount'] >= 100) {
				$student_info = [
					'course_id' => $data['course_id'],
					'user_id' => $_SESSION['user_id'],
					'user_rol' => $course_coupon['student_rol']
				];
				$cupon_applied = $student_course->create($student_info);
				if (!$cupon_applied) $helper->response_message('Error', 'No se aplicó el cupón correctamente, intenta de nuevo', 'success');
				$helper->response_message('Éxito', 'Te has inscrito al curso! Espera un momento', 'success');
			}	
		}
		$helper->response_message('Advertencia', 'El cupón no existe o ha caducado', 'error');
		break;

	case 'create':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data['course_id'] = intval($data['course_id']);
		$data['discount'] = floatval($data['discount']);
		$result = $coupon->create(sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo registrar el cupón correctamente', 'error');
		$helper->response_message('Éxito', 'Se registró el cupón correctamente', data: ['coupon_id' => $result]);
		break;

	case 'update':
		if (empty($data)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$coupon_id = intval($data['coupon_id']);
		$result = $coupon->edit($coupon_id, sanitize($data));
		if (!$result) $helper->response_message('Error', 'No se pudo editar el cupón correctamente', 'error');
		$helper->response_message('Éxito', 'Se editó el cupón correctamente');
		break;	

	case 'delete':
		$result = $coupon->delete(intval($data['coupon_id']));
		if (!$result) $helper->response_message('Error', 'No se pudo eliminar el cupón correctamente', 'error');
		$helper->response_message('Éxito', 'Se eliminó el cupón correctamente');
		break;
}
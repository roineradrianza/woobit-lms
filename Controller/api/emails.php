<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\{Course, Member, Coupon, StudentCoupon, CourseMeta, CourseCertified};

use Controller\{Helper, Template};

$course = New Course;
$coupon = New Coupon;
$member = New Member;
$student_coupon = New StudentCoupon;
$course_meta = New CourseMeta;
$course_certified = New CourseCertified;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);


switch ($method) {

	case 'send-coupons-codes':
		if (empty($_POST) || empty($_POST['students']) || empty($_POST['coupon'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data = $_POST;
		$files = [];
		$data['course'] = json_decode($data['course'], true);
		$data['students'] = json_decode($data['students'], true);
		$data['coupon'] = json_decode($data['coupon'], true);
		$coupon_id = $data['coupon']['coupon_id'];
		$errors = [];
		if (!empty($_FILES)) {
			$tmp_file = $_FILES['attachment']['tmp_name'];
			$ext = explode(".", $_FILES['attachment']['name']);
			$file_name = $helper->convert_slug($ext[0]) . '-' . time() .'.' . $ext[1];
			$path = DIRECTORY . "/public/uploads/$file_name";
			if (!move_uploaded_file($tmp_file, $path)) $helper->response_message('Error', 'No se pudo subir el archivo ' . $_FILES['attachment']['name'], 'error');
			$files[] = ['url' => $path, 'name' => $_FILES['attachment']['name']];
		}
		foreach ($data['students'] as $student) {
			$coupon_code = $coupon_id . $helper->rand_string(5) . time();
			$student_data = [
				'user_id' => $student['user_id'],
				'coupon_code' => $coupon_code,
				'coupon_id' => $coupon_id,
			];
			if($student_coupon->create($student_data)) {
				$template_data = [
					'full_name' => $student['first_name'] . ' ' . $student['last_name'],
					'coupon_code' => $coupon_code,
					'coupon_discount' => $data['coupon']['discount'] . '%',
					'course' => $data['course'],
					'course_sponsors' => $course_meta->get_meta($data['course']['course_id'], 'sponsors_logo_email_url'),
					'content' => $data['content']
				];
				$template = new Template('email_templates/coupon_codes', $template_data);
				$sendEmail = $helper->send_mail($data['title'], [['email' => $student['email'], 'full_name' => $template_data['full_name']]], $template, $files);
				if (!$sendEmail) $errors[] = 'No se pudo enviar el cupón de descuento a ' . $template_data['full_name'];
			}
			else {
				$errors[] = 'No se pudo generar el cupón para ' . $student['first_name'] . ' ' . $student['last_name'];
			}
		}
		if (!empty($files)) {
			foreach ($files as $file) {
				unlink($file['url']);
			}
		}
		$helper->response_message('Éxito', 'Se procesó la solicitud correctamente', data: ['errors' => $errors]);
		break;

	case 'send-coupons-codes-and-register':
		if (empty($_POST) || empty($_POST['students']) || empty($_POST['coupon'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data = $_POST;
		$files = [];
		$data['students'] = json_decode($data['students'], true);
		$data['coupon'] = json_decode($data['coupon'], true);
		$data['course'] = json_decode($data['course'], true);
		$coupon_id = $data['coupon']['coupon_id'];
		$errors = [];
		if (!empty($_FILES)) {
			$tmp_file = $_FILES['attachment']['tmp_name'];
			$ext = explode(".", $_FILES['attachment']['name']);
			$file_name = $helper->convert_slug($ext[0]) . '-' . time() .'.' . $ext[1];
			$path = DIRECTORY . "/public/uploads/$file_name";
			if (!move_uploaded_file($tmp_file, $path)) $helper->response_message('Error', 'No se pudo subir el archivo ' . $_FILES['attachment']['name'], 'error');
			$files[] = ['url' => $path, 'name' => $_FILES['attachment']['name']];
		}
		$errors = [];
		foreach ($data['students'] as $student) {
			$full_name = !empty($student['full_name']) ? $member->get_full_name($student['full_name']) : $member->get_full_name();
			$student['first_name'] = isset($full_name['first_name']) ? $full_name['first_name'] : '';
			$student['last_name'] = isset($full_name['last_name']) ? $full_name['last_name'] : '';
			$coupon_code = $coupon_id . $helper->rand_string(4) . time();
			$check_student = $member->search_user($student['email']);
			if (!empty($check_student[0])) {
				$student = $check_student[0];
				$student_data = [
					'user_id' => $student['user_id'],
					'coupon_code' => $coupon_code,
					'coupon_id' => $coupon_id,
				];
				if($student_coupon->create($student_data)) {
					$template_data = [
						'full_name' => $student['first_name'] . ' ' . $student['last_name'],
						'email' => $student['email'],
						'coupon_code' => $coupon_code,
						'coupon_discount' => $data['coupon']['discount'] . '%',
						'course' => $data['course'],
						'course_sponsors' => $course_meta->get_meta($data['course']['course_id'], 'sponsors_logo_email_url'),
						'content' => $data['content']
					];
					$template = new Template('email_templates/coupon_codes', $template_data);
					$sendEmail = $helper->send_mail($data['title'], [['email' => $student['email'], 'full_name' => $template_data['full_name']]], $template, $files);
					if (!$sendEmail) $errors[] = 'No se pudo enviar el cupón de descuento a ' . $template_data['full_name'];
				}
				else {
					$errors[] = 'No se pudo generar el cupón para ' . $student['first_name'] . ' ' . $student['last_name'];
				}
			}
			else{
				$student['password'] = '12345';
				$register = $member->create_just_email($student);
				if (!$register) {
					$errors[] = "No se pudo registrar a " . $student['first_name'] . " " . $student['last_name'] . '(' . $student['email'] .')';
					continue;
				}
				$coupon_code = $coupon_id . $helper->rand_string(4) . time();
				$student_data = [
					'user_id' => $register,
					'coupon_code' => $coupon_code,
					'coupon_id' => $coupon_id,
				];
				if($student_coupon->create($student_data)) {
					$template_data = [
						'full_name' => $student['first_name'] . ' ' . $student['last_name'],
						'email' => $student['email'],
						'password' => $student['password'],
						'coupon_code' => $coupon_code,
						'coupon_discount' => $data['coupon']['discount'] . '%',
						'course' => $data['course'],
						'course_sponsors' => $course_meta->get_meta($data['course']['course_id'], 'sponsors_logo_email_url'),
						'content' => $data['content']
					];
					$template = new Template('email_templates/coupon_codes_and_credentials', $template_data, $files);
					$sendEmail = $helper->send_mail($data['title'], [['email' => $student['email'], 'full_name' => $template_data['full_name']]], $template);
					if (!$sendEmail) $errors[] = 'No se pudo enviar el cupón de descuento a ' . $template_data['full_name'];
				}
				else {
					$errors[] = 'No se pudo generar el cupón para ' . $student['first_name'] . ' ' . $student['last_name'];
				}
			}
		}
		if (!empty($files)) {
			foreach ($files as $file) {
				unlink($file['url']);
			}
		}
		$helper->response_message('Éxito', 'Se procesó la solicitud correctamente', data: ['errors' => $errors]);
		break;

	case 'send-custom-email':
		if (empty($_POST) && !empty($_POST['students'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$data = $_POST;
		$files = [];
		$data['students'] = json_decode($data['students'], true);
		$errors = [];
		if (!empty($_FILES)) {
			$tmp_file = $_FILES['attachment']['tmp_name'];
			$ext = explode(".", $_FILES['attachment']['name']);
			$file_name = $helper->convert_slug($ext[0]) . '-' . time() .'.' . $ext[1];
			$path = DIRECTORY . "/public/uploads/$file_name";
			if (!move_uploaded_file($tmp_file, $path)) $helper->response_message('Error', 'No se pudo subir el archivo ' . $_FILES['attachment']['name'], 'error');
			$files[] = ['url' => $path, 'name' => $_FILES['attachment']['name']];
		}
		foreach ($data['students'] as $student) {
			$student_data = [
				'full_name' => !empty($student['first_name']) ? $student['first_name'] . ' ' . $student['last_name'] : '',
				'email' => $student['email']
			];
			$template = new Template('email_templates/custom_message', ['content' => $data['content']]);
			$sendEmail = $helper->send_mail($data['title'], [['email' => $student['email'], 'full_name' => $student_data['full_name']]], $template, $files);
			if (!$sendEmail) $errors[] = 'No se pudo enviar el correo electrónico' . $student_data['full_name'] + '('. $student_data['email'] .')';
		}
		if (!empty($files)) {
			foreach ($files as $file) {
				unlink($file['url']);
			}
		}
		$helper->response_message('Éxito', 'Se procesó la solicitud correctamente', data: ['errors' => $errors]);
		break;

	case 'remind-users-pending':
		if (empty($data) || empty($data['course_id']) || empty($data['students'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$course_selected = $course->get(clean_string($data['course_id']));
		if (empty($course_selected[0])) $helper->response_message('Error', 'El curso seleccionado no existe', 'error');
		$course_selected = $course_selected[0];
		$errors = [];
		if (count($data['students']) == 1) {
			$student = $data['students'][0];
			$coupon_enabled = $student_coupon->get_enabled_coupons(clean_string($student['user_id']), clean_string($data['course_id']));
			if (empty($coupon_enabled[0])) {
				$helper->response_message('Error', 'No se encontró el cupón de descuento del 100% que corresponda a este usuario', 'error');
			}
			$coupon_enabled = $coupon_enabled[0];
			$template_data = [
				'title' => 'Recordatorio de inscripción a ' . $course_selected['title'],
				'coupon' => $coupon_enabled,
				'email' => $student['email'],
				'full_name' => $student['full_name'],
				'course' => $course_selected,
				'course_sponsors' => $course_meta->get_meta($course_selected['course_id'], 'sponsors_logo_email_url'),
			];
			if (empty($student['username']) || empty($student['meta'])) {
				$student['password'] = '12345';
				$member->edit_password(clean_string($student['user_id']), $student['password']);
				$template_data['password'] = $student['password'];
			}
			$template = new Template('email_templates/enrollment_reminder', $template_data);
			$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
		}
		else {
			foreach ($data['students'] as $student) {
				$coupon_enabled = $student_coupon->get_enabled_coupons($student['user_id'], clean_string($data['course_id']));
				if (empty($coupon_enabled[0])) {
					$errors[] = 'No se encontró de descuento del 100% que corresponda a este usuario';
					continue;
				}
				$coupon_enabled = $coupon_enabled[0];
				$template_data = [
					'title' => 'Recordatorio de inscripción a ' . $course_selected['title'],
					'coupon' => $coupon_enabled,
					'email' => $student['email'],
					'full_name' => $student['full_name'],
					'course' => $course_selected,
					'course_sponsors' => $course_meta->get_meta($course_selected['course_id'], 'sponsors_logo_email_url'),
				];
				if (empty($student['username']) || empty($student['meta'])) {
					$student['password'] = '12345';
					$member->edit_password(clean_string($student['user_id']), $student['password']);
					$template_data['password'] = $student['password'];
				}
				$template = new Template('email_templates/enrollment_reminder', $template_data);
				$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
			}
		}
		$helper->response_message('Éxito', 'Se envió el correo recordatorio al/los usuario/s', data: $errors);
		break;
	
	case 'remind-instructors-pending':
		if (empty($data) || empty($data['course_id']) || empty($data['students'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$course_selected = $course->get(clean_string($data['course_id']));
		if (empty($course_selected[0])) $helper->response_message('Error', 'El curso seleccionado no existe', 'error');
		$course_selected = $course_selected[0];
		$errors = [];
		if (count($data['students']) == 1) {
			$student = $data['students'][0];
			$coupon_enabled = $student_coupon->get_enabled_coupons(clean_string($student['user_id']), clean_string($data['course_id']));
			if (empty($coupon_enabled[0])) {
				$helper->response_message('Error', 'No se encontró el cupón de descuento del 100% que corresponda a este usuario', 'error');
			}
			$coupon_enabled = $coupon_enabled[0];
			$template_data = [
				'title' => 'Recordatorio de inscripción a ' . $course_selected['title'],
				'coupon' => $coupon_enabled,
				'email' => $student['email'],
				'full_name' => $student['full_name'],
				'course' => $course_selected,
				'course_sponsors' => $course_meta->get_meta($course_selected['course_id'], 'sponsors_logo_email_url'),
			];
			if (empty($student['username']) || empty($student['meta'])) {
				$student['password'] = '12345';
				$member->edit_password(clean_string($student['user_id']), $student['password']);
				$template_data['password'] = $student['password'];
			}
			$template = new Template('email_templates/instructor_enrollment_reminder', $template_data);
			$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
		}
		else {
			foreach ($data['students'] as $student) {
				$coupon_enabled = $student_coupon->get_enabled_coupons($student['user_id'], clean_string($data['course_id']));
				if (empty($coupon_enabled[0])) {
					$errors[] = 'No se encontró de descuento del 100% que corresponda a este usuario';
					continue;
				}
				$coupon_enabled = $coupon_enabled[0];
				$template_data = [
					'title' => 'Recordatorio de inscripción a ' . $course_selected['title'],
					'coupon' => $coupon_enabled,
					'email' => $student['email'],
					'full_name' => $student['full_name'],
					'course' => $course_selected,
					'course_sponsors' => $course_meta->get_meta($course_selected['course_id'], 'sponsors_logo_email_url'),
				];
				if (empty($student['username']) || empty($student['meta'])) {
					$student['password'] = '12345';
					$member->edit_password(clean_string($student['user_id']), $student['password']);
					$template_data['password'] = $student['password'];
				}
				$template = new Template('email_templates/instructor_enrollment_reminder', $template_data);
				$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
			}
		}
		$helper->response_message('Éxito', 'Se envió el correo recordatorio al/los usuario/s', data: ['errors' => $errors]);
		break;
	
	case 'remind-users-course-progress':
		if (empty($data) || empty($data['course_id']) || empty($data['students'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$course_selected = $course->get(clean_string($data['course_id']));
		if (empty($course_selected[0])) $helper->response_message('Error', 'El curso seleccionado no existe', 'error');
		$course_selected = $course_selected[0];
		$errors = [];
		if (count($data['students']) == 1) {
			$student = $data['students'][0];
			$template_data = [
				'title' => "Retoma '{$course_selected['title']}' donde lo dejaste",
				'email' => $student['email'],
				'full_name' => $student['full_name'],
				'course' => $course_selected,
			];
			$template = new Template('email_templates/user_course_progress_reminder', $template_data);
			$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
		}
		else {
			foreach ($data['students'] as $student) {
				$coupon_enabled = $coupon_enabled[0];
				$template_data = [
					'title' => "Retoma '{$course_selected['title']}' donde lo dejaste",
					'email' => $student['email'],
					'full_name' => $student['full_name'],
					'course' => $course_selected,
				];
				$template = new Template('email_templates/user_course_progress_reminder', $template_data);
				$sendEmail = $helper->send_mail($template_data['title'], [['email' => $template_data['email'], 'full_name' => $template_data['full_name']]], $template);
			}
		}
		$helper->response_message('Éxito', 'Se envió el correo recordatorio al/los usuario/s', data: ['errors' => $errors]);
		break;

}
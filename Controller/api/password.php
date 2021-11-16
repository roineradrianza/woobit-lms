<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

use Model\Member;

use Controller\Helper;

$member = New Member;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

	case 'request-reset':
		if (empty($data['email'])) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$email = clean_string($data['email']);
		if (!$member->check_exist_credential($email)) $helper->response_message('Error', 'No hay ningún usuario registrado con el correo electrónico', 'warning');
		$reset_code = $helper->rand_string(5) . time();
		$member->set_reset_code($email, $reset_code);
		$template_data = ['reset_code' => $reset_code];
		$template = new Template('email_templates/recover_password', $template_data);
		$sendEmail = $helper->send_mail('Solicitud de restablecimiento de contraseña', [['email' => $email, 'full_name' => '']], $template);
		if (!$sendEmail) $helper->response_message('Advertencia', 'Se ha enviado un mensaje a tu correo electrónico para continuar con el reestablecimiento de tu contraseña', 'warning');
		$helper->response_message('Éxito', 'Se ha enviado un mensaje a tu correo electrónico para continuar con el reestablecimiento de tu contraseña', 'success');
		break;

	case 'reset':
		if (empty($query)) $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
		$reset_code = clean_string($query);
		if (!$member->check_exist_reset_code($reset_code)) $helper->response_message('Error', 'No hay ningún usuario asociado con el código de reestablecimiento, solicite nuevamente uno nuevo', 'error');
		$result = $member->reset_password(clean_string($data['password']), $reset_code);
		if(!$result) $helper->response_message('Error', 'No se pudo establecer la nueva contraseña, intente nuevamente', 'error');
		$helper->response_message('Éxito', 'Se ha reestablecido tu contraseña correctamente, se le redirigirá en un momento a la página de inicio de sesión...', 'success');
		break;

}
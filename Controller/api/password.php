<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\{Helper, Template};
use Model\Member;

$member = new Member;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'request-reset':
        if (empty($data['email'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $email = clean_string($data['email']);
        if (!$member->check_exist_credential($email)) {
            $helper->response_message('Avertisment', 'Nu există niciun utilizator înregistrat cu adresa de e-mail', 'warning');
        }

        $reset_code = $helper->rand_string(5) . time();
        $member->set_reset_code($email, $reset_code);
        $template_data = ['reset_code' => $reset_code];
        $template = new Template('email_templates/recover_password', $template_data);
        $sendEmail = $helper->send_mail('Cerere de resetare a parolei', [['email' => $email, 'full_name' => '']], $template);
        if (!$sendEmail) {
            $helper->response_message('Error', 'Nu s-a putut trimite e-mail de resetare, încercați din nou', 'error');
        }

        $helper->response_message('Succes', 'Un mesaj a fost trimis la adresa dvs. de e-mail pentru a continua cu resetarea parolei.', 'success');
        break;

    case 'reset':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $reset_code = clean_string($query);
        if (!$member->check_exist_reset_code($reset_code)) {
            $helper->response_message('Error', 'Nu există niciun utilizator asociat cu codul de resetare, solicitați din nou unul nou.', 'error');
        }

        $result = $member->reset_password(clean_string($data['password']), $reset_code);
        if (!$result) {
            $helper->response_message('Error', 'Parola nouă nu a putut fi setată, încercați din nou.', 'error');
        }

        $helper->response_message('Succes', 'Parola dvs. a fost resetată cu succes, veți fi redirecționat către pagina de conectare în câteva momente...', 'success');
        break;

}

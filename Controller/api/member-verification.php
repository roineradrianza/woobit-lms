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

    case 'request':
        if (empty($_SESSION['email'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $email = $_SESSION['email'];
        $user_id = $_SESSION['user_id'];

        if (!$member->check_exist_credential($email)) {
            $helper->response_message('Avertisment', 'Nu există niciun utilizator înregistrat cu adresa de e-mail', 'warning');
        }

        $verification_code = "$user_id{$helper->rand_string(25)}" . time();
        $member->set_verification_code($email, $verification_code);
        $template_data = ['verification_code' => $verification_code];
        $template = new Template('email_templates/verification_code', $template_data);
        $sendEmail = $helper->send_mail('Verifică adresa de e-mail', [['email' => $email, 'full_name' => '']], $template);
        if (!$sendEmail) {
            $helper->response_message('Error', 'Nu s-a putut trimite e-mail de resetare, încercați din nou', 'error');
        }

        $helper->response_message('Succes', 'Un mesaj a fost trimis la adresa dvs. de e-mail cu instrucțiuni pentru a vă verifica contul.', 'success');
        break;

    case 'verify':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $verification_code = clean_string($query);
        if (!$member->check_exist_verification_code($verification_code)) {
            $helper->response_message('Error', 'Nu există niciun cont asociat cu codul de verificare utilizat, vă rugăm să încercați din nou.', 'error');
        }

        $result = $member->activate($_SESSION['user_id']);
        if (!$result) {
            $helper->response_message('Error', 'Contul nu a putut fi verificat, vă rugăm să încercați din nou.', 'error');
        }

        $_SESSION['verified'] = 1;

        $helper->response_message('Succes', 'Contul dvs. a fost verificat cu succes, vă puteți utiliza acum contul în mod normal.', 'success');
        break;

}

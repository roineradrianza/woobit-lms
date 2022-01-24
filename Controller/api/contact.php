<?php
/**Orders API*/
/*@var method @var query*/
if (empty($method)) {
    die(403);
}

use Controller\{Helper, Template};

$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'send-message':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }
        $data = sanitize($data);
        $template = new Template('email_templates/contact_form', $data);
        $sendEmail = $helper->send_mail(
            'Mesaj primit de la formularul de contact', 
            [
                ['email' => 'veronica@woobit.ro', 'full_name' => 'Veronica'],
                ['email' => 'marcelmarin256@gmail.com', 'full_name' => 'Marcel Marin'],
            ], 
            $template, replyTo: [
                ['email' => $data['email'], 'full_name' => $data['name']],
            ]);
        $helper->response_message('Success', 'Mesaj trimis cu succes', 'success');
        break;
}

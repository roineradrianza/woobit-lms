<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}


use Model\{Member, MemberMeta, StudentCourse};

use Controller\{Helper, Template};

$member = new Member;
$user_meta = new MemberMeta;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        $query = is_numeric($query) ? $query : $helper->decrypt($query);
        $results = $member->get($query);
        $members = [];
        if ($results > 0) {
            foreach ($results as $member) {
                $result['user_id'] = $member['user_id'];
                
                $result['avatar'] = $member['avatar'];
                $result['first_name'] = $member['first_name'];
                $result['last_name'] = $member['last_name'];
                $result['user_type'] = $member['user_type'];
                $result['email'] = $member['email'];
                $result['birthdate'] = $member['birthdate'];
                $result['gender'] = $member['gender'];

                $meta = $user_meta->get($result['user_id']);
                $result['meta'] = [];
                foreach ($meta as $i => $e) {
                    $result['meta'][$e['meta_name']] = $helper->is_json($e['meta_val']) ? json_decode($e['meta_val']) : $e['meta_val'];;
                }
                $members[] = $result;
            }
        }
        echo json_encode($members);
        break;

    case 'get-by-members':
        $results = $member->get_by_members();
        $members = [];
        if ($results > 0) {
            foreach ($results as $member) {
                $result['user_id'] = $member['user_id'];
                
                $result['avatar'] = $member['avatar'];
                $result['first_name'] = $member['first_name'];
                $result['last_name'] = $member['last_name'];
                $result['user_type'] = $member['user_type'];
                $result['email'] = $member['email'];
                $result['birthdate'] = $member['birthdate'];
                $result['gender'] = $member['gender'];

                $meta = $user_meta->get($result['user_id']);
                $result['meta'] = [];
                foreach ($meta as $i => $e) {
                    $result['meta'][$e['meta_name']] = is_array($e['meta_val']) ? json_encode($e['meta_val'], JSON_UNESCAPED_UNICODE) : $e['meta_val'];
                }
                $members[] = $result;
            }
        }
        echo json_encode($members);
        break;

    case 'search-user':
        $results = $member->search_user(clean_string($query));
        echo json_encode($results);
        break;

    case 'create':
        if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'administrator') {
            die(403);
        }
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $columns = ['first_name', 'last_name', 'email', 'gender', 'birthdate', 'user_type', 'password'];
        $result = $member->create(sanitize($data), $columns);
        if (!$result) {
            $helper->response_message('Error', 'Membrul nu a putut fi înregistrat corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'meta_name' => $meta_key, 
                    'meta_val' => $meta_value, 
                    'user_id' => $result
                ];
                $user_meta->create($meta);
            }
        }
        $helper->response_message('Succes', 'Membru înregistrat cu succes', data:['user_id' => $result]);
        break;

    case 'register':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $columns = ['first_name', 'last_name', 'email', 'gender', 'birthdate', 'user_type', 'password'];
        $data['user_type'] = 'membru';
        if ($member->check_exist_credential($data['email'])) {
            $helper->response_message('Error', 'Acest e-mail este deja înregistrat', 'error');
        }
        $result = $member->create(sanitize($data), $columns);
        if (!$result) {
            $helper->response_message('Error', 'Imposibilitatea de a vă înregistra Înregistrare completă', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'meta_name' => $meta_key, 
                    'meta_val' => $meta_value, 
                    'user_id' => $result
                ];
                $user_meta->create($meta);
            }
        }
        if (isset($data['register_to_course'])) {

            $student_course = new StudentCourse;
            $enroll_data = ['course_id' => $data['register_to_course']['course_id'], 'user_id' => $result, 'user_rol' => $data['register_to_course']['user_rol']];
            $student_course->create($enroll_data);
        }
        $_SESSION = $data;
        $_SESSION['verified'] = 0;
        $_SESSION['user_id'] = $result;

        $verification_code = "{$_SESSION['user_id']}{$helper->rand_string(25)}" . time();
        $member->set_verification_code($_SESSION['email'], $verification_code);
        $template_data = ['verification_code' => $verification_code];
        $template = new Template('email_templates/verification_code', $template_data);

        $sendEmail = $helper->send_mail('Verifică adresa de e-mail', [['email' => $_SESSION['email'], 'full_name' => '']], $template);
        $cookie_email = $helper->encrypt($_SESSION['email']);
        $cookie_password = md5($data['password']);
        setcookie('u', "$cookie_email", time() + 60 * 60 * 24 * 365, '/');
        setcookie('p', "$cookie_password", time() + 60 * 60 * 24 * 365, '/');
        $helper->response_message('Succes', 'V-ați înregistrat cu succes, vă rugăm să așteptați câteva momente pentru a continua.');
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        if (!is_numeric($data['user_id'])) {
            $data['user_id'] = Helper::decrypt($data['user_id']);
        }
        $id = intval($data['user_id']);
        $result = $member->edit($id, sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'Membrul nu a putut fi editat corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'meta_name' => $meta_key, 
                    'meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value
                ];
                $user_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Succes', 'Se editó el membru correctamente');
        break;
    case 'sign-in':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $result = null;
        if (isset($data['gid']) && !empty($data['gid'])) {
            $existsGid = $member->check_google_id($data['gid'], $data['email']);
            if (empty($existsGid)) {
                $credentials = [
                    'google_id' => clean_string($data['gid']),
                    'avatar' => clean_string($data['avatar']),
                    'first_name' => clean_string($data['first_name']),
                    'last_name' => clean_string($data['last_name']),
                    'email' => clean_string($data['email']),
                    'gender' => clean_string($data['gender']),
                    'user_type' => 'membru',
                    'password' => $helper->rand_string(),
                ];
                $columns = ['google_id', 'avatar', 'first_name', 'last_name', 'email', 'gender', 'user_type', 'verified', 'password'];
                $result = $member->create_with_google($credentials, $columns);
                if (!$result) {
                    $helper->response_message('Error', 'Nu s-a reușit procesarea corectă a înregistrării, încercați din nou', 'error');
                }

                if (isset($data['meta']) && !empty($data['meta'])) {
                    foreach ($data['meta'] as $meta_key => $meta_value) {
                        $meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $result];
                        $user_meta->create($meta);
                    }
                }
                $result = json_decode(json_encode($member->get($result)));
                $result = $result[0];
                $result['verified'] = 1;
            } else {
                $result = $existsGid;
            }
        } else if (isset($data['facebook_id']) && !empty($data['facebook_id'])) {
            $data['email'] = !empty($data['email']) ? clean_string($data['email']) : null;
            $existsFid = $member->check_facebook_id($data['facebook_id'], $data['email']);
            if (empty($existsFid)) {
                $credentials = [
                    'facebook_id' => clean_string($data['facebook_id']),
                    'avatar' => clean_string($data['avatar']),
                    'first_name' => clean_string($data['first_name']),
                    'last_name' => clean_string($data['last_name']),
                    'email' => $data['email'],
                    'user_type' => 'membru',
                    'password' => $helper->rand_string(),
                ];
                $columns = ['facebook_id', 'avatar', 'first_name', 'last_name', 'email', 'user_type', 'password'];
                $result = $member->create_with_facebook($credentials, $columns);
                if (!$result) {
                    $helper->response_message('Error', 'Nu s-a reușit procesarea corectă a înregistrării, încercați din nou', 'error');
                }

                if (isset($data['meta']) && !empty($data['meta'])) {
                    foreach ($data['meta'] as $meta_key => $meta_value) {
                        $meta = ['meta_name' => $meta_key, 'meta_val' => $meta_value, 'user_id' => $result];
                        $user_meta->create($meta);
                    }
                }
                $result = json_decode(json_encode($member->get($result)));
                $result = $result[0];
                $result->verified = 1;
            } else {
                $result = $existsFid;
            }
        }
        else {
            $email = clean_string($data['email']);
            $password = clean_string($data['password']);
            $result = $member->check_user($email, $password);
        }
        if (!empty($result)) {
            //We declare the session variables
            $_SESSION['user_id'] = $result->user_id;
            $_SESSION['avatar'] = $result->avatar;
            $_SESSION['first_name'] = $result->first_name;
            $_SESSION['last_name'] = $result->last_name;
            $_SESSION['email'] = $result->email;
            $_SESSION['gender'] = $result->gender;
            $_SESSION['birthdate'] = $result->birthdate;
            $_SESSION['user_type'] = $result->user_type;
            $_SESSION['verified'] = $result->verified;
            $_SESSION['meta'] = [];
            foreach ($user_meta->get($result->user_id) as $meta) {
                $_SESSION['meta'][$meta['meta_name']] = $meta['meta_val'];
            }
            $_SESSION['redirect_url'] = $result->user_type == 'administrator' ? SITE_URL . '/admin/' : SITE_URL . '/panou/';
            $cookie_email = $helper->encrypt($_SESSION['email']);
            $cookie_password = $result->password;
            setcookie('u', "$cookie_email", time() + 60 * 60 * 24 * 365, '/');
            setcookie('p', "$cookie_password", time() + 60 * 60 * 24 * 365, '/');
            $_COOKIE['u'] = $cookie_email;
            $_COOKIE['p'] = $cookie_password;
            $helper->response_message('Succes', 'V-ați autentificat cu succes, vă rugăm să așteptați un moment', 'success', $_SESSION['redirect_url']);
        } else {
            $helper->response_message('Error', 'Parolă incorectă. Te rog să încerci din nou.', 'error');
        }
        break;

    case 'delete':
        $result = $member->delete(intval($data['user_id']));
        if (!$result) {
            $helper->response_message('Error', 'Membrul nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Succes', 'Membru șters corect');
        break;

    case 'update-profile':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        } elseif (empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Sesiunea dvs. pare să fi expirat, vă rugăm să reîncărcați pagina și să încercați să vă autentificați din nou.', 'warning');
        }

        $id = $_SESSION['user_id'];
        $result = $member->edit_profile($id, sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'Informațiile dumneavoastră nu au putut fi editate corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'meta_name' => $meta_key, 
                    'meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value
                ];
                $user_meta->edit($id, $meta);
            }
        }
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['birthdate'] = $data['birthdate'];
        $_SESSION['meta'] = $data['meta'];
        
        $helper->response_message('Succes', 'Informațiile dvs. au fost actualizate corect', 'success');
        break;

    case 'complete-register':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $id = $_SESSION['user_id'];
        $result = $member->edit_profile($id, sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'Informațiile dumneavoastră nu au putut fi editate corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'meta_name' => $meta_key, 
                    'meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value, 
                    'user_id' => $id
                ];
                $check_meta = $user_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $user_meta->create($meta);
                    continue;
                }
                $user_meta->edit($id, $meta);
            }
        }
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['birthdate'] = $data['birthdate'];
        $_SESSION['meta'] = $data['meta'];
        $helper->response_message('Succes', 'Informațiile dvs. au fost actualizate corect', 'success');
        break;

    case 'update-member-avatar':
        $id = intval($_POST['user_id']);
        if (empty($id)) {
            die(403);
        }

        $avatar_file = $_FILES['avatar'];
        $ext = explode(".", $_FILES['avatar']['name']);
        $file_name = 'avatar' . time() . '.' . end($ext);
        if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], DIRECTORY . "/public/img/avatars/" . $file_name)) {
            $helper->response_message('Error', 'Nu s-a putut salva corect imaginea de profil a membrului', 'error');
        }

        $result = $member->update_avatar($id, $file_name);
        $helper->response_message('Succes', 'Imaginea profilului dvs. a fost actualizată cu succes.', 'success');
        break;

    case 'update-avatar':
        if (empty($_POST) || empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $id = $_SESSION['user_id'];
        $ext = explode(".", $_FILES['avatar']['name']);
        $tmp_file = $_FILES['avatar']['tmp_name'];
        $file_name = "avatar-$id-" . time() . '.' . end($ext);
        $path = DIRECTORY . "/public/img/avatar/$file_name";
        if (move_uploaded_file($tmp_file, $path)) {
            $data['avatar'] = "/img/avatar/$file_name";
        } else {
            if (!$result) {
                $helper->response_message('Error', 'Nu s-a putut încărca imaginea profilului, vă rugăm să încercați din nou.', 'error');
            }
        }
        if (!empty($data['old_avatar'])) {
            unlink($data['old_avatar']);
        }
        $result = $member->update_avatar($id, $data['avatar']);
        $_SESSION['avatar'] = $data['avatar'];
        $helper->response_message('Succes', 'Imaginea profilului dvs. a fost actualizată cu succes.', data:['avatar' => $data['avatar']]);
        break;

    case 'logout':
        //We clean the session variables
        session_unset();
        //Destroy the session
        session_destroy();
        //We redirect the user to the login page
        setcookie('u', "", time() - 1, '/');
        setcookie('p', "", time() - 1, '/');
        header("Location: " . SITE_URL . "/login");
        break;

}

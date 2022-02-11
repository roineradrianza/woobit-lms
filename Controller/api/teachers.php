<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\Helper;

use Model\{Member, MemberMeta, CourseRating};

$member = new Member;
$course_rating = new CourseRating;
$user_meta = new MemberMeta;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get':

        $teachers = $member->get_instructors();
        $items = [];
        foreach ($teachers as $teacher) {
            $teacher['ratings'] = $course_rating->get_instructor_total($teacher['user_id']);
            $teacher['ratings']['average'] = round($teacher['ratings']['average'], 1);
            $items[] = $teacher;
        }

        echo json_encode($items);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Nu s-a primit nicio informație', 'warning');
        } elseif (empty($_SESSION['user_id'])) {
            $helper->response_message('Advertencia', 'Sesiunea dvs. pare să fi expirat, vă rugăm să reîncărcați pagina și să încercați să vă autentificați din nou.', 'warning');
        }

        $id = $_SESSION['user_id'];
        $result = $member->edit_teacher_profile($id, sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'Informațiile dumneavoastră nu au putut fi editate corect', 'error');
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $check_meta = $user_meta->get_meta($id, $meta_key);

                $meta = [
                    'meta_name' => $meta_key,
                    'meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                    'user_id' => $id,
                ];

                if (empty($check_meta)) {
                    $user_meta->create($meta);
                } else {
                    $user_meta->edit($id, $meta);
                }

            }
        }

        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['meta']['bio'] = empty($data['meta']['bio']) ? '' : $data['meta']['bio'];
        $_SESSION['meta']['teacher_email'] = $data['meta']['teacher_email'];
        $_SESSION['meta']['teacher_telephone'] = $data['meta']['teacher_telephone'];
        
        $helper->response_message('Succes', 'Informațiile dvs. au fost actualizate corect', 'success');
        break;

}

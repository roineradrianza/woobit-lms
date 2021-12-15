<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\Helper;
use Model\Course;
use Model\Member;

use Model\Section;

use Model\StudentCourse;

$course = new Course;
$section = new Section;
$member = new Member;
$helper = new Helper;
$student_course = new StudentCourse;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $results = $course->get_my_courses($query);
        echo json_encode($results);
        break;

}

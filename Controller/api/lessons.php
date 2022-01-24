<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Course, Lesson, LessonViews, StudentCourse};

use Controller\Helper;



$course = new Course;
$lesson = new Lesson;
$lesson_view = new LessonViews;
$student_course = new StudentCourse;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get-classes':
        if (empty($data['course_id']) || empty($data['lesson_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = clean_string($data);
        $results = $lesson_view->get_lessons_views_students($data['course_id'], $data['lesson_id']);
        echo json_encode($results);
        break;

    case 'get-pendings':
        $results = $lesson->get_lessons_pending();
        echo json_encode($results);
        break;

    case 'get-classmates':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $results = $student_course->get_classmates($query);
        echo json_encode($results);
        break;

    case 'update-status':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = sanitize($data);

        $results = $lesson->update_status($data['lesson_id'], $data['lesson_status']);
    
        if(!$results) {
            $helper->response_message('Avertisment', 'Nu a putut fi procesat', 'warning');
        }
    
        $helper->response_message('Succes', 'A fost prelucrat corect');
        break;

    case 'join-class':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        if ($_SESSION['user_type'] != 'administrator') {
            $data['zoom_view'] = 1;
            $data['video_view'] = 0;
            $data['completed'] = 1;
            $result = $lesson_view->update_view(clean_string($query), $_SESSION['user_id'], $data);
            if (!$result) {
                $helper->response_message('Error', 'Nu pot intra în sala de clasă', 'error');
            }

            $update_progress = $student_course->update_course_progress(clean_string($data['slug']), $_SESSION['user_id'], true);
        }
        $helper->response_message('Succes', 'S-a înscris corect în clasă');
        break;




}
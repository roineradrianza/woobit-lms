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

    case 'get-classmates':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $results = $student_course->get_classmates($query);
        echo json_encode($results);
        break;

    case 'join-class':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        if ($_SESSION['user_type'] != 'administrator') {
            $data['zoom_view'] = 1;
            $data['video_view'] = 0;
            $data['completed'] = 1;
            $data['certified_url'] = '';
            $data['requireCertifiedPaid'] = 2;
            $result = $lesson_view->update_view(clean_string($query), $_SESSION['user_id'], $data);
            if (!$result) {
                $helper->response_message('Error', 'No se pudo ingresar a la clase', 'error');
            }

            $update_progress = $student_course->update_course_progress(clean_string($data['slug']), $_SESSION['user_id'], true);
        }
        $helper->response_message('Éxito', 'Se unió a la clase correctamente',
            data: [
                'certified_url' => $data['certified_url'],
                'requireCertifiedPaid' => $data['requireCertifiedPaid']
            ]
        );
        break;



    case 'delete':
        $result = $lesson_view->delete(intval($data['lesson_id']), intval($data['user_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la vista de la clase correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la vista de la clase correctamente');
        break;
}
<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Course, Lesson, LessonViews, Question, QuestionAttemptAnswer, StudentCourse, QuestionAttempt, Notification};

use Controller\Helper;



$course = new Course;
$lesson = new Lesson;
$lesson_view = new LessonViews;
$question = new Question;
$question_attempt_answer = new QuestionAttemptAnswer;
$student_course = new StudentCourse;
$question_attempt = new QuestionAttempt;
$notification = new Notification;
$helper = new Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {

    case 'get-questions':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $quizzes = [];
        foreach ($question->get(clean_string($query)) as $quiz) {
            unset($quiz['old_question_name']);
            $quiz['correct_answer'] = '';
            $quiz['question_answers'] = json_decode($quiz['question_answers']);
            $quizzes[] = $quiz;
        }
        echo json_encode($quizzes);
        break;

    case 'get-my-grades':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $results = $question_attempt->get_my_grades(clean_string($query), $_SESSION['user_id']);
        echo json_encode($results);
        break;

    case 'create':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $question->create($data['quiz'], intval(clean_string($data['lesson']['lesson_id'])));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo registrar la pregunta correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se registró la pregunta correctamente', data:['question_id' => $result]);
        break;

    case 'save-attempt':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }
        $data['certified_url'] = '';
        $data['requireCertifiedPaid'] = 2;
        $quizzes = [];
        $lesson = clean_string($data['lesson']);
        $meta = $data['meta'];
        $user_id = $_SESSION['user_id'];
        $answers = $helper->array_sort($data['answers'], 'question_id');
        foreach ($question->get($lesson['lesson_id']) as $quiz) {
            unset($quiz['old_question_name']);
            $quiz['question_answers'] = json_decode($quiz['question_answers']);
            $quizzes[] = $quiz;
        }
        $quiz_results = array_map(array($question_attempt_answer, 'check_answers'), $quizzes, $answers);
        $lesson_view_data = [
            'zoom_view' => 0,
            'video_view' => 0,
            'completed' => 1,
        ];
        $lesson_view = $lesson_view->update_quiz_view($lesson['lesson_id'], $user_id, $lesson_view_data, 1);
        $attempt_data = [
            'score' => 0,
            'time_taken' => 1,
            'user_id' => $user_id,
            'lesson_view_id' => $lesson_view,
        ];
        foreach ($quiz_results as $quiz_result) {
            $attempt_data['score'] = $attempt_data['score'] + $quiz_result['score'];
        }
        $attempt_data['approved'] = $attempt_data['score'] >= $meta['min_score'] ? 1 : 0;
        $attempt_data['score'] = round($attempt_data['score']);
        $save_attempt = $question_attempt->create($attempt_data);
        if (!$save_attempt) {
            $helper->response_message('Error', 'No se pudo procesar el quiz correctamente', 'error');
        }

        foreach ($quiz_results as $quiz_result) {
            $quiz_result['question_attempt_id'] = $save_attempt;
            $question_attempt_answer->create($quiz_result);
        }
        $helper->response_message('Éxito', 'Se registró el intento correctamente',
            data:[
                'attempt_data' => $attempt_data,
                'quiz_results' => $quiz_results,
            ]
        );
        break;

    case 'get-attempt':
        if (empty($query)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $quizzes = [];
        $answers = [];
        $user_id = $_SESSION['user_id'];
        $lesson_id = clean_string($query);
        $attempt_data = $question_attempt->get_by_id($lesson_id, $user_id);
        foreach ($question->get($lesson_id) as $quiz) {
            unset($quiz['old_question_name']);
            $quiz['question_answers'] = json_decode($quiz['question_answers']);
            $answer = $question_attempt_answer->get_by_id($quiz['question_id'], $attempt_data['question_attempt_id']);
            $answers[] = $answer;
            $quizzes[] = $quiz;
        }
        $quiz_results = array_map(array($question_attempt_answer, 'check_answers'), $quizzes, $answers);
        $attempt_data['score'] = round($attempt_data['score']);
        $data = ['attempt_data' => $attempt_data, 'quiz_results' => $quiz_results];
        echo json_encode($data);
        break;

    case 'update-quiz-lesson-meta':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $data_vars = [];
        foreach ($data['meta'] as $meta_name => $meta_val) {
            $check_meta = $lesson_meta->get_meta($data['lesson_id'], $meta_name);
            $meta_data = ['lesson_meta_name' => $meta_name, 'lesson_meta_val' => $meta_val, 'lesson_id' => $data['lesson_id']];
            if (empty($check_meta)) {
                $result = $lesson_meta->create($meta_data);
            } else {
                $result = $lesson_meta->edit($check_meta['lesson_id'], $meta_data);
            }
            if (!$result) {
                $helper->response_message('Error', "No se pudo actualizar el siguiente campo: $meta_name", 'error');
            }

        }
        $helper->response_message('Éxito', 'Se actualizó la lección correctamente', data:$data_vars);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $question_id = intval($data['question_id']);
        $result = $question->edit($question_id, $data);
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar la pregunta correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó la pregunta correctamente');
        break;

    case 'delete':
        $result = $question->delete(intval($data['question_id']), intval($data['lesson_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la lección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la lección correctamente');
        break;
}

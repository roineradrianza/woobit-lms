<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Model\{Section, Lesson, LessonMeta, Question, Media};

use Controller\Helper;

$section = new Section;
$lesson = new Lesson;
$lesson_meta = new LessonMeta;
$question = new Question;
$helper = new Helper;
$media = new Media;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        $results = [];
        $sections = [];
        if (isset($data['section_id']) && isset($data['course_id'])) {
            $results = $section->get($data['section_id'], $data['course_id']);
        } else if (!isset($data['section_id']) && isset($data['course_id'])) {
            $results = $section->get(course_id:$data['course_id']);
        }
        foreach ($results as $result) {
            $section = [];
            $section['section_id'] = $result['section_id'];
            $section['section_name'] = $result['section_name'];
            $section['old_section_name'] = $result['section_name'];
            $section['section_order'] = $result['section_order'];
            $section['old_section_order'] = $result['section_order'];
            $lessons = $lesson->get($section['section_id']);
            $section['items'] = [];
            foreach ($lessons as $l) {
                $l['old_lesson_name'] = $l['lesson_name'];
                $l['old_lesson_order'] = $l['lesson_order'];
                $l['resources'] = $media->get_by_lesson($l['lesson_id'], 'material');
                $l['quizzes'] = [];
                $l['meta'] = [];
                $lesson_metas = $lesson_meta->get($l['lesson_id']);
                foreach ($lesson_metas as $meta_val) {
                    $l['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                }
                $section['items'][] = $l;
            }
            $sections[] = $section;
        }
        echo json_encode($sections);
        break;

    case 'get-only-classes':
        $results = [];
        $sections = [];
        if (isset($data['section_id']) && isset($data['course_id'])) {
            $results = $section->get($data['section_id'], $data['course_id']);
        } else if (!isset($data['section_id']) && isset($data['course_id'])) {
            $results = $section->get(course_id:$data['course_id']);
        }
        foreach ($results as $result) {
            $section = [];
            $section['section_id'] = $result['section_id'];
            $section['section_name'] = $result['section_name'];
            $section['old_section_name'] = $result['section_name'];
            $section['section_order'] = $result['section_order'];
            $section['old_section_order'] = $result['section_order'];
            $lessons = $lesson->get($section['section_id']);
            $section['items'] = [];
            foreach ($lessons as $l) {
                if ($l['lesson_type'] != 1) {
                    continue;
                }

                $l['old_lesson_name'] = $l['lesson_name'];
                $l['old_lesson_order'] = $l['lesson_order'];
                $l['meta'] = [];
                $lesson_metas = $lesson_meta->get($l['lesson_id']);
                foreach ($lesson_metas as $meta_val) {
                    $l['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                }
                $section['items'][] = $l;
            }
            $sections[] = $section;
        }
        echo json_encode($sections);
        break;

    case 'get-total-views':
        if (empty($data['section_id']) || empty($data['course_id'])) {
            echo json_encode([]);
            die();
        }
        $data = sanitize($data);
        $results = $section->get_total_views($data['section_id'], $data['course_id']);
        echo json_encode($results);
        break;

    case 'get-total-quizzes-done':
        if (empty($data['section_id']) || empty($data['course_id'])) {
            echo json_encode([]);
            die();
        }
        $data = sanitize($data);
        $results = $section->get_total_quizzes_done($data['section_id'], $data['course_id']);
        echo json_encode($results);
        break;

    case 'create':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $result = $section->create(sanitize($data), intval($data['course_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo registrar la sección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se registró la sección correctamente', data:['section_id' => $result]);
        break;

    case 'update':
        if (empty($data)) {
            $helper->response_message('Advertencia', 'Ninguna información fue recibida', 'warning');
        }

        $section_id = intval($data['section_id']);
        $course_id = intval($data['course_id']);
        if ($data['section_order'] != $data['old_section_order']) {
            $old_section = $section->get_section_by_order($course_id, intval($data['section_order']));
            if (!empty($old_section)) {
                $old_section = $old_section[0];
                $old_section['section_order'] = $data['old_section_order'];
                $section->edit(intval($old_section['section_id']), $old_section);
            }
        }
        $result = $section->edit($section_id, sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo editar la sección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se editó la sección correctamente');
        break;

    case 'delete':
        $result = $section->delete(intval($data['section_id']), intval($data['course_id']));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo eliminar la sección correctamente', 'error');
        }

        $helper->response_message('Éxito', 'Se eliminó la sección correctamente');
        break;
}

<?php
/*
 *    @var method
 * @var query
 */
if (empty($method)) {
    die(403);
}

use Controller\{Helper, ZoomInstance};
use Model\{Course, CourseCategory, CourseRating, CourseMeta, Lesson, LessonMeta, Member};

use Model\Section;

use Model\StudentCourse;

$course = new Course;
$section = new Section;
$lesson = new Lesson;
$lesson_meta = new LessonMeta;
$course_meta = new CourseMeta;
$member = new Member;
$helper = new Helper;
$zoom_instance = new ZoomInstance;
$course_category = new CourseCategory;
$course_rating = new CourseRating;
$student_course = new StudentCourse;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : clean_string($query);

switch ($method) {
    case 'get':
        $results = $course->get($query);
        $courses = [];

        if (count($results) > 0) {
            foreach ($results as $course) {
                $result = $course;
                $result['ratings'] = $course_rating->get_course_total($course['course_id']);
                $result['category_id'] = isset($course['category_id']) ? $course['category_id'] : '';
                $result['subcategory_id'] = isset($course['subcategory_id']) ? $course['subcategory_id'] : '';

                $meta = $course_meta->get($result['course_id']);
                $result['meta'] = [];
                foreach ($meta as $i => $e) {
                    $result['meta'][$e['course_meta_name']] = $e['course_meta_val'];
                }
                $courses[] = $result;
            }
        }
        echo json_encode($courses);
        break;

    case 'get-pendings':
        $results = $course->get_courses_pending();
        echo json_encode($results);
        break;

    case 'get-instructors':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $instructors = $student_course->get_instructors($query);
        echo json_encode($instructors);
        break;

    case 'update-status':
        if (empty($data)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = sanitize($data);
        $course_id = !empty($query) ? $query : $data['course_id'];

        $results = $course->update_status($course_id, $data['course_status']);
    
        if(!$results) {
            $helper->response_message('Avertisment', 'Nu a putut fi procesat', 'warning');
        }
    
        $helper->response_message('Succes', 'A fost prelucrat corect');
        break;

    case 'get-courses':
        $columns = ['course_id, title'];
        $query = empty($query) ? 0 : clean_string($query);
        $results = $course->get_courses($query, $columns);
        echo json_encode($results);
        break;

    case 'get-my-courses':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $query = $helper->decrypt($query);
        $query = intval($query);
        $results = $course->get_my_courses($query);
        echo json_encode($results);
        break;

    case 'get-own-courses':
        if (empty($query)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $query = $helper->decrypt($query);
        $results = $course->get_own_courses($query);
        $courses = [];

        foreach ($results as $course) {
            $result = $course;
            $result['ratings'] = $course_rating->get_course_total($course['course_id']);
            $courses[] = $result;
        }
        
        echo json_encode($courses);
        break;

    case 'get-new-courses':
        $results = $course->get_recent_courses();
        echo json_encode($results);
        break;

    case 'get-total-views':
        $total_video_views = 0;
        $total_zoom_views = 0;
        $total_quizzes_done = 0;
        foreach ($data['sections'] as $section_item) {
            $video_and_zoom_views = $section->get_total_views($section_item['section_id'], $data['course_id']);
            foreach ($video_and_zoom_views as $view) {
                $total_video_views = $total_video_views + $view['video_views'];
                $total_zoom_views = $total_zoom_views + $view['zoom_views'];
            }
            $quizzes_done = $section->get_total_quizzes_done($section_item['section_id'], $data['course_id']);
            foreach ($quizzes_done as $quiz_lesson) {
                $total_quizzes_done = $total_quizzes_done + $quiz_lesson['students'];
            }
        }
        echo json_encode(
            [
                'total_video_views' => $total_video_views,
                'total_zoom_views' => $total_zoom_views,
                'total_quizzes_done' => $total_quizzes_done,
            ]
        );
        break;

    case 'get-coming-live-classes':
        $user_id = !empty($query) ? $query : $_SESSION['user_id'];
        $results = $course->get_my_courses($user_id);
        $coming_lessons = [];
        foreach ($results as $course_selected) {
            foreach ($section->get(0, $course_selected['course_id']) as $section_selected) {
                $lessons = $lesson->get_by_type($section_selected['section_id']);
                foreach ($lessons as $lesson_selected) {
                    $lesson_selected['meta'] = [];
                    $lesson_metas = $lesson_meta->get($lesson_selected['lesson_id']);
                    foreach ($lesson_metas as $meta_val) {
                        if ($meta_val['lesson_meta_name'] == 'class_type' && $meta_val['lesson_meta_val'] != 'zoom_meeting') {
                            continue;
                        }

                        $lesson_selected['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                    }
                    $meta = $lesson_selected['meta'];
                    $timezone = !empty($meta['zoom_timezone']) ? $meta['zoom_timezone'] : 'UTC';
                    date_default_timezone_set($timezone);
                    if (empty($meta['zoom_start_time'])) {
                        continue;
                    }

                    $class_date = new DateTime($meta['zoom_start_time']);
                    $server_date = new DateTime();
                    $is_current_date = date('Y-m-d', $class_date->format('U')) === date('Y-m-d', $server_date->format('U')) ? true : false;
                    if (!$is_current_date) {
                        continue;
                    }

                    $diff = $class_date->diff($server_date);
                    $minutes = $diff->i;
                    $hours = $diff->h;
                    $lesson_data = [
                        'course_image' => $course_selected['featured_image'],
                        'course_name' => $course_selected['title'],
                        'section_name' => $section_selected['section_name'],
                        'lesson_name' => $lesson_selected['lesson_name'],
                        'lesson_url' => SITE_URL . "/courses/{$course_selected['slug']}/{$lesson_selected['lesson_id']}/",
                        'lesson_date' => $meta['zoom_date'] . ' ' . $meta['zoom_time'] . ' ' . $meta['zoom_timezone'],
                    ];
                    $coming_lessons[] = $lesson_data;
                }
            }
        }
        echo json_encode($coming_lessons);
        break;

    case 'create':
        if (empty($_POST)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $data['user_id'] = empty($data['user_id']) ? $_SESSION['user_id'] : $data['user_id'];
        $data['slug'] = $helper->convert_slug($data['title']) . "-{$data['user_id']}";
        $tmp_file = $_FILES['featured_image']['tmp_name'];
        $ext = explode(".", $_FILES['featured_image']['name']);
        $file_name = "{$data['slug']}-" . time() . "." . end($ext);
        $path = DIRECTORY . "/public/img/featured-images/$file_name";

        if (!move_uploaded_file($tmp_file, $path)) {
            $helper->response_message('Error', 'Nu s-a putut încărca coperta cursului, vă rugăm să încercați din nou.', 'error');
        }

        $data['featured_image'] = "/img/featured-images/$file_name";
        $data['price'] = floatval($data['price']);
        $result = $course->create($data);

        if (!$result) {
            $helper->response_message('Error', 'Cursul nu a putut fi creat corect', 'error');
        }

        if (isset($data['category_id'])) {
            $data['course_id'] = $result;
            $course_category->create($data);
        }

        if (isset($data['meta']) && !empty($data['meta'])) {
            $data['meta'] = json_decode($data['meta'], true);
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'course_meta_name' => $meta_key,
                    'course_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                    'course_id' => $result,
                ];
                $course_meta->create($meta);
            }
        }

        if (!empty($data['section'])) {
            $data['section'] = json_decode($data['section'], true);
            foreach ($data['section'] as $item) {
                $item['course_id'] = $result;
                $section_result = $section->create($item, $data['course_id']);
                if (!$section_result) {
                    continue;
                }
                foreach ($item['items'] as $lesson_item) {
                    $lesson_item['section_id'] = $section_result;
                    $lesson_item['user_id'] = $data['user_id'];
                    $lesson_result = $lesson->create($lesson_item);
                    if (!$lesson_result) {
                        continue;
                    }
                    if (!empty($lesson_item['meta'])) {
                        if ($lesson_item['meta']['class_type'] == 'zoom_meeting') {
                            $meta = $lesson_item['meta'];
                            if (!empty($meta['zoom_duration']) && !empty($meta['zoom_time'])) {
                                $meta['zoom_start_time'] = gmdate(DATE_ATOM, strtotime("{$meta['zoom_date']} {$meta['zoom_time']}:00"));
                                $meta['zoom_topic'] = $lesson_item['lesson_name'];

                                $meeting_data = [
                                    'topic' => $meta['zoom_topic'],
                                    'agenda' => $meta['zoom_agenda'],
                                    'duration' => $meta['zoom_duration'],
                                    'start_time' => $meta['zoom_start_time'],
                                    'password' => $helper->rand_string(10),
                                ];
                                if (isset($data['meeting_id'])) {
                                    $meeting_data['meeting_id'] = $data['meeting_id'];
                                }
                    
                                $data_vars = $zoom_instance->create_meeting($meeting_data);
                                if (!is_object($data_vars)) {
                                    if ($data_vars == 400) {
                                        $helper->response_message('Error', 'El host alternativo debe ser otra cuenta con licencia', 'error');
                                    }
                                }
                                $notify = false;
                                $meta['zoom_url'] = isset($data_vars->join_url) ? $data_vars->join_url : null;
                                $meta['zoom_id'] = isset($data_vars->id) ? $data_vars->id : null;
                                $meta['zoom_password'] = $meeting_data['password'];
                                $lesson_item['meta'] = $meta;
                            }
                        }
                        foreach ($lesson_item['meta'] as $meta_key => $meta_value) {
                            $meta = [
                                'lesson_meta_name' => $meta_key,
                                'lesson_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                                'lesson_id' => $lesson_result,
                            ];
                            $lesson_meta->create($meta);
                        }
                    }
                }
            }
        }
        $helper->response_message('Succes', 'Cursul a fost creat cu succes', data:['featured_image' => $data['featured_image'], 'user_id' => $data['user_id'], 'course_id' => $result, 'slug' => $data['slug']]);
        break;

    case 'add-instructor':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data['user_rol'] = 'profesor';
        $result = $student_course->create($data);
        if (!$result) {
            $helper->response_message('Error', 'Profesorul nu a putut fi adăugat la curs', 'error');
        }

        $helper->response_message('Succes', 'Profesorul a adăugat corect');
        break;

    case 'add-student':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $result = $student_course->create(sanitize($data));
        if (!$result) {
            $helper->response_message('Error', 'No se pudo añadir el estudiante al curso', 'error');
        }

        $helper->response_message('Succes', "Se añadió el {$data['user_rol']} correctamente");
        break;

    case 'update':
        if (empty($_POST)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        $data['user_id'] = intval($data['user_id']);
        $data['slug'] = $helper->convert_slug($data['title']) . "-{$data['user_id']}";
        if (isset($_FILES['new_featured_image']) && $_FILES['new_featured_image']['size'] > 0) {
            $file = $_FILES['new_featured_image'];
            $tmp_file = $file['tmp_name'];
            $ext = explode(".", $file['name']);
            $file_name = "{$data['slug']}-" . time() . "." . end($ext);
            $path = DIRECTORY . "/public/img/featured-images/$file_name";
            if (!move_uploaded_file($tmp_file, $path)) {
                $helper->response_message('Error', 'Nu s-a putut încărca coperta cursului, vă rugăm să încercați din nou.', 'error');
            }
            $old_file = DIRECTORY . $data['featured_image'];
            !empty($data['featured_image']) && file_exists($old_file) ? unlink($old_file) : '';
            $data['featured_image'] = "/img/featured-images/$file_name";
        }
        $data['price'] = floatval($data['price']);
        $result = $course->edit($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'Cursul nu a putut fi editat corect', 'error');
        }

        if (isset($data['category_id'])) {
            $check_category = $course_category->get($data['course_id']);
            $data['course_id'] = intval($data['course_id']);
            $data['category_id'] = intval($data['category_id']);
            if (empty($check_category)) {
                $course_category->create($data);
            } else {
                $course_category->edit($data['course_id'], $data);
            }
        }
        if (isset($data['meta']) && !empty($data['meta'])) {
            $data['meta'] = json_decode($data['meta'], true);
            foreach ($data['meta'] as $meta_key => $meta_value) {
                $meta = [
                    'course_meta_name' => $meta_key,
                    'course_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                ];
                if (isset($_FILE[$meta_key])) {
                    $tmp_file = $_FILES[$meta_key]['tmp_name'];
                    $ext = explode(".", $_FILES[$meta_key]['name']);
                    $file_name = time() . '.' . $ext[1];
                    $path = DIRECTORY . "/public/media/$file_name";
                    if (move_uploaded_file($tmp_file, $path)) {
                        $meta_value = "/media/$file_name";
                    }
                }
                $check_meta = $course_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = [
                        'course_meta_name' => $meta_key,
                        'course_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                        'course_id' => $id,
                    ];
                    $course_meta->create($meta_data);
                    continue;
                }
                $course_meta->edit($id, $meta);
            }
        }
        if (!empty($data['section'])) {
            $data['section'] = json_decode($data['section'], true);
            foreach ($data['section'] as $item) {
                $item['course_id'] = $data['course_id'];
                $section_result = empty($item['section_id']) ? $section->create($item, $data['course_id']) : $section->edit($item['section_id'], $item);
                if (!$section_result) {
                    continue;
                }

                foreach ($item['items'] as $lesson_item) {
                    $lesson_item['section_id'] = empty($item['section_id']) ? $section_result : $item['section_id'];
                    $lesson_item['user_id'] = $data['user_id'];
                    $lesson_result = empty($lesson_item['lesson_id']) ? $lesson->create($lesson_item) : $lesson->edit($lesson_item['lesson_id'], $lesson_item);
                    if (!$lesson_result) {
                        continue;
                    }
                    $id = $lesson_item['lesson_id'] = empty($lesson_item['lesson_id']) ? $lesson_result : $lesson_item['lesson_id'];
                    if (!empty($lesson_item['meta'])) {
                        if ($lesson_item['meta']['class_type'] == 'zoom_meeting') {
                            $meta = $lesson_item['meta'];
                            
                            if (!empty($meta['zoom_duration']) && !empty($meta['zoom_time'])) {
                                $meta['zoom_start_time'] = gmdate(DATE_ATOM, strtotime("{$meta['zoom_date']} {$meta['zoom_time']}:00"));
                                $meta['zoom_topic'] = $lesson_item['lesson_name'];

                                $meeting_data = [
                                    'topic' => $meta['zoom_topic'],
                                    'agenda' => $meta['zoom_agenda'],
                                    'duration' => $meta['zoom_duration'],
                                    'start_time' => $meta['zoom_start_time'],
                                    'password' => $helper->rand_string(10),
                                ];
                                if (isset($data['meeting_id'])) {
                                    $meeting_data['meeting_id'] = $data['meeting_id'];
                                }
                    
                                $data_vars = $zoom_instance->create_meeting($meeting_data);
                                if (!is_object($data_vars)) {
                                    if ($data_vars == 400) {
                                        $helper->response_message('Error', 'El host alternativo debe ser otra cuenta con licencia', 'error');
                                    }
                                }
                                $notify = false;
                                $meta['zoom_url'] = isset($data_vars->join_url) ? $data_vars->join_url : null;
                                $meta['zoom_id'] = isset($data_vars->id) ? $data_vars->id : null;
                                $meta['zoom_password'] = $meeting_data['password'];
                                $lesson_item['meta'] = $meta;
                            }
                        }
                        foreach ($lesson_item['meta'] as $meta_key => $meta_value) {
                            $meta = [
                                'lesson_meta_name' => $meta_key,
                                'lesson_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                                'lesson_id' => $lesson_item['lesson_id'],
                            ];
                            $check_meta = $lesson_meta->get_meta($lesson_item['lesson_id'], $meta_key);
                            empty($check_meta) ? $lesson_meta->create($meta) : $lesson_meta->edit($lesson_item['lesson_id'], $meta);
                        }
                    }
                    
                }
            }
        }
        $helper->response_message('Succes', 'Cursul a fost editat corect', data:['featured_image' => $data['featured_image'], 'slug' => $data['slug']]);
        break;

    case 'update-meta':
        if (empty($_POST)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        $data['meta'] = json_decode($data['meta'], true);
        if (isset($data['meta']) && !empty($data['meta'])) {
            foreach ($data['meta'] as $meta_key => $meta_value) {
                if (is_array($meta_value)) {
                    $meta_value = json_encode($meta_value, JSON_UNESCAPED_UNICODE);
                }

                $meta = [
                    'course_meta_name' => $meta_key,
                    'course_meta_val' => is_array($meta_value) ? json_encode($meta_value, JSON_UNESCAPED_UNICODE) : $meta_value,
                    'course_id' => $id];
                $check_meta = $course_meta->get_meta($id, $meta_key);
                if (empty($check_meta)) {
                    $meta_data = ['course_meta_name' => $meta_key, 'course_meta_val' => $meta_value, 'course_id' => $id];
                    $course_meta->create($meta_data);
                    continue;
                }
                $course_meta->edit($id, $meta);
            }
        }
        $helper->response_message('Succes', 'Se actualizó la información correctamente');
        break;

    case 'update-cover':
        if (empty($_POST)) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $data = $_POST;
        $id = intval($data['course_id']);
        if (isset($_FILES['featured_image'])) {
            $tmp_file = $_FILES['featured_image']['tmp_name'];
            $ext = explode(".", $_FILES['featured_image']['name']);
            $file_name = "{$data['slug']}-" . time() . '.' . end($ext);
            $path = DIRECTORY . "/public/img/featured-images/$file_name";
            if (!move_uploaded_file($tmp_file, $path)) {
                $helper->response_message('Error', 'Nu s-a putut încărca coperta cursului, vă rugăm să încercați din nou.', 'error');
            }
            $data['featured_image'] = "/img/featured-images/$file_name";
        }
        $result = $course->edit_cover($id, $data);
        if (!$result) {
            $helper->response_message('Error', 'Nu s-a putut actualiza corect pagina de prezentare a cursului', 'error');
        }

        $helper->response_message('Succes', 'Coperta cursului a fost editată corect', data:['featured_image' => $data['featured_image']]);
        break;

    case 'delete':
        $result = $course->delete(intval($data['course_id']));
        if (!$result) {
            $helper->response_message('Error', 'Cursul nu a putut fi șters corect', 'error');
        }

        $helper->response_message('Succes', 'Cursul a fost șters corect');
        break;

    case 'remove-instructor':
        if (empty($data) || empty($data['user_id']) || empty($data['course_id'])) {
            $helper->response_message('Avertisment', 'Nu s-a primit nicio informație', 'warning');
        }

        $result = $student_course->delete($data['user_id'], $data['course_id']);
        if (!$result) {
            $helper->response_message('Error', 'Nu s-a putut elimina profesorul din curs', 'error');
        }

        $helper->response_message('Succes', 'Profesorul a fost îndepărtat corect');
        break;

}

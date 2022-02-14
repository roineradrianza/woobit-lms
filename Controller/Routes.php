<?php
namespace Controller;

use Model\Application;
use Model\Category;
use Model\Course;
use Model\CourseMeta;
use Model\CourseRating;
use Model\Lesson;
use Model\LessonMeta;
use Model\LessonViews;
use Model\Member;
use Model\MemberMeta;
use Model\Orders;
use Model\Section;
use Model\StudentCourse;
use Model\SubCategory;

/**
 *
 */
class Routes
{
    public $title = PROJECT_NAME;
    public $admin = false;
    public $content;
    public $header = true;
    public $description;
    public $admin_header = false;
    public $footer = false;
    public $styles = [];
    public $scripts = [];

    public function __construct()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $route = explode("/", $uri);
        array_shift($route);

        if ($route[0] == "api") {
            $controller = $route[1];
            if (isset($controller) and $controller !== "") {
                $method = isset($route[2]) ? $route[2] : '';
                $query = isset($route[3]) ? $route[3] : '';
                require_once DIRECTORY . "/Controller/api/$controller.php";
            }
        } else if ($route[0] == "cron") {
            $controller = $route[1];
            if (isset($controller) and $controller !== "") {
                $method = isset($route[2]) ? $route[2] : '';
                $query = isset($route[3]) ? $route[3] : '';
                require_once DIRECTORY . "/Controller/cron/$controller.php";
            }
        } else {
            $this->header = true;
            $this->admin_header = false;
            $this->styles = [];
            $this->scripts = [];
            $this->footer = true;
            switch ($route[0]) {
                case '':

                    $course = new Course;
                    $member = new Member;
                    $course_rating = new CourseRating;
                    $setting = new \Model\Setting;
                    $courses_results = $course->get_enabled(4);
                    $courses = [];
                    $homepage_teachers = $setting->get('homepage_teachers');
                    if (!empty($homepage_teachers)) {
                        $homepage_teachers['value'] = !empty($homepage_teachers['value']) 
                        ? Helper::clean_json($homepage_teachers['value']) : [];
                        $instructors = [];
                        foreach ($homepage_teachers['value'] as $instructor) {
                            $instructor['avatar'] = $member->get($instructor['user_id'], ['avatar'])[0]['avatar'];
                            $instructor['ratings'] = $course_rating->get_instructor_total($instructor['user_id']);
                            $instructors[] = $instructor;
                        }
                        $homepage_teachers = $instructors;
                    } else {
                        $homepage_teachers = [];
                    }
                    foreach ($courses_results as $course) {
                        $course['ratings'] = $course_rating->get_course_total($course['course_id']);
                        $courses[] = $course;
                    }
                    $this->styles = [
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("home", [
                        'courses' => $courses,
                        'teachers' => $homepage_teachers
                    ]
                    );
                    break;

                case 'despre-noi':
                    $this->styles = [
                        ['name' => 'about-us.min', 'version' => '1.0.1'],
                    ];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("about-us");
                    break;

                case 'admin':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'membru') {
                        header("Location: " . SITE_URL . "/");
                    }

                    $this->header = false;
                    $this->admin_header = true;
                    $this->footer = false;
                    $this->title = 'Panoul de administrare';

                    if (empty($route[1])) {
                        $base_asset = ['name' => 'admin/courses.min', 'version' => '1.0.1'];
                        $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                        $this->scripts = [
                            ['name' => 'lib/moment.min'],
                            ['name' => 'vue-components/vue2-editor.min'],
                            ['name' => 'lib/sortable.min'],
                            ['name' => 'vue-components/vue-draggable.min.umd'],
                            ['name' => 'check-gsignin'],
                            ['name' => 'course-validations'], $base_asset,
                        ];

                        $this->content = new Template("admin/courses");
                        break;
                    }
                    switch ($route[1]) {

                        case 'courses':
                            $base_asset = ['name' => 'admin/courses.min', 'version' => '1.0.1'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue2-editor.min'],
                                ['name' => 'lib/sortable.min'],
                                ['name' => 'vue-components/vue-draggable.min.umd'],
                                ['name' => 'check-gsignin'],
                                ['name' => 'course-validations'], $base_asset,
                            ];

                            $this->content = new Template("admin/courses");
                            break;

                        case 'users':
                            $base_asset = ['name' => 'admin/users.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                ['name' => 'register-validations'],
                                ['name' => 'check-gsignin'], $base_asset,
                            ];

                            $this->content = new Template("admin/users");
                            break;

                        case 'courses-pending':
                            $base_asset = ['name' => 'admin/courses-pending.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'check-gsignin'], 
                                $base_asset,
                            ];

                            $this->content = new Template("admin/courses-pending");
                            break;
    
                        case 'coupons':
                            $base_asset = ['name' => 'admin/coupons.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [['name' => 'coupon-validations'], ['name' => 'check-gsignin'], $base_asset];
                            $this->content = new Template("admin/coupons");
                            break;

                        case 'email-messages':
                            $base_asset = ['name' => 'admin/automatic-emails.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [['name' => 'lib/sheetJS.min'], ['name' => 'check-gsignin'], ['name' => 'vue-components/vue2-editor.min'], $base_asset];
                            $this->content = new Template("admin/automatic-emails");
                            break;

                        case 'payments':
                            $base_asset = ['name' => 'admin/payments.min', 'version' => '1.0.5'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue2-editor.min'],
                                ['name' => 'check-gsignin'],
                                $base_asset,
                            ];

                            $this->content = new Template("admin/payments");
                            break;

                        case 'teachers-application':
                            $base_asset = ['name' => 'admin/teachers-application.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                ['name' => 'register-validations'],
                                ['name' => 'check-gsignin'], $base_asset,
                            ];

                            $this->content = new Template("admin/teachers-application");
                            break;
                        
                        case 'teachers-homepage':
                            $base_asset = ['name' => 'admin/teachers-homepage.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'check-gsignin'], $base_asset,
                            ];

                            $this->content = new Template("admin/teachers-homepage");
                            break;
                        
                        default:
                            $base_asset = ['name' => 'admin/courses.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard.min']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'lib/sortable.min'],
                                ['name' => 'vue-components/vue-draggable.min.umd'],
                                ['name' => 'vue-components/vue2-editor.min'],
                                ['name' => 'check-gsignin'], ['name' => 'course-validations'],
                                $base_asset,
                            ];

                            $this->content = new Template("admin/courses");
                            break;
                    }
                    break;

                case 'login':
                    if (isset($_SESSION['user_id'])) {
                        header("Location: " . $_SESSION['redirect_url']);
                    }

                    $base_asset = ['name' => 'login.min', 'version' => '1.0.1'];
                    $this->styles = [$base_asset];
                    $this->scripts = [$base_asset];
                    $this->content = new Template("login");
                    break;

                case 'inregistrare':
                    if (isset($_SESSION['user_id'])) {
                        header("Location: " . $_SESSION['redirect_url']);
                    }

                    $base_asset = ['name' => 'register.min', 'version' => '1.0.3'];
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'register-validations'],
                        $base_asset,
                    ];
                    $this->content = new Template("register");
                    break;

                case 'password-reset':
                    if (isset($_SESSION['user_id'])) {
                        header("Location: " . $_SESSION['redirect_url']);
                    }

                    $base_asset = ['name' => 'reset-password.min', 'version' => '1.0.0'];
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [['name' => 'register-validations'], $base_asset];
                    $this->footer = true;
                    $this->content = new Template("reset-password");
                    break;

                
                case 'contact':
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'register-validations'],
                        ['name' => 'contact.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("contact");
                    break;


                case 'categorie':
                    if (empty($route[1])) {
                        header("Location: " . SITE_URL);
                    }
                    $course = new Course;
                    $course_rating = new CourseRating;
                    $category = new Category;

                    $category_item = $category->get(clean_string($route[1]));

                    if (empty($category_item)) {
                        $this->scripts = [['name' => 'check-gsignin'], ['name' => 'home.min', 'version' => '1.0.0']];
                        $this->title = 'Pagina nu a fost găsită';
                        $this->content = new Template("404");
                        break;
                    }

                    $category_item = $category_item[0];

                    $base_asset = [['name' => 'courses.min', 'version' => '1.0.2']];
                    $this->scripts = $base_asset;
                    $courses_result = $course->search_by_category($category_item['category_id']);
                    $courses = [];
                    foreach ($courses_result as $course) {
                        $course['ratings'] = $course_rating->get_course_total($course['course_id']);
                        $courses[] = $course;
                    }
                    $category = new Category;
                    $categories = $category->get_courses();
                    $this->title = $category_item['name'];
                    $this->content = new Template("courses_search_result", [
                            'courses' => $courses, 
                            'search_item' => '', 
                            'category' => $category_item,
                            'categories' => $categories
                        ]
                    );

                    break;

                case 'cursuri':
                    $base_asset = [['name' => 'courses.min', 'version' => '1.0.0']];
                    $course = new Course;
                    if (!empty($route[1]) && $route[1] == 'adauga-curs') {
                        if (!isset($_SESSION['user_id'])) {
                            header("Location: " . SITE_URL . '/login/go?redirect_url=' . SITE_URL . '/courses/adauga-curs/');
                        }
                        $this->styles = [['name' => 'login.min'], ...$base_asset];
                        $this->scripts = [
                            ['name' => 'lib/moment.min'], ['name' => 'check-gsignin'], ['name' => 'vue-components/vue2-editor.min'],
                            ['name' => 'lib/sortable.min'], ['name' => 'vue-components/vue-draggable.min.umd'],
                            ['name' => 'course-validations'], ['name' => 'course/create/main.min', 'version' => '1.10.4'],
                        ];
                        $this->content = new Template("course/create/main");
                    } else if (!empty($route[1]) && $route[1] == 'edit') {
                        if (empty($route[2]) || !isset($_SESSION['user_id'])) {
                            header("Location: " . SITE_URL);
                        } else {
                            $course_id = $route[2];
                            $course_result = $course->get($course_id);
                            if (empty($course_result[0]) || !$course->user_has_access($course_id, $_SESSION)) {
                                header("Location: " . SITE_URL);
                            }

                        }
                        $this->styles = [['name' => 'login.min'], ...$base_asset];
                        $this->scripts = [
                            ['name' => 'lib/moment.min'], ['name' => 'check-gsignin'], ['name' => 'vue-components/vue2-editor.min'],
                            ['name' => 'lib/sortable.min'], ['name' => 'vue-components/vue-draggable.min.umd'],
                            ['name' => 'course-validations'], ['name' => 'course/edit/main.min', 'version' => '1.0.0'],
                        ];
                        $this->content = new Template("course/edit/main", [
                            'course_id' => $course_id
                        ]);
                    } else if (!empty($route[1]) && $route[1] != 'edit') {
                        if (isset($_GET['search'])) {
                            $this->scripts = $base_asset;
                            $this->styles = $base_asset;
                            $category = new Category;
                            $categories = $category->get_courses();
                            $courses_results = $course->search(
                                clean_string($_GET['search']),
                                clean_string($_GET['start_date']),
                                clean_string($_GET['category']),
                            );
                            $course_rating = new CourseRating;

                            $courses = [];
                            foreach ($courses_results as $course) {
                                $course['ratings'] = $course_rating->get_course_total($course['course_id']);
                                $courses[] = $course;
                            }
                            $this->content = new Template("courses_search_result", [
                                'courses' => $courses, 
                                'search_item' => $_GET['search'],
                                'categories' => $categories
                            ]);
                        } else if (!empty($route[2])) {

                            $student_course = new StudentCourse;
                            $course = new Course;
                            $member = new Member;

                            $course_result = $course->get_by_slug($route[1]);
                            if (empty($course_result[0])) {
                                header("Location: " . SITE_URL);
                            }
                            

                            $course_result = $course_result[0];
                            if (!$student_course->has_enroll($course_result['course_id'], $_SESSION['user_id']) && !$course->user_has_access($course_result['course_id'], $_SESSION) || !isset($_SESSION['user_id'])) {
                                header("Location: " . SITE_URL . '/login/go?redirect_url=' . SITE_URL . '/courses/' . $route[1] . '/' . $route[2] . '/');
                            }

                            $course_result['instructor'] = $member->get($course_result['user_id'], ['user_id', 'first_name', 'last_name', 'avatar'])[0];
                            $course_result['manage_course'] = $course->user_has_access($course_result['course_id'], $_SESSION);

                            $lesson = new Lesson;

                            $lesson_item = $lesson->get_by_id(clean_string($route[2]));
                            if (empty($lesson_item[0])) {
                                header("Location: " . SITE_URL . '/courses/' . $route[1]);
                            }

                            $lesson_meta = new LessonMeta;
                            $lesson_view = new LessonViews;
                            $section = new Section;

                            $lesson_item = $lesson_item[0];
                            $lesson_item['lesson_active'] = $lesson_meta->get_meta($lesson_item['lesson_id'], 'lesson_active');
                            $curriculum = $lesson->get_next_and_previous($lesson_item, $course_result['course_id']);
                            $course_sections = $section->get(course_id:$course_result['course_id']);

                            $course_result['current_user_has_enroll'] = $student_course->has_enroll($course_result['course_id'], $_SESSION['user_id']);
                            $course_result['manage_course'] = $course->user_has_access($course_result['course_id'], $_SESSION);
                            $course_result['sections_enrolled'] = Helper::unique_array($course_result['current_user_has_enroll'], 'section_id');
                            $course_result['sections_student_listed'] = [];
                            $course_result['sections'] = [];
                            $course_result['students_enrolled'] = Helper::unique_array($course_result['current_user_has_enroll'], 'user_id');

                            foreach ($course_sections as $section_result) {
                                $course_section = $section_result;
                                $lessons = $lesson->get($course_section['section_id']);
                                $course_section['items'] = [];
                                
                                foreach ($lessons as $result_lesson) {
                                    $course_lesson = $result_lesson;
                                    $course_lesson['meta'] = [];
                                    $lesson_metas = $lesson_meta->get($course_lesson['lesson_id']);
                                    foreach ($lesson_metas as $meta_val) {
                                        $course_lesson['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                                    }
                                    $course_section['items'][] = $course_lesson;
                                }
                                if (!empty($course_result['current_user_has_enroll']) && array_search(
                                    $section_result['section_id'], 
                                    array_column($course_result['sections_enrolled'], 'section_id') ) !== false ) {
                                    $course_result['sections_student_listed'][] = $course_section;
                                }
                                $course_result['sections'][] = $course_section;
                            }
                            $data = ['course' => $course_result, 'lesson' => $lesson_item, 'curriculum' => $curriculum];
                            switch ($lesson_item['lesson_type']) {
                                case 1:
                                    $class_type = $lesson_meta->get_meta($lesson_item['lesson_id'], 'class_type');
                                    switch ($class_type['lesson_meta_val']) {
                                        case 'zoom_meeting':
                                            $this->styles = [['name' => 'quill-editor.min'], ...$base_asset, ['name' => 'lesson.min']];
                                            $this->scripts = [
                                                ['name' => 'lib/moment.min'],
                                                ['name' => 'lib/moment-timezone-with-data.min'],
                                                ['name' => 'lib/vue-countdown.min'],
                                                ['name' => 'vue-components/vue2-editor.min'],
                                                ['name' => 'Classes/Course/TeacherMessage.min'],
                                                ['name' => 'Classes/Course/ChildProfile.min'],
                                                ['name' => 'check-gsignin'],
                                                ['name' => 'course/zoom_lesson.min', 'version' => '1.0.1'],
                                            ];
                                            $this->content = new Template("course/lesson/zoom", $data);
                                            break;

                                        case 'streaming':
                                            $this->styles = [['name' => 'quill-editor.min'], ...$base_asset, ['name' => 'lesson.min']];
                                            $this->scripts = [['name' => 'lib/moment.min'], ['name' => 'lib/moment-timezone-with-data.min'],
                                                ['name' => 'lib/vue-countdown.min'], ['name' => 'check-gsignin'],
                                                ['name' => 'course/streaming_lesson.min', 'version' => '1.0.0'],
                                            ];
                                            $this->content = new Template("course/lesson/streaming", $data);
                                            break;
                                    }
                                    break;
                            }
                        } else {
                            $slug = explode('?', $route[1])[0];
                            $course_result = $course->get_by_slug($slug);
                            if (!empty($course_result)) {

                                $category = new Category;
                                $subcategory = new SubCategory;
                                $course_meta = new CourseMeta;
                                $user_meta = new \Model\MemberMeta;
                                $section = new Section;
                                $lesson = new Lesson;
                                $lesson_meta = new LessonMeta;
                                $lesson_view = new LessonViews;
                                $member = new Member;
                                $student_course = new StudentCourse;
                                $course_rating = new CourseRating;

                                $course_result = $course_result[0];
                                $course_result['course_slug'] = $slug;

                                $course_result['instructor'] = $member->get($course_result['user_id'], ['user_id', 'first_name', 'last_name', 'avatar'])[0];
                                $course_result['instructor']['ratings'] = $course_rating->get_instructor_total($course_result['user_id']);
                                $meta = $user_meta->get($course_result['instructor']['user_id']);
                                $course_result['instructor']['meta'] = [];
                                foreach ($meta as $i => $e) {
                                        $course_result['instructor']['meta'][$e['meta_name']] = Helper::is_json($e['meta_val']) ? json_decode($e['meta_val']) : $e['meta_val'];;
                                }
                                $course_result['instructor']['courses'] = $course->get_by_user($course_result['instructor']['user_id'], course_id:$course_result['course_id']);
                                $instructor_courses = [];
                                if (!empty($course_result['instructor']['courses'])) {
                                    foreach ($course_result['instructor']['courses'] as $item) {
                                        $item['ratings'] = $course_rating->get_course_total($item['course_id']);
                                        $instructor_courses[] = $item;
                                    }
                                }
                                $course_result['instructor']['courses'] = $instructor_courses;
                                $course_result['students'] = $course->get_total_students($course_result['course_id']);
                                $course_result['classes'] = $section->get_total_lessons($course_result['course_id']);
                                $course_result['meta'] = [];
                                $course_result['category'] = !empty($course_result['category_id']) ? $category->get($course_result['category_id']) : [];
                                $course_result['subcategory'] = !empty($course_result['subcategory_id']) ? $subcategory->get($course_result['subcategory_id']) : [];
                                $course_result['has_live_classes'] = 0;
                                $metas = $course_meta->get($course_result['course_id']);
                                foreach ($metas as $meta) {
                                    $course_result['meta'][$meta['course_meta_name']] = $meta['course_meta_val'];
                                }

                                if (isset($_SESSION['user_id'])) {
                                    $course_result['current_user_has_enroll'] = $student_course->has_enroll($course_result['course_id'], $_SESSION['user_id']);
                                    $course_result['manage_course'] = $course->user_has_access($course_result['course_id'], $_SESSION);
                                    $course_result['sections_enrolled'] = Helper::unique_array($course_result['current_user_has_enroll'], 'section_id');
                                    $course_result['sections_student_listed'] = [];
                                }

                                if ($course_result['status'] != '1' && !$course_result['manage_course']) {
                                    header("Location: " . SITE_URL);
                                }

                                $course_sections = $section->get(course_id:$course_result['course_id']);
                                $course_result['sections'] = [];
                                foreach ($course_sections as $section_result) {
                                    $course_section = $section_result;
                                    $lessons = $lesson->get($course_section['section_id']);
                                    $course_section['items'] = [];
                                    
                                    foreach ($lessons as $result_lesson) {
                                        $course_lesson = $result_lesson;
                                        $course_lesson['meta'] = [];
                                        $lesson_metas = $lesson_meta->get($course_lesson['lesson_id']);
                                        foreach ($lesson_metas as $meta_val) {
                                            $course_lesson['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                                        }
                                        if (!$course_result['has_live_classes']) {
                                            $course_result['has_live_classes'] = isset($course_lesson['lesson_type']) &&
                                            $course_lesson['lesson_type'] == '2' ||
                                            $course_lesson['lesson_type'] == '3' ? 1 : 0;
                                        }
                                        $course_section['items'][] = $course_lesson;
                                    }
                                    if (!empty($course_result['current_user_has_enroll']) && array_search(
                                        $section_result['section_id'], 
                                        array_column($course_result['sections_enrolled'], 'section_id') ) !== false ) {
                                        $course_result['sections_student_listed'][] = $course_section;
                                    }
                                    $course_result['sections'][] = $course_section;
                                }
                                $course_result['popular_categories'] = $category->get_random();
                                $popular_courses = [];
                                $course_result['popular_courses'] = !empty($course_result['category_id']) 
                                ? $course->get_random_by_category($course_result['category_id'], $course_result['course_id']) : [];
                                foreach ($course_result['popular_courses'] as $item) {
                                    $item['ratings'] = $course_rating->get_course_total($item['course_id']);
                                    $popular_courses[] = $item;
                                }
                                $course_result['popular_courses'] = $popular_courses;
                                $this->title = $course_result['title'];
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'], 
                                    ['name' => 'check-gsignin'], 
                                    ['name' => 'lib/lodash.min'],
                                    ['name' => 'Classes/Course/Rating.min']
                                ];
                                $this->scripts[] = !empty($course_result['manage_course']) ? ['name' => 'course-manage.min', 'version' => '1.0.1'] : ['name' => 'course.min', 'version' => '1.0.9'] ;
                                $this->styles = [['name' => 'quill-editor.min'], ['name' => 'login.min'], ...$base_asset];
                                $this->content = new Template("course", $course_result);
                            }
                        }
                    } else {

                        $category = new Category;
                        $course_rating = new CourseRating;
                        $this->scripts = $base_asset;
                        $this->styles = $base_asset;
                        $courses_results = $course->get_enabled();
                        $courses = [];
                        foreach ($courses_results as $course) {
                            $course['ratings'] = $course_rating->get_course_total($course['course_id']);
                            $courses[] = $course;
                        }
                        $categories = $category->get_courses();
                        $this->content = new Template("courses", ['categories' => $categories, 'courses' => $courses]);
                    }
                    break;

                case 'profil-lector':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                    $this->scripts = [
                        ['name' => 'lib/moment.min'],
                        ['name' => 'check-gsignin'],
                        ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'profile.min', 'version' => '1.0.8'],
                    ];
                    $this->content = new Template("account/profile");
                    break;

                case 'panou-lectori':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $application = new Application;
                    $results = $application->get($_SESSION['user_id']);
                    if (count($results) > 0) {
                        $route[1] = empty($route[1]) ? '' : $route[1];
                        switch ($route[1]) {
                            case 'profilul-meu':
                                $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'],
                                    ['name' => 'check-gsignin'],
                                    ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                                    ['name' => 'vue-components/vue2-editor.min'],
                                    ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                    ['name' => 'register-validations'],
                                    ['name' => 'teacher-profile.min', 'version' => '1.0.0'],
                                ];
                                $this->title = "Profilul meu";
                                $this->content = new Template("account/teacher-profile");
                                break;
                            
                            case 'cursurile-mele':
                                $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'],
                                    ['name' => 'check-gsignin'],
                                    ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                    ['name' => 'register-validations'],
                                    ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                                    ['name' => 'my-courses.min', 'version' => '1.0.0'],
                                ];
                                $this->title = "Cursurile mele";
                                $this->content = new Template("my-courses");
                                break; 
                                                      
                            case 'ghid-curs-nou':
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'], ['name' => 'check-gsignin'],
                                    ['name' => 'home.min', 'version' => '1.10.4'],
                                ];
                                $this->title = "Ghid curs nou";
                                $this->content = new Template("new-class-guide");
                                break;
                                                                                                    
                            case 'retrospectiva':
                                $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'],
                                    ['name' => 'lib/moment-timezone-with-data.min'],
                                    ['name' => 'lib/chartJS.min'],
                                    ['name' => 'vue-components/vue-chart.min'],                        
                                    ['name' => 'check-gsignin'],
                                    ['name' => 'teacher-panel/statistics.min', 'version' => '1.0.0'],
                                ];
                                $this->title = "Retrospectiva";
                                $this->content = new Template("account/parts/private/teacher/statistics");
                                break;

                            default:
                                $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                                $this->scripts = [
                                    ['name' => 'lib/moment.min'],
                                    ['name' => 'check-gsignin'],
                                    ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                    ['name' => 'register-validations'],
                                    ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                                    ['name' => 'profile.min', 'version' => '1.0.8'],
                                ];
                                $this->title = "Panou lectori";
                                $this->content = new Template("account/teacher", $results[0]);
                                break;
                        }
                        
                    } else {
                        if (!isset($_SESSION['user_id'])) {
                            header("Location: " . SITE_URL . "/profile");
                        }
                    }
                    break;

                case 'panou':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $category = new Category;
                    $categories = $category->get_courses();

                    $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                    $this->scripts = [
                        ['name' => 'lib/moment.min'],
                        ['name' => 'check-gsignin'],
                        ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                        ['name' => 'panel.min', 'version' => '1.0.2'],
                    ];
                    $this->content = new Template("account/panel", [
                        'categories' => $categories
                    ]);
                    break;

                case 'checkout':
                    $this->styles = [['name' => 'login.min'], ['name' => 'checkout.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'Classes/Children.min', 'version' => '1.0.1'],
                        ['name' => 'https://www.paypal.com/sdk/js?client-id=' . PAYPAL_CLIENT_ID . '&currency=USD', 'external' => true],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'checkout.min', 'version' => '1.0.5'],
                    ];
                    $this->title = 'Checkout';
                    $this->content = new Template("checkout/main");
                    break;

                case 'approve-checkout':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'membru') {
                        header("Location: " . SITE_URL . "/");
                    }

                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'approve-checkout.min', 'version' => '1.0.2'],
                    ];
                    $this->content = new Template("checkout/approve-checkout");
                    break;

                case 'lectori':

                    if(!empty($_SESSION['user_id'])) {
                        $application = new Application;
                        $results = $application->get($_SESSION['user_id']);
                    
                        if (count($results) > 0) {
                            header("Location: " . SITE_URL . "/panou-lectori");
                        }
                    }

                    $this->styles = [
                        ['name' => 'how-to-become-teacher.min', 'version' => '1.0.1']
                    ];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'default.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("how-to-become-teacher");
                    break;

                case 'aplicatie-lector':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login/go?redirect_url=" . SITE_URL . "/aplicatie-lector");
                    }
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'vue-components/vue2-editor.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'become-teacher.min', 'version' => '1.0.3'],
                    ];
                    $this->content = new Template("become-teacher");
                    break;

                case 'termeni-si-conditii':
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'default.min', 'version' => '1.0.0'],
                    ];
                    $this->title = "Termeni și condiții de utilizare";
                    $this->content = new Template("legal/tos");
                    break;
                //Students safety
                case 'siguranta-cursantilor':
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'default.min', 'version' => '1.0.0'],
                    ];
                    $this->title = 'Siguranța cursanților';
                    $this->content = new Template("legal/learners-safety");
                    break;
                // Cookie policy
                case 'politica-de-utilizare-cookie-uri':
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'default.min', 'version' => '1.0.0'],
                    ];
                    $this->title = 'Politica de utilizare a cookie-uri';
                    $this->content = new Template("legal/cookie-policy");
                    break;
                // Personal data privacy
                case 'politica-privind-protectia-datelor-cu-caracter-personal':
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'default.min', 'version' => '1.0.0'],
                    ];
                    $this->title = 'Date cu caracter personal';
                    $this->content = new Template("legal/personal-data");
                    break;

                case 'verify-account':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL);
                    }
                    break;

                default:
                    $this->scripts = [['name' => 'check-gsignin'], ['name' => 'home.min', 'version' => '1.0.0']];
                    $this->title = 'Pagina nu a fost găsită';
                    $this->content = new Template("404");
                    break;
            }
            if (isset($_SESSION['user_id']) && empty($_SESSION['verified']) && $route[0] == 'verify-account') {
                $this->header = true;
                $this->admin_header = false;
                $this->footer = true;
                $this->styles = [['name' => 'login.min']];
                $this->scripts = [
                    ['name' => 'check-gsignin'],
                    ['name' => 'validate-user.min', 'version' => '1.0.0'],
                ];
                $this->title = "Verifică contul";
                $this->content = new Template("validate-user");
            } else if (isset($_SESSION['user_id']) && empty($_SESSION['verified'])) {
                $this->header = true;
                $this->admin_header = false;
                $this->footer = true;
                $this->styles = [['name' => 'login.min']];
                $this->scripts = [
                    ['name' => 'check-gsignin'],
                    ['name' => 'non-validated.min', 'version' => '1.0.0'],
                ];
                $this->title = "Contul dvs. trebuie să fie verificat";
                $this->content = new Template("non-validated");
            } else if (isset($_SESSION['user_id']) && empty($_SESSION['meta']['country'])) {
                $this->header = true;
                $this->admin_header = false;
                $this->footer = true;
                $base_asset = ['name' => 'complete-register.min', 'version' => '1.0.2'];
                $this->styles = [['name' => 'login.min']];
                $this->scripts = [
                    ['name' => 'check-gsignin'],
                    ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                    ['name' => 'register-validations'],
                    $base_asset,
                ];
                $this->content = new Template("complete-register");
            }
            $this->render();
        }
    }
    public function render()
    {
        $view = new Template("app", [
            "title" => $this->title,
            "content" => $this->content,
            "header" => $this->header,
            "admin_header" => $this->admin_header,
            "styles" => $this->styles,
            "scripts" => $this->scripts,
            "footer" => $this->footer,
        ]);
        echo $view;
    }
}
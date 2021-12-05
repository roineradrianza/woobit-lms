<?php
namespace Controller;

use Model\Application;
use Model\Category;
use Model\Course;
use Model\CourseMeta;
use Model\CourseSponsors;
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
                    $courses = $course->get_enabled(4);
                    $this->styles = [['name' => 'videojs-7.8.4', 'url' => 'https://vjs.zencdn.net/7.8.4/video-js.css'], ['external' => true, 'url' => 'https://unpkg.com/vue2-animate/dist/vue2-animate.min.css']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'], ['name' => 'lib/videojs-7.8.4.min'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("home", [
                        'courses' => $courses,
                    ]
                    );
                    break;

                case 'about-us':
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

                    switch ($route[1]) {

                        case 'courses':
                            $base_asset = ['name' => 'admin/courses.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'], 
                                ['name' => 'vue-components/vue2-editor.min'], 
                                ['name' => 'lib/sortable.min'], 
                                ['name' => 'vue-components/vue-draggable.min.umd'],
                                ['name' => 'check-gsignin'], 
                                ['name' => 'course-validations'], $base_asset
                            ];

                            $this->content = new Template("admin/courses");
                            break;

                        case 'users':
                            $base_asset = ['name' => 'admin/users.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                                ['name' => 'register-validations'],
                                ['name' => 'check-gsignin'],
                                ['name' => 'check-gsignin'], $base_asset,
                            ];

                            $this->content = new Template("admin/users");
                            break;

                        case 'coupons':
                            $base_asset = ['name' => 'admin/coupons.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
                            $this->scripts = [['name' => 'coupon-validations'], ['name' => 'check-gsignin'], $base_asset];
                            $this->content = new Template("admin/coupons");
                            break;

                        case 'email-messages':
                            $base_asset = ['name' => 'admin/automatic-emails.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
                            $this->scripts = [['name' => 'lib/sheetJS.min'], ['name' => 'check-gsignin'], ['name' => 'vue-components/vue2-editor.min'], $base_asset];
                            $this->content = new Template("admin/automatic-emails");
                            break;

                        case 'payments':
                            $base_asset = ['name' => 'admin/payments.min', 'version' => '1.0.3'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
                            $this->scripts = [
                                ['name' => 'lib/moment.min'],
                                ['name' => 'vue-components/vue2-editor.min'],
                                ['name' => 'check-gsignin'],
                                $base_asset,
                            ];

                            $this->content = new Template("admin/payments");
                            break;

                        default:

                        case 'courses':
                            $base_asset = ['name' => 'admin/courses.min', 'version' => '1.0.0'];
                            $this->styles = [['name' => 'login.min'], ['name' => 'admin/dashboard']];
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

                    $base_asset = ['name' => 'login.min', 'version' => '1.0.0'];
                    $this->styles = [$base_asset];
                    $this->scripts = [$base_asset];
                    $this->content = new Template("login");
                    break;

                case 'register':
                    if (isset($_SESSION['user_id'])) {
                        header("Location: " . $_SESSION['redirect_url']);
                    }

                    $base_asset = ['name' => 'register.min', 'version' => '1.0.0'];
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [['name' => 'vue-components/vue-tel-input-vuetify.min'], ['name' => 'register-validations'], $base_asset];
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
                    $this->content = new Template("contact");
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    break;

                case 'new-class-guide':
                    $this->scripts = [
                        ['name' => 'lib/moment.min'], ['name' => 'check-gsignin'],
                        ['name' => 'home.min', 'version' => '1.10.4'],
                    ];
                    $this->content = new Template("new-class-guide");
                    break;

                case 'courses':
                    $base_asset = [['name' => 'courses.min', 'version' => '1.0.0']];
                    $course = new Course;
                    if (!empty($route[1]) && $route[1] == 'create') {
                        if (!isset($_SESSION['user_id'])) {
                            header("Location: " . SITE_URL . '/login/?redirect_url=' . SITE_URL . '/courses/create/');
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
                            ['name' => 'course-validations'], ['name' => 'course/edit/main.min', 'version' => '1.10.4'],
                        ];
                        $this->content = new Template("course/edit/main");
                    } else if (!empty($route[1]) && $route[1] != 'edit') {
                        if (isset($_GET['search'])) {
                            $this->scripts = $base_asset;
                            $this->styles = $base_asset;
                            $courses = $course->search(clean_string($_GET['search']));
                            $this->content = new Template("courses_search_result", ['courses' => $courses, 'search_item' => $_GET['search']]);
                        } else if (!empty($route[2])) {

                            $student_course = new StudentCourse;
                            $course = new Course;

                            $course_result = $course->get_by_slug($route[1]);
                            if (empty($course_result[0])) {
                                header("Location: " . SITE_URL);
                            }

                            $course_result = $course_result[0];
                            if (!$student_course->has_enroll($course_result['course_id'], $_SESSION['user_id']) && !$course->user_has_access($course_result['course_id'], $_SESSION) || !isset($_SESSION['user_id'])) {
                                header("Location: " . SITE_URL . '/login/?redirect_url=' . SITE_URL . '/courses/' . $route[1] . '/' . $route[2] . '/');
                            }

                            $lesson = new Lesson;
                            $course_sponsor = new CourseSponsors;

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
                            $course_result['sections'] = [];
                            foreach ($course_sections as $section_result) {
                                $course_section = $section_result;
                                $lessons = $lesson->get($course_section['section_id']);
                                $course_section['items'] = [];
                                $total_lessons = count($lessons);
                                $total_completed = 0;
                                foreach ($lessons as $result_lesson) {
                                    $course_lesson = $result_lesson;
                                    $course_lesson['completed'] = $lesson_view->is_completed($course_lesson['lesson_id'], $_SESSION['user_id']);
                                    $total_completed = $course_lesson['completed'] ? $total_completed + 1 : $total_completed;
                                    $course_lesson['meta'] = [];
                                    $lesson_metas = $lesson_meta->get($course_lesson['lesson_id']);
                                    foreach ($lesson_metas as $meta_val) {
                                        $course_lesson['meta'][$meta_val['lesson_meta_name']] = $meta_val['lesson_meta_val'];
                                    }
                                    $course_section['items'][] = $course_lesson;
                                }
                                if ($total_lessons == $total_completed) {
                                    $course_section['completed'] = true;
                                }

                                $course_result['sections'][] = $course_section;
                            }
                            $data = ['course' => $course_result, 'lesson' => $lesson_item, 'curriculum' => $curriculum];
                            switch ($lesson_item['lesson_type']) {
                                case 1:
                                    $class_type = $lesson_meta->get_meta($lesson_item['lesson_id'], 'class_type');
                                    $data['course']['course_sponsors'] = $course_sponsor->get($data['course']['course_id']);
                                    switch ($class_type['lesson_meta_val']) {
                                        case 'zoom_meeting':
                                            $this->styles = [['name' => 'quill-editor.min'], ...$base_asset, ['name' => 'lesson-v1.0']];
                                            $this->scripts = [
                                                ['name' => 'lib/moment.min'],
                                                ['name' => 'lib/moment-timezone-with-data.min'],
                                                ['name' => 'lib/vue-countdown.min'],
                                                ['name' => 'check-gsignin'],
                                                ['name' => 'course/zoom_lesson.min', 'version' => '1.10.3'],
                                            ];
                                            $this->content = new Template("course/lesson/zoom", $data);
                                            break;

                                        case 'streaming':
                                            $this->styles = [['name' => 'quill-editor.min'], ...$base_asset, ['name' => 'lesson-v1.0']];
                                            $this->scripts = [['name' => 'lib/moment.min'], ['name' => 'lib/moment-timezone-with-data.min'],
                                                ['name' => 'lib/vue-countdown.min'], ['name' => 'check-gsignin'],
                                                ['name' => 'course/streaming_lesson.min', 'version' => '1.0.7'],
                                            ];
                                            $this->content = new Template("course/lesson/streaming", $data);
                                            break;

                                        default:

                                            $student_course = new StudentCourse;
                                            $data['course']['manage_course'] = $course->user_has_access($course_result['course_id'], $_SESSION);
                                            $this->styles = [
                                                ['name' => 'quill-editor.min'], ['name' => 'videojs-7.8.4'],
                                                ['name' => 'videojs-resolution-switcher.min'], ['name' => 'login.min'],
                                                ['name' => 'lesson-v1.0'],
                                            ];
                                            $this->scripts = [
                                                ['name' => 'lib/videojs-7.8.4.min'], ['name' => 'lib/videojs-resolution-switcher.min'],
                                                ['name' => 'lib/moment.min'], ['name' => 'lib/moment-timezone-with-data.min'],
                                                ['name' => 'vue-components/vue-video.min'], ['name' => 'vue-components/vue2-editor.min'],
                                                ['name' => 'check-gsignin'], ['name' => 'course/video_lesson.min', 'version' => '1.10.4'],
                                            ];
                                            $this->content = new Template("course/lesson/video", $data);
                                            break;
                                    }
                                    break;

                                case 4:
                                    $this->styles = [...$base_asset];
                                    $this->scripts = [
                                        ['name' => 'check-gsignin'],
                                        ['name' => 'course/class_resources.min', 'version' => '1.0.0'],
                                    ];
                                    $this->content = new Template("course/lesson/resources", $data);
                                    break;
                            }
                        } else {

                            $course_result = $course->get_by_slug(explode('?', $route[1])[0]);
                            if (!empty($course_result)) {

                                $category = new Category;
                                $subcategory = new SubCategory;
                                $course_meta = new CourseMeta;
                                $section = new Section;
                                $lesson = new Lesson;
                                $lesson_meta = new LessonMeta;
                                $lesson_view = new LessonViews;
                                $member = new Member;
                                $student_course = new StudentCourse;

                                $course_result = $course_result[0];

                                $instructor = $member->get($course_result['user_id'], ['user_id', 'first_name', 'last_name', 'avatar']);
                                $course_result['instructor'] = $instructor[0];
                                $course_result['instructor']['courses'] = $course->get_by_user($course_result['instructor']['user_id'], course_id:$course_result['course_id']);
                                $course_result['students'] = $course->get_total_students($course_result['course_id']);
                                $course_result['classes'] = $section->get_total_lessons($course_result['course_id']);
                                $course_result['instructors'] = $student_course->get_instructors($course_result['course_id']);
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
                                    if (!empty($course_result['meta']['paid_certified']) && intval($course_result['meta']['paid_certified'])) {

                                        $order = new Orders;
                                        $course_result['current_user_has_paid_certified'] =
                                        !empty($order->get_course_orders($_SESSION['user_id'], $course_result['course_id'], status:1)) ?
                                        true : false;
                                    }
                                }
                                $course_sections = $section->get(course_id:$course_result['course_id']);
                                $course_result['sections'] = [];
                                foreach ($course_sections as $section_result) {
                                    $course_section = $section_result;
                                    $lessons = $lesson->get($course_section['section_id']);
                                    $course_section['items'] = [];
                                    $total_lessons = count($lessons);
                                    $total_completed = 0;
                                    foreach ($lessons as $result_lesson) {
                                        $course_lesson = $result_lesson;
                                        if (!empty($course_result['current_user_has_enroll'])) {
                                            $course_lesson['completed'] = $lesson_view->is_completed($course_lesson['lesson_id'], $_SESSION['user_id']);
                                            $total_completed = $course_lesson['completed'] ? $total_completed + 1 : $total_completed;
                                        }
                                        if (!empty($course_lesson['user_id'])) {
                                            $lesson_teacher = $member->get($course_lesson['user_id'], ['first_name', 'last_name', 'avatar']);
                                            $course_lesson['teacher'] = $lesson_teacher[0];
                                        }
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
                                    if ($total_lessons == $total_completed) {
                                        $course_section['completed'] = true;
                                    }

                                    $course_result['sections'][] = $course_section;
                                }
                                $this->title = $course_result['title'];
                                $this->scripts = [['name' => 'lib/moment.min'], ['name' => 'check-gsignin'], ['name' => 'lib/lodash.min']];
                                if (isset($course_result['manage_course']) && $course_result['manage_course']) {
                                    $this->scripts[] = ['name' => 'vue-components/vue-json-excel.umd'];
                                    $this->scripts[] = ['name' => 'course-manage.min', 'version' => '1.11.0'];
                                } else {
                                    $this->scripts[] = ['name' => 'course.min', 'version' => '1.0.8'];
                                }
                                $this->styles = [['name' => 'quill-editor.min'], ['name' => 'login.min'], ...$base_asset];
                                $this->content = new Template("course", $course_result);
                            }
                        }
                    } else {

                        $category = new Category;
                        $this->scripts = $base_asset;
                        $this->styles = $base_asset;
                        $courses = $course->get_enabled();
                        $categories = $category->get_courses();
                        $this->content = new Template("courses", ['categories' => $categories, 'courses' => $courses]);
                    }
                    break;

                case 'profile':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                    $application = new Application;
                    $member = new Member;
                    $user_meta = new MemberMeta;
                    $results = $application->get($_SESSION['user_id']);
                    if (count($results) > 0) {
                        $item = $results[0];
                        $user = $member->get($item['user_id'])[0];

                        $item['first_name'] = $user['first_name'];
                        $item['last_name'] = $user['last_name'];

                        $meta = $user_meta->get($item['user_id']);
                        $item['meta'] = [];
                        foreach ($meta as $i => $e) {
                            $item['meta'][$e['meta_name']] = Helper::is_json($e['meta_val']) ? Helper::clean_json($e['meta_val']) : $e['meta_val'];
                        }
                        $this->scripts = [
                            ['name' => 'lib/moment.min'],
                            ['name' => 'check-gsignin'],
                            ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                            ['name' => 'register-validations'],
                            ['name' => 'Classes/Children.min'],
                            ['name' => 'profile.min', 'version' => '1.0.5'],
                        ];
                        $this->content = new Template("account/teacher");
                    } else {
                        $this->scripts = [
                            ['name' => 'lib/moment.min'],
                            ['name' => 'check-gsignin'],
                            ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                            ['name' => 'register-validations'],
                            ['name' => 'Classes/Children.min'],
                            ['name' => 'profile.min', 'version' => '1.0.5'],
                        ];
                        $this->content = new Template("account/profile");
                    }
                    break;

                case 'my-profile':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                    $this->scripts = [
                        ['name' => 'lib/moment.min'],
                        ['name' => 'check-gsignin'],
                        ['name' => 'Classes/Children.min'],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'profile.min', 'version' => '1.0.5'],
                    ];
                    $this->content = new Template("account/profile");
                    break;

                case 'my-courses':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login");
                    }

                    $this->styles = [['name' => 'login.min'], ['name' => 'profile']];
                    $this->scripts = [
                        ['name' => 'lib/moment.min'],
                        ['name' => 'check-gsignin'],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'Classes/Children.min'],
                        ['name' => 'my-courses.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("my-courses");
                    break;

                case 'checkout':
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'https://www.paypal.com/sdk/js?client-id=' . PAYPAL_CLIENT_ID . '&currency=USD', 'external' => true],
                        ['name' => 'checkout.min', 'version' => '1.0.2'],
                    ];
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

                case 'how-become-teacher':
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("how-to-become-teacher");
                    break;

                case 'become-teacher':
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: " . SITE_URL . "/login/?redirect_url=" . SITE_URL . "/become-teacher");
                    }
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'vue-components/vue-tel-input-vuetify.min'],
                        ['name' => 'register-validations'],
                        ['name' => 'become-teacher.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("become-teacher");
                    break;

                case 'terms-and-conditions':
                    $this->styles = [['name' => 'login.min']];
                    $this->scripts = [
                        ['name' => 'check-gsignin'],
                        ['name' => 'lib/moment.min'],
                        ['name' => 'home.min', 'version' => '1.0.0'],
                    ];
                    $this->content = new Template("tos");
                    break;

                default:
                    $this->scripts = [['name' => 'check-gsignin'], ['name' => 'home.min', 'version' => '1.0.0']];
                    $this->title = 'Página no encontrada';
                    $this->content = new Template("404");
                    break;
            }
            if (isset($_SESSION['user_id']) && empty($_SESSION['meta']['country'])) {
                $this->header = true;
                $this->admin_header = false;
                $this->styles = [];
                $this->scripts = [];
                $base_asset = ['name' => 'complete-register.min', 'version' => '1.0.0'];
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

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class StudentCourse extends DB
{
    private $table = "course_users";
    private $table_course_coupons = "course_coupons";
    private $table_student_coupons = "student_coupons";
    private $table_sections = "sections";
    private $table_lessons = "lessons";
    private $table_lesson_views = "lesson_views";
    private $table_question_attempt = "question_attempts";
    private $table_users = "users";
    private $table_course = "courses";
    private $table_certified = "course_certifieds";

    private $id_column = "course_user_id";
    private $id_user_column = "user_id";
    private $id_course_column = "course_id";

    public function get($id = 0, $user_id = 0)
    {
        if (empty($id) || empty($user_id)) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id ";
            if ($user_id != 0) {
                $sql .= " OR {$this->id_user_column} = $user_id";
            }

        } else {
            $sql = "SELECT * FROM {$this->table}";
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_users_approved($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT U.user_id, U.email,
        CONCAT(U.first_name, ' ', U.last_name) full_name, certified_url
        FROM {$this->table_users} U INNER JOIN {$this->table_certified} C
        ON C.user_id = U.user_id WHERE C.{$this->id_course_column} = $course_id";

        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_user_progress($course_id = 0, $user_id = 0)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }
        $sql = "SELECT * FROM {$this->table} WHERE
		{$this->id_course_column} = $course_id AND {$this->id_user_column} = $user_id LIMIT 1";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_students($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT CU.user_id, first_name, last_name, email FROM {$this->table} CU INNER JOIN {$this->table_users} U ON U.user_id = CU.user_id WHERE user_rol IN ('estudiante', 'residente') AND course_id = $course_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_all_users($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT CU.user_id, first_name, last_name, email FROM {$this->table} CU INNER JOIN {$this->table_users} U ON U.user_id = CU.user_id WHERE course_id = $course_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_all_students_quizzes($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT QA.user_id, score, approved, LV.lesson_id FROM {$this->table_question_attempt} QA INNER JOIN {$this->table_lesson_views} LV ON LV.lesson_view_id = QA.lesson_view_id INNER JOIN {$this->table_lessons} L ON L.lesson_id = LV.lesson_id INNER JOIN {$this->table_sections} S ON S.section_id = L.section_id WHERE course_id = $course_id AND lesson_type = 2 ORDER BY lesson_order DESC";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_rol($course_id = 0, $rol = '')
    {
        if (empty($course_id) || empty($rol)) {
            return [];
        }

        $sql = "SELECT CU.user_id, first_name, last_name, email FROM {$this->table} CU INNER JOIN {$this->table_users} U ON U.user_id = CU.user_id WHERE course_id = $course_id AND user_rol = '$rol'";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_pendings_students($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT SC.user_id, first_name, last_name, email FROM {$this->table_student_coupons} SC INNER JOIN {$this->table_course_coupons} CC ON CC.coupon_id = SC.coupon_id INNER JOIN {$this->table} CU ON CU.course_id = CC.course_id INNER JOIN {$this->table_users} U ON U.user_id = SC.user_id WHERE CC.discount = 100 AND CC.student_rol IN ('estudiante', 'residente') AND CU.course_id = $course_id AND SC.already_used = 0 GROUP BY SC.user_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_pendings_instructors($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT SC.user_id, first_name, last_name, email FROM {$this->table_student_coupons} SC INNER JOIN {$this->table_course_coupons} CC ON CC.coupon_id = SC.coupon_id INNER JOIN {$this->table} CU ON CU.course_id = CC.course_id INNER JOIN {$this->table_users} U ON U.user_id = SC.user_id WHERE CC.discount = 100 AND CC.student_rol IN ('profesor') AND CU.course_id = $course_id AND SC.already_used = 0 GROUP BY SC.user_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_instructors($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT CU.user_id, avatar, first_name, last_name, email FROM {$this->table} CU INNER JOIN {$this->table_users} U ON U.user_id = CU.user_id WHERE user_rol = 'profesor' AND course_id = $course_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (user_rol, user_id, course_id) VALUES('$user_rol', $user_id, $course_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function has_enroll($course_id, $user_id)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }

        $sql = "SELECT user_id, user_rol FROM {$this->table} WHERE user_id = $user_id AND course_id = $course_id";
        $results = $this->execute_query($sql);
        $result = [];
        while ($row = $results->fetch_assoc()) {
            $result = $row;
        }
        return $result;
    }

    public function update_course_progress($course_id = 0, $user_id = 0, $search_by_slug = false)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }

        $course_column = !$search_by_slug ? 'course_id' : 'slug';
        $sql = !$search_by_slug ? "SELECT progress, course_id FROM {$this->table} WHERE {$this->id_course_column} = $course_id AND {$this->id_user_column} = $user_id" : "SELECT progress, CU.course_id FROM {$this->table} CU INNER JOIN {$this->table_course} C ON C.course_id = CU.course_id WHERE slug = '$course_id' AND CU.{$this->id_user_column} = $user_id";
        $result = $this->execute_query($sql);
        $student_progress = $result->fetch_assoc();
        $course_id = $student_progress['course_id'];

        if (!isset($student_progress['progress'])) {
            return false;
        }

        $sql = "SELECT (SELECT COUNT(lesson_id) FROM {$this->table_lessons} L INNER JOIN {$this->table_sections} S ON S.section_id = L.section_id INNER JOIN {$this->table_course} C ON S.course_id = C.course_id WHERE C.{$this->id_course_column} = $course_id AND lesson_type IN(1, 2, 3)) AS total_lessons,
		(SELECT COUNT(LV.lesson_id) FROM {$this->table_lesson_views} LV INNER JOIN {$this->table_lessons} L ON L.lesson_id = LV.lesson_id INNER JOIN {$this->table_sections} S ON S.section_id = L.section_id INNER JOIN {$this->table_course} C ON S.course_id = C.course_id WHERE C.{$this->id_course_column} = $course_id AND lesson_type IN(1, 2, 3) AND LV.{$this->id_user_column} = $user_id) AS total_completed";
        $result = $this->execute_query($sql);
        $course_lessons = $result->fetch_assoc();

        if ($student_progress['progress'] >= 100) {
            return true;
        }

        $total_progress = round(($course_lessons['total_completed'] / $course_lessons['total_lessons']) * 100);
        $sql = "UPDATE {$this->table} SET progress = $total_progress WHERE {$this->id_course_column} = $course_id AND {$this->id_user_column} = $user_id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($user_id = 0, $course_id = 0)
    {
        if (empty($user_id) || empty($course_id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE user_id = $user_id AND course_id = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

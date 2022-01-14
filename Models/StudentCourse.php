<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class StudentCourse extends DB
{
    private $table = "course_users";
    private $table_sections = "sections";
    private $table_lessons = "lessons";
    private $table_lesson_views = "lesson_views";
    private $table_users = "children";
    private $table_parents = "users";
    private $table_course = "courses";

    private $id_column = "course_user_id";
    private $id_user_column = "user_id";
    private $id_course_column = "course_id";

    public function get($id = 0, $children_id = 0)
    {
        if (empty($id) || empty($children_id)) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id ";
            if (!empty($children_id)) {
                $sql .= " OR {$this->id_user_column} = $children_id";
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

    
    public function get_classmates($lesson_id = 0) : Array
    {
        if (empty($lesson_id)) {
            return [];
        }

        $sql = "SELECT first_name, last_name, gender, C.children_id AS user_id FROM {$this->table_lessons} L INNER JOIN {$this->table_sections} S
        ON S.section_id = L.section_id INNER JOIN {$this->table} CU ON CU.section_id = S.section_id INNER JOIN {$this->table_users} C
        ON C.children_id = CU.user_id WHERE L.lesson_id = $lesson_id";
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

        $sql = "SELECT user_id, email,
        CONCAT(first_name, ' ', last_name) full_name
        FROM {$this->table_users} WHERE {$this->id_course_column} = $course_id";

        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_user_progress($course_id = 0, $children_id = 0)
    {
        if (empty($course_id) || empty($children_id)) {
            return false;
        }
        $sql = "SELECT * FROM {$this->table} WHERE
		{$this->id_course_column} = $course_id AND {$this->id_user_column} = $children_id LIMIT 1";
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

        $sql = "SELECT CU.user_id, first_name, last_name, email FROM {$this->table} CU 
        INNER JOIN {$this->table_users} U ON U.child_id = CU.user_id WHERE course_id = $course_id";
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

        $sql = "SELECT CU.child_id, first_name, last_name, email FROM {$this->table} CU 
        INNER JOIN {$this->table_users} U ON U.child_id = CU.user_id WHERE course_id = $course_id";
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
        $sql = "INSERT INTO {$this->table} (user_id, course_id, section_id) VALUES($children_id, $course_id, $section_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function has_enroll($course_id, $user_id, $section_id = NULL)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }

        $sql = " SELECT C.first_name, C.last_name, C.gender, CU.user_id, section_id FROM {$this->table} CU INNER JOIN {$this->table_users} C ON C.children_id = CU.user_id 
        INNER JOIN {$this->table_parents} U ON U.user_id = C.user_id WHERE U.user_id = $user_id AND course_id = $course_id";
        $sql .= !empty($section_id) ? " AND section_id = $section_id" : '';
        $results = $this->execute_query($sql);
        $result = [];
        while ($row = $results->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }

    public function update_course_progress($course_id = 0, $children_id = 0, $search_by_slug = false)
    {
        if (empty($course_id) || empty($children_id)) {
            return false;
        }

        $course_column = !$search_by_slug ? 'course_id' : 'slug';
        $sql = !$search_by_slug ? "SELECT progress, course_id FROM {$this->table} WHERE {$this->id_course_column} = $course_id 
        AND {$this->id_user_column} = $children_id" 
        : "SELECT progress, CU.course_id FROM {$this->table} CU INNER JOIN {$this->table_course} C ON C.course_id = CU.course_id 
        WHERE slug = '$course_id' AND CU.{$this->id_user_column} = $children_id";
        $result = $this->execute_query($sql);
        $student_progress = $result->fetch_assoc();
        $course_id = $student_progress['course_id'];

        if (!isset($student_progress['progress'])) {
            return false;
        }

        $sql = "SELECT (SELECT COUNT(lesson_id) FROM {$this->table_lessons} L INNER JOIN {$this->table_sections} 
        S ON S.section_id = L.section_id INNER JOIN {$this->table_course} C ON S.course_id = C.course_id 
        WHERE C.{$this->id_course_column} = $course_id AND lesson_type IN(1)) AS total_lessons,
		(SELECT COUNT(LV.lesson_id) FROM {$this->table_lesson_views} LV INNER JOIN {$this->table_lessons} L 
        ON L.lesson_id = LV.lesson_id INNER JOIN {$this->table_sections} S ON S.section_id = L.section_id 
        INNER JOIN {$this->table_course} C ON S.course_id = C.course_id WHERE C.{$this->id_course_column} = $course_id 
        AND lesson_type IN(1) AND LV.{$this->id_user_column} = $children_id) AS total_completed";
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

    public function delete($children_id = 0, $course_id = 0)
    {
        if (empty($children_id) || empty($course_id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE user_id = $children_id AND course_id = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

}
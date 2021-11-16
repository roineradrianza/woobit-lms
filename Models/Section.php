<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Section extends DB
{
    private $table = "sections";
    private $table_course_users = "course_users";
    private $table_lesson = "lessons";
    private $table_lesson_views = "lesson_views";
    private $id_column = "section_id";
    private $id_course_column = "course_id";

    public function get($id = 0, $course_id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
        } else if ($id == 0 && $course_id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $course_id";
        } else {
            return false;
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_total_lessons($course_id = 0, $class_type = 1)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT COUNT(L.lesson_id) as total FROM {$this->table} S
        INNER JOIN {$this->table_lesson} L ON L.section_id = S.section_id WHERE {$this->id_course_column} = $course_id AND lesson_type = $class_type";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function get_section_by_order($course_id = 0, $order = 0)
    {
        if ($course_id == 0 || $order == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $course_id AND section_order = $order";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_total_views($section_id = 0, $course_id = 0)
    {
        if (empty($section_id) || empty($course_id)) {
            return false;
        }
        $sql = "SELECT lesson_id as id, lesson_name,
        (SELECT COUNT(LV.user_id) FROM {$this->table_lesson_views} LV INNER JOIN {$this->table_course_users} CU
        ON CU.user_id = LV.user_id WHERE CU.course_id = $course_id AND video_view = 1
        AND lesson_id = id AND user_rol IN ('residente', 'estudiante')) AS video_views, (SELECT COUNT(LV.user_id)
        FROM {$this->table_lesson_views} LV INNER JOIN {$this->table_course_users} CU
        ON CU.user_id = LV.user_id WHERE CU.course_id = $course_id
        AND zoom_view = 1 AND lesson_id = id AND user_rol IN ('residente', 'estudiante')) AS zoom_views
        FROM {$this->table_lesson} WHERE section_id = $section_id AND lesson_type = 1";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_total_quizzes_done($section_id = 0, $course_id = 0)
    {
        if (empty($section_id) || empty($course_id)) {
            return false;
        }

        $sql = "SELECT lesson_id as id, lesson_name, (SELECT COUNT(LV.user_id) FROM {$this->table_lesson_views} LV
		INNER JOIN {$this->table_course_users} CU ON CU.user_id = LV.user_id
		WHERE CU.course_id = $course_id AND lesson_id = id AND user_rol IN ('residente', 'estudiante')) AS students
		 FROM {$this->table_lesson} WHERE section_id = $section_id AND lesson_type = 2;";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [], $id = 0)
    {
        if (empty($data) || $id == 0) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (section_name, course_id) VALUES('$section_name', $id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET section_name = '$section_name', section_order = $section_order WHERE {$this->id_column} = $id AND {$this->id_course_column} = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id, $course_id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id AND {$this->id_course_column} = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

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

    public function get($id = 0, $course_id = 0) : Array
    {
        if (!empty($id)) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id ORDER BY section_order ASC";
        } else if ($id == 0 && $course_id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $course_id ORDER BY section_order ASC";
        } else {
            return [];
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_total_lessons($course_id = 0, $class_type = 1) : Mixed
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT COUNT(L.lesson_id) as total FROM {$this->table} S
        INNER JOIN {$this->table_lesson} L ON L.section_id = S.section_id WHERE {$this->id_course_column} = $course_id AND lesson_type = $class_type";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function get_section_by_order($course_id = 0, $order = 0) : Array
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

    public function get_total_views($section_id = 0, $course_id = 0) : Array
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

    public function create($data = [], $id = 0) : Mixed
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (section_name, start_date, frecuency, classes, start_time, end_time, course_id) 
        VALUES('$section_name', '$start_date', $frecuency, $classes, '$start_time', '$end_time', $id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = []) : Bool
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET section_name = '$section_name', start_date = '$start_date',  frecuency = $frecuency,
        section_order = $section_order, classes = $classes, start_time = '$start_time', end_time = '$end_time' 
        WHERE {$this->id_column} = $id AND {$this->id_course_column} = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id, $course_id) : Bool
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id AND {$this->id_course_column} = $course_id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public static function frecuency_text($frecuency, $classes) : String
    {
        $frecuency_sentence = '';
        switch ($frecuency) {
            case 1:
                $frecuency_txt = ' pe săptămână';
                if ($classes <= 1) {
                    $frecuency_sentence = "O dată $frecuency_txt";
                } else {
                    $frecuency_sentence = "De $classes ori $frecuency_txt";
                }
                break;

            case 2:
                $frecuency_txt = ' pe lună';
                if ($classes <= 1) {
                    $frecuency_sentence = "O dată $frecuency_txt";
                } else {
                    $frecuency_sentence = "De $classes ori $frecuency_txt";
                }
                break;
        }

        return $frecuency_sentence;
    }

}
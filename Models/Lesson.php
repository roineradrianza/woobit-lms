<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Lesson extends DB
{
    private $table = "lessons";
    private $table_lesson_meta = "lessons_meta";
    private $table_section = "sections";
    private $table_course = "courses";
    private $id_column = "lesson_id";
    private $id_section_column = "section_id";

    public function get(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_section_column} = $id ORDER BY lesson_order ASC";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_type(int $id = 0, int $lesson_type = 1)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_section_column} = $id AND lesson_type = $lesson_type";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_quizzes(int $course_id = 0)
    {
        if ($course_id == 0) {
            return false;
        }

        $sql = "SELECT lesson_id, lesson_name, (SELECT lesson_meta_val FROM {$this->table_lesson_meta} WHERE lesson_meta_name = 'max_score' LIMIT 1) AS max_score, (SELECT lesson_meta_val FROM {$this->table_lesson_meta} WHERE lesson_meta_name = 'min_score' LIMIT 1) AS min_score FROM {$this->table} L INNER JOIN {$this->table_section} S ON S.section_id = L.section_id INNER JOIN {$this->table_course} C ON C.course_id = S.course_id WHERE C.course_id = $course_id AND lesson_type = 2";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_id(int $id = 0)
    {
        if ($id == 0) {
            return [];
        }

        $sql = "SELECT lesson_id, lesson_name, lesson_order, lesson_type, section_id, U.user_id, U.first_name, U.last_name, U.avatar FROM {$this->table} L LEFT JOIN users U ON U.user_id = L.user_id WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_lesson_by_order($section_id = 0, $order = 0)
    {
        if ($section_id == 0 || $order == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_section_column} = $section_id AND lesson_order = $order";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_next_and_previous($lesson = [], $course_id = 0)
    {
        if (empty($lesson) || empty($course_id)) {
            return [];
        }

        extract($lesson);
        $curriculum = [];
        $prev_lesson = $lesson_order - 1;
        $next_lesson = $lesson_order + 1;
        $sql = "SELECT lesson_name, lesson_id FROM {$this->table} WHERE {$this->id_section_column} = $section_id AND lesson_order = $prev_lesson LIMIT 1";
        $result = $this->execute_query($sql);
        $prev = $result->fetch_assoc();
        $curriculum['prev_lesson'] = !empty($prev) ? $prev : [];
        if (empty($curriculum['prev_lesson'])) {
            $sql = "SELECT * FROM {$this->table_section} WHERE course_id = $course_id";
            $result = $this->execute_query($sql);
            $sections = [];
            while ($row = $result->fetch_assoc()) {
                $sections[] = $row;
            }
            $i = 0;
            foreach ($sections as $section_key => $section) {
                if ($section['section_id'] == $section_id) {
                    if ($i - 1 == -1) {
                        break;
                    }

                    $prev_section = !empty($sections[$i--]) ? $sections[$i--] : [];
                    if (!empty($prev_section)) {
                        $sql = "SELECT lesson_name, lesson_id FROM {$this->table} WHERE {$this->id_section_column} = {$prev_section['section_id']} ORDER BY lesson_order DESC LIMIT 1";
                        $result = $this->execute_query($sql);
                        $prev = $result->fetch_assoc();
                        $curriculum['prev_lesson'] = !empty($prev) && $prev['lesson_id'] && $section['section_order'] != 0 ? $prev : [];
                    }
                    break;
                }
                $i++;
            }
        }
        $sql = "SELECT lesson_name, lesson_id FROM {$this->table} WHERE {$this->id_section_column} = $section_id AND lesson_order = $next_lesson LIMIT 1";
        $result = $this->execute_query($sql);
        $next = $result->fetch_assoc();
        $curriculum['next_lesson'] = !empty($next) ? $next : [];
        if (empty($curriculum['next_lesson'])) {
            $sql = "SELECT * FROM {$this->table_section} WHERE course_id = $course_id";
            $result = $this->execute_query($sql);
            $sections = [];
            while ($row = $result->fetch_assoc()) {
                $sections[] = $row;
            }
            $i = 0;
            foreach ($sections as $section_key => $section) {
                if ($section['section_id'] == $section_id) {
                    $next_section = !empty($sections[$i + 1]) ? $sections[$i + 1] : [];
                    if (!empty($next_section)) {
                        $sql = "SELECT lesson_name, lesson_id FROM {$this->table} WHERE {$this->id_section_column} = {$next_section['section_id']} ORDER BY lesson_id ASC LIMIT 1";
                        $result = $this->execute_query($sql);
                        $next = $result->fetch_assoc();
                        $curriculum['next_lesson'] = !empty($next) ? $next : [];
                    }
                    break;
                }
                $i++;
            }
        }
        return $curriculum;
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (lesson_name, lesson_type, lesson_order, section_id) VALUES('$lesson_name', '$lesson_type', $lesson_order, $section_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        if (!isset($user_id)) {
            $user_id = "NULL";
        }

        $sql = "UPDATE {$this->table} SET lesson_name = '$lesson_name', lesson_type = '$lesson_type', lesson_order = $lesson_order, user_id = ${user_id} WHERE {$this->id_column} = $id AND {$this->id_section_column} = $section_id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id, $section_id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id AND {$this->id_section_column} = $section_id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

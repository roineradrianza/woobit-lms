<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class QuestionAttempt extends DB
{
    private $table = "question_attempts";
    private $table_lesson = "lessons";
    private $table_question = "questions";
    private $table_lesson_view = "lesson_views";
    private $table_attempt_anwers = "question_attempt_answers";
    private $id_column = "question_attempt_id";
    private $id_lesson_view_column = "lesson_view_id";
    private $id_lesson_column = "lesson_id";

    public function get(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_my_grades($course_id = 0, $user_id = 0)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }

        $sql = "SELECT lesson_id, lesson_name,
		(SELECT score FROM {$this->table_lesson_view} LV INNER JOIN {$this->table} QA
		 ON QA.lesson_view_id = LV.lesson_view_id WHERE LV.lesson_id = L.lesson_id  AND LV.user_id = $user_id ORDER BY QA.registered_at DESC LIMIT 1) score,
		 (SELECT approved FROM {$this->table_lesson_view} LV INNER JOIN {$this->table} QA
		 ON QA.lesson_view_id = LV.lesson_view_id WHERE LV.lesson_id = L.lesson_id  AND LV.user_id = $user_id ORDER BY QA.registered_at DESC LIMIT 1) approved
		FROM {$this->table_lesson} L INNER JOIN sections S ON S.section_id = L.section_id WHERE L.lesson_type = 2 AND S.course_id = $course_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_id(int $lesson_id = 0, $user_id = 0)
    {
        if (empty($lesson_id) || empty($user_id)) {
            return [];
        }

        $sql = "SELECT question_attempt_id, score, approved, time_taken, QA.registered_at FROM {$this->table} QA INNER JOIN {$this->table_lesson_view} LV ON LV.lesson_view_id = QA.lesson_view_id WHERE {$this->id_lesson_column} = $lesson_id AND QA.user_id = $user_id ORDER BY {$this->id_column} DESC LIMIT 1";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (score, approved, time_taken, lesson_view_id, user_id) VALUES($score, $approved, $time_taken, $lesson_view_id, $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function delete($id, $lesson_id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id AND {$this->id_lesson_column} = $lesson_id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

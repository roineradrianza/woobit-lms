<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Question extends DB
{
    private $table = "questions";
    private $table_question = "question";
    private $id_column = "question_id";
    private $id_lesson_column = "lesson_id";

    public function get(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT question_id, question_type, question_name, question_name as old_question_name, question_answers, correct_answer, score, lesson_id FROM {$this->table} WHERE {$this->id_lesson_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_type(int $id = 0, int $question_type = 1)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $id AND question_type = $question_type";
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

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_question_by_order($lesson_id = 0, $order = 0)
    {
        if ($lesson_id == 0 || $order == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $lesson_id AND question_order = $order";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [], $lesson_id = 0)
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $question_answers = is_array($question_answers) ? json_encode($question_answers, JSON_UNESCAPED_UNICODE) : $question_answers;
        $sql = "INSERT INTO {$this->table} (question_name, question_type, question_answers, correct_answer, lesson_id) VALUES('$question_name', '$question_type', '$question_answers', '$correct_answer', $lesson_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $question_answers = is_array($question_answers) ? json_encode($question_answers, JSON_UNESCAPED_UNICODE) : $question_answers;
        $sql = "UPDATE {$this->table} SET question_name = '$question_name', question_type = '$question_type', question_answers = '$question_answers', score = $score, correct_answer = '$correct_answer' WHERE {$this->id_column} = $id AND {$this->id_lesson_column} = $lesson_id";
        $result = $this->execute_query($sql);
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

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class QuestionAttemptAnswer extends DB
{
    private $table = "question_attempt_answers";
    private $table_question = "questions";
    private $table_question_attempt = "question_attempts";
    private $id_column = "question_attempt_answer_id";
    private $id_question_column = "question_id";
    private $id_question_attempt_column = "question_attempt_id";
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

    public function get_by_id($question_id = 0, $attempt_id = 0)
    {
        if (empty($question_id) || empty($attempt_id)) {
            return [];
        }

        $sql = "SELECT answer as correct_answer, answer_correct, question_id FROM {$this->table} QAA WHERE {$this->id_question_column} = $question_id AND {$this->id_question_attempt_column} = $attempt_id";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $answer = is_array($correct_answer) ? json_encode($correct_answer, JSON_UNESCAPED_UNICODE) : $correct_answer;
        $sql = "INSERT INTO {$this->table} (answer, answer_correct, question_id, question_attempt_id) VALUES('$answer', '$answer_correct', $question_id, $question_attempt_id)";
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

    public function check_answers($question, $answer)
    {
        if (!is_array($question['correct_answer']) && intval($question['question_type']) != 3) {
            $result = $question;
            if (!isset($answer['answer_correct'])) {
                if ($question['correct_answer'] != $answer['correct_answer']) {
                    $result['score'] = 0;
                    $result['answer_correct'] = 0;
                    $result['question_correct_answer'] = $question['correct_answer'];
                    $result['correct_answer'] = $answer['correct_answer'];
                } else {
                    $result['answer_correct'] = 1;
                }
            } else {
                $result['question_correct_answer'] = $question['correct_answer'];
                $result['correct_answer'] = $answer['correct_answer'];
                $result['answer_correct'] = $answer['answer_correct'];
            }
        } else {
            $result = $question;
            if (!isset($answer['answer_correct'])) {
                $question_answers = $question['question_answers'][0];
                $question['correct_answer'] = [];
                $total_words = count($question_answers->missing_words);
                $total_correct = 0;
                $score = $question['score'] / $total_words;
                $score_total = 0;
                $result['score'] = 0;
                foreach ($question_answers->missing_words as $key => $missing_word) {
                    $item = ['correct' => $missing_word, 'answered' => empty($answer['correct_answer'][$key]) ? '' : $answer['correct_answer'][$key]];
                    $item['score'] = strtolower(Helper::remove_accents($item['correct'])) == strtolower(Helper::remove_accents($item['answered'])) ? $score : 0;
                    $total_correct = strtolower(Helper::remove_accents($item['correct'])) == strtolower(Helper::remove_accents($item['answered'])) ? $total_correct + 1 : $total_correct;
                    $result['score'] = $result['score'] + $item['score'];
                    $question['correct_answer'][0]['correct_answers'][] = $item;
                }
                $result['score'] = round($result['score']);
                $result['question_correct_answer'] = $question['correct_answer'];
                $result['correct_answer'] = $answer['correct_answer'];
                if ($total_correct == $total_words) {
                    $result['answer_correct'] = 1;
                } else {
                    $result['answer_correct'] = 0;
                }
            } else {
                $result['question_correct_answer'] = $question['correct_answer'];
                $result['correct_answer'] = $answer['correct_answer'];
                $result['answer_correct'] = $answer['answer_correct'];
            }
        }
        return $result;
    }

}

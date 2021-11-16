<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class LessonComments extends DB
{
    private $table = "lesson_comments";
    private $id_column = "lesson_comment_id";
    private $id_user_column = "user_id";
    private $id_lesson_column = "lesson_id";

    public function get(int $id = 0, $comment_type = 'contributions')
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $id AND comment_type = '$contributions'";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_lesson_comments(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT lesson_comment_id, comment, comment_type, LC.user_id, published_at, avatar, first_name, last_name, username FROM {$this->table} LC INNER JOIN users U ON U.user_id = LC.user_id WHERE {$this->id_lesson_column} = $id";
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
        $sql = "INSERT INTO {$this->table} (comment, comment_type, lesson_id, user_id) VALUES('$comment', '$comment_type', $lesson_id, $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET comment = '$comment' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

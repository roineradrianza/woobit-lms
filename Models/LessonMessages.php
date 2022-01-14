<?php
namespace Model;

use Model\Helper\DB;

/**
 * LessonMessages Model
 */

class LessonMessages extends DB
{
    private $table = "lesson_messages";
    private $id_column = "lesson_message_id";
    private $id_user_column = "user_id";
    private $id_lesson_column = "lesson_id";

    public function get($lesson_id = 0, $id = 0) : Array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $lesson_id";
        if (!empty($id)) {
            $sql .= " AND {$this->id_column} = $id";
        }
        $sql .= " ORDER BY created_at DESC";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }
 
    public function create($data = []) : Mixed
    {
        if (empty($data)) {
            return false;
        }
        extract($data);
        $sql = "INSERT INTO {$this->table} (message, lesson_id, user_id) VALUES('$message', $lesson_id, $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function update($id, $data = []) : Bool
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET message = '$message' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id) : Bool
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class LessonMeta extends DB
{
    private $table = "lessons_meta";
    private $id_column = "lessons_meta_id";
    private $lesson_column = "lesson_id";

    public function get(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT lesson_meta_name, lesson_meta_val FROM {$this->table} WHERE {$this->lesson_column} = $id";
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
        $sql = "INSERT INTO {$this->table} (lesson_meta_name, lesson_meta_val, lesson_id) VALUES('$lesson_meta_name', '$lesson_meta_val', $lesson_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function get_meta(int $lesson_id = 0, $meta_name = '')
    {
        if (empty($meta_name) || $lesson_id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->lesson_column} = $lesson_id AND lesson_meta_name = '$meta_name'";
        $result = $this->execute_query($sql);
        if (empty($result)) {
            return [];
        }
        return $result->fetch_assoc();
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET lesson_meta_val = '$lesson_meta_val' WHERE {$this->lesson_column} = $id AND lesson_meta_name = '$lesson_meta_name'";
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

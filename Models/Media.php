<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Media extends DB
{
    private $table = "media";
    private $id_column = "media_id";
    private $id_course_column = "course_id";
    private $id_lesson_column = "lesson_id";

    public function get($id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
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

    public function get_by_lesson($id = 0, $resource_type = '')
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $id";
        if (!empty($resource_type)) {
            $sql .= " AND resource_type = '$resource_type'";
        }

        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_courses($id, $columns)
    {
        $sql = "SELECT $columns FROM {$this->table} WHERE {$this->id_column} = $id AND course_id NOT NULL";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function update($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $media_id = empty($data['media_id']) ? null : $media_id;
        $sql = "SELECT media_id FROM {$this->table} WHERE url = '$url'";
        if (!empty($media_id)) {
            $sql .= " OR media_id = $media_id";
        }

        $result = $this->execute_query($sql);
        $arr = [];
        $preview_only = empty($preview_only) ? 0 : $preview_only;
        $resource_type = empty($resource_type) ? 'material' : $resource_type;
        $resource_name = empty($resource_name) ? '' : $resource_name;
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        if (!empty($arr[0])) {
            $sql = "UPDATE {$this->table} SET name= '$resource_name', url = '$url', preview_only= $preview_only WHERE media_id = " . $media_id;
            $result = $this->execute_query($sql);
        } else {
            $sql = "INSERT INTO {$this->table} (url, name, resource_type, course_id, preview_only, lesson_id, user_id)
			VALUES('$url', '$resource_name', '$resource_type', $course_id, $preview_only, $lesson_id, $user_id)";
            $result = $this->execute_query_return_id($sql);
        }
        return $result;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
        $result = $this->execute_query($sql);
        return $result;
    }

}

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class CourseCertified extends DB
{
    private $table = "course_certifieds";
    private $id_column = "course_certified_id";
    private $id_course_column = "course_id";
    private $id_user_column = "user_id";

    public function get($id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $id";
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

    public function get_by_course($course_id = 0, $user_id = 0)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }
        $sql = "SELECT * FROM {$this->table}
		WHERE {$this->id_course_column} = $course_id AND {$this->id_user_column} = $user_id
        ORDER by {$this->id_column} DESC";
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
        $sql = "INSERT INTO {$this->table} (certified_url, course_id, user_id) VALUES('$certified_url', $course_id, $user_id)";
        $result = $this->execute_query_return_id($sql);
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

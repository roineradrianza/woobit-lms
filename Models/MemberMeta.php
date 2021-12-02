<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class MemberMeta extends DB
{
    private $table = "user_meta";
    private $id_column = "user_meta_id";
    private $user_column = "user_id";

    public function get(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->user_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_meta(int $user_id = 0, $meta_name = '')
    {
        if (empty($meta_name) || $user_id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->user_column} = $user_id AND meta_name = '$meta_name'";
        $result = $this->execute_query($sql);
        if (empty($result)) {
            return [];
        }
        return $result->fetch_assoc();
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (meta_name, meta_val, user_id) VALUES('$meta_name', '$meta_val', $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET meta_val = '$meta_val' WHERE {$this->user_column} = $id AND meta_name = '$meta_name'";
        $result = $this->execute_query($sql);
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

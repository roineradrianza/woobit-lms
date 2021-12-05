<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Application extends DB
{
    private $table = "applications";
    private $id_column = "application_id";
    private $user_column = "user_id";

    public function get($id = 0) : Array
    {
        $sql = "SELECT * FROM {$this->table}";
        $sql .= empty($id) ? '' : " WHERE {$this->user_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = []): Bool
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (status, user_id) VALUES($status, $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function update($id, $data = []) : Bool
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET status = $status 
        WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id) : Bool
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
        $result = $this->execute_query($sql);
        return $result;
    }

}

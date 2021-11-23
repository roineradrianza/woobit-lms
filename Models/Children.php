<?php
namespace Model;

use Model\Helper\DB;

/**
 * Children Model
 */

class Children extends DB
{
    private $table = "children";
    private $id_column = "children_id";
    private $id_user_column = "user_id";

    public function get($id = 0, $user_id = 0) : Array
    {
        $sql = "SELECT * FROM {$this->table}";
        if (empty($id != 0)) {
            $sql .= " WHERE {$this->id_column} = $id";
        } else if (!empty($user_id)) {
            $sql .= " WHERE {$this->id_user_column} = $user_id";
        }
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
        $sql = "INSERT INTO {$this->table} 
        (first_name, last_name, gender, birthdate, user_id) 
        VALUES('$first_name', '$last_name', '$gender', '$birthdate', $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function update($id, $user_id, $data = []) : Bool
    {
        if (empty($data) || empty($id) || empty($user_id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET first_name = '$first_name', 
        last_name = '$last_name', gender = '$gender', birthdate = '$birthdate' 
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

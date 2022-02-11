<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Setting extends DB
{
    private $table = "settings";
    private $name_column = "name";
    private $id_column = "setting_id";

    public function get($name = '')
    {
        $sql = "SELECT * FROM {$this->table}";
        $sql .= !empty($name) ? " WHERE {$this->name_column} = '$name'" : '';
        
        $result = $this->execute_query($sql);
        if (!empty($name)) {
            return $result->fetch_assoc();
        } else {
            $arr = [];
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
            return $arr;
        }
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (name, value) VALUES('$name', '$val')";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET value = '$val' WHERE {$this->name_column} = '$name'";
        $result = $this->execute_query($sql);
        return $result;
    }

}

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Payment extends DB
{

    private $table = "payment_methods";
    private $id_column = "payment_method_id";

    public function get(int $id = 0)
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

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET name = '$name' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

}

<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class OrderChild extends DB
{
    private $table = "order_childs";
    private $table_meta = "orders_meta";
    private $id_column = "order_child_id";
    private $id_child_column = "child_id";
    private $id_course_user_column = "course_user_id";
    private $id_order_column = "order_id";

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

    public function get_by_order($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_order_column} = $id";
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
        $sql = "INSERT INTO {$this->table} (child_id, course_user_id, order_id) 
        VALUES($children_id, $course_user_id, $order_id)";
        $result = $this->execute_query_return_id($sql);
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

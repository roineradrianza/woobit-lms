<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Orders extends DB
{
    private $table = "orders";
    private $table_meta = "orders_meta";
    private $id_column = "order_id";
    private $id_user_column = "user_id";

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

    public function get_my_orders($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_user_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_course_orders($user_id = 0, $course_id = 0, $order_type = 2, $status = '')
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE
		course_id = $course_id";
        if (!empty($user_id)) {
            $sql .= " AND {$this->id_user_column} = $user_id";
        }
        if (!empty($order_type)) {
            $sql .= " AND type = $order_type";
        }
        if (!empty($status)) {
            $sql .= " AND status = $status";
        }
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
        $discount = empty($discount) ? 0 : $discount;
        $sql = "INSERT INTO {$this->table} (type, total_pay, discount, status, course_id, user_id, payment_method) VALUES($type, $total_pay, $discount, $status, $course_id, $user_id, '$payment_method')";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $discount = empty($discount) ? 0 : $discount;
        $sql = "UPDATE {$this->table} SET type = $type , total_pay = $total_pay, discount = $discount, status = $status, course_id = $course_id, user_id = $user_id, payment_method = '$payment_method' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function edit_note($id, $data)
    {
        if (empty($data) || empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET note = '$note' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function change_status($id, $status = 0)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET status = $status WHERE {$this->id_column} = $id";
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

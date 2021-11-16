<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Coupon extends DB
{
    private $table = "course_coupons";
    private $id_column = "coupon_id";
    private $id_course_column = "course_id";

    public function get(int $id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id ";
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

    public function get_by_name($course_id = 0, $coupon_name = '')
    {
        if (empty($coupon_name) || empty($course_id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE coupon_name = '$coupon_name' AND {$this->id_course_column} = $course_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_course(int $id = 0)
    {
        if ($id == 0) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $id ";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [], $columns = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (coupon_name, student_rol, discount, course_id) VALUES('$coupon_name', '$student_rol', $discount, $course_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET coupon_name = '$coupon_name', student_rol = '$student_rol', discount = $discount, course_id = $course_id WHERE {$this->id_column} = $id";
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

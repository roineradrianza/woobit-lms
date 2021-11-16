<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class StudentCoupon extends DB
{
    private $table = "student_coupons";
    private $table_coupon = "course_coupons";
    private $id_column = "student_coupon_id";
    private $id_coupon_column = "coupon_id";
    private $id_course_column = "course_id";

    public function get(int $id = 0, $coupon_code = '')
    {
        if ($id != 0 || !empty($coupon_code)) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id ";
            if (!empty($coupon_code)) {
                $sql .= " OR coupon_code = '$coupon_code'";
            }

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

    public function get_enabled_coupons($user_id = 0, $course_id = 0)
    {
        $sql = "SELECT SC.coupon_code, CC.discount FROM {$this->table} SC INNER JOIN {$this->table_coupon} CC ON CC.coupon_id = SC.coupon_id WHERE SC.user_id = $user_id AND CC.course_id= $course_id AND CC.discount = 100 AND SC.already_used = 0 ORDER BY SC.user_id DESC LIMIT 1";
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
        $sql = "INSERT INTO {$this->table} (coupon_id, coupon_code, user_id) VALUES($coupon_id, '$coupon_code', $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function disable_coupon($coupon_code = '')
    {
        if (empty($coupon_code)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET already_used = 1 WHERE coupon_code = '$coupon_code'";
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

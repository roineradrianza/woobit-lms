<?php
namespace Model;

use Model\Category;
use Model\Helper\DB;

/**
 *
 */

class Course extends DB
{
    private $table = "courses";
    private $table_student_courses = "course_users";
    private $table_meta = "course_meta";
    private $course_category = "course_category";
    private $id_column = "course_id";
    private $id_user_column = "user_id";

    public function get($id = 0)
    {
        $sql = "SELECT C.course_id, active, duration, price, featured_image,
            certified_template, published_at, slug, title, category_id, C.user_id, platform_owner
            FROM {$this->table} C LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id";
        $sql .= !empty($id) ? " WHERE C.{$this->id_column} = $id" : '';
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_user($id = 0, $rows = 4, $course_id = 0)
    {
        if (empty($id)) {
            return [];
        }
        $sql = "SELECT C.course_id, active, duration, price, featured_image, certified_template,
         published_at, slug, title, category_id, user_id, platform_owner, min_students, max_students, min_age, max_age
            FROM {$this->table} C LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id
            WHERE C.{$this->id_user_column} = $id AND active = 1";
        $sql .= !empty($course_id) ? " AND C.course_id != $course_id" : '';
        $result = $this->execute_query($sql);
        $arr = [];
        $category = new Category;
        while ($row = $result->fetch_assoc()) {
            $row['category'] = !empty($row['category_id']) ? $category->get($row['category_id'])[0]['name'] : [];
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_lesson_id($lesson_id = 0)
    {
        if (empty($lesson_id)) {
            return [];
        }

        $sql = "SELECT C.course_id, active, duration, price, featured_image, C.published_at,
        slug, title, C.user_id, platform_owner, certified_template, min_students, max_students, min_age, max_age
        (SELECT course_meta_val FROM {$this->table_meta}
		WHERE course_id = C.course_id AND course_meta_name = 'paid_certified' LIMIT 1) paid_certified
        FROM lessons L INNER JOIN sections S ON S.section_id = L.section_id
        INNER JOIN {$this->table} C ON C.course_id = S.course_id WHERE L.lesson_id = $lesson_id LIMIT 1";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function get_by_slug($slug = '')
    {
        if (empty($slug)) {
            return [];
        }

        $sql = "SELECT C.course_id, active, duration, price, featured_image,
        published_at, slug, title, category_id, subcategory_id, user_id, platform_owner, min_students, max_students, min_age, max_age
        FROM {$this->table} C LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id WHERE slug = '$slug' LIMIT 1";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_courses($id = 0, $columns = [])
    {
        $columns = empty($columns) ? implode(',', $columns) : '*';
        if ($id == 0) {
            $sql = "SELECT $columns FROM {$this->table}";
        } else {
            $sql = "SELECT $columns FROM {$this->table} WHERE {$this->id_column} = $id";
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_my_courses($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT C.course_id, title, featured_image, slug, min_students, max_students, min_age, max_age
        FROM {$this->table_student_courses} SC INNER JOIN {$this->table} C
        ON C.course_id = SC.course_id WHERE SC.{$this->id_user_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_own_courses($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT C.course_id, title, featured_image, slug, duration, sale_price, price,
        min_students, max_students, min_age, max_age, CCS.name category
        FROM {$this->table} C LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id
		LEFT JOIN course_categories CCS ON CCS.category_id = CC.category_id
         WHERE {$this->id_user_column} = $id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_recent_courses()
    {
        $current_date = date('Y-m-d');
        $last_month = date('Y-m-d', strtotime($current_date . "- 1 month"));
        $current_date .= ' 00:00:00';
        $last_month .= ' 23:59:59';
        $sql = "SELECT title, featured_image, slug, price, min_students, max_students, min_age, max_age FROM
        {$this->table} WHERE published_at BETWEEN '$last_month' AND '$current_date' AND active = 1";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_enabled($rows = 100000)
    {
        $sql = "SELECT title, featured_image, slug, price, avatar, CONCAT(first_name, ' ', last_name) full_name,
		CCS.name category, platform_owner, min_students, max_students, min_age, max_age, (SELECT course_meta_val FROM {$this->table_meta}
		WHERE course_id = C.course_id AND course_meta_name = 'description' LIMIT 1) description, (SELECT course_meta_val FROM {$this->table_meta}
		WHERE course_id = C.course_id AND course_meta_name = 'certified_by' LIMIT 1) certified_by, (SELECT COUNT(user_id)
		FROM {$this->table_student_courses} WHERE course_id = C.course_id
		AND user_rol NOT IN ('profesor', 'oyente') ) total_enrolled FROM {$this->table} C INNER JOIN
		users U ON U.user_id = C.user_id LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id
		INNER JOIN course_categories CCS ON CCS.category_id = CC.category_id WHERE active = 1 ORDER BY published_at DESC LIMIT $rows";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_total_students($course_id)
    {
        $sql = "SELECT COUNT(user_id) as total FROM
        {$this->table_student_courses} WHERE course_id = $course_id AND user_rol NOT IN ('profesor', 'oyente')";
        $result = $this->execute_query($sql);
        return $result->fetch_assoc();
    }

    public function search($search)
    {
        $sql = "SELECT title, featured_image, slug, price, avatar, CONCAT(first_name, ' ', last_name) full_name, CCS.name category, platform_owner, (SELECT course_meta_val FROM {$this->table_meta} WHERE course_id = C.course_id LIMIT 1) description, (SELECT COUNT(user_id) FROM {$this->table_student_courses} WHERE course_id = C.course_id AND user_rol NOT IN ('profesor', 'oyente') ) total_enrolled FROM {$this->table} C INNER JOIN users U ON U.user_id = C.user_id LEFT JOIN {$this->course_category} CC ON CC.course_id = C.course_id INNER JOIN course_categories CCS ON CCS.category_id = CC.category_id WHERE title LIKE '%$search%' AND active = 1 ORDER BY published_at DESC";
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

        $columns = implode(',', $columns);
        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['platform_owner'])) {
            $data['platform_owner'] = 0;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (
            featured_image, title, slug,
        duration, price, user_id, active, min_students,
        max_students, min_age, max_age) VALUES(
            '$featured_image', '$title', '$slug', '$duration',
            $price, $user_id, $active, $min_students, $max_students, $min_age, $max_age
        )";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET featured_image = '$featured_image', title = '$title', slug = '$slug',
        duration = '$duration', price = $price, user_id = $user_id, active = $active, min_students = $min_students,
        max_students = $max_students, min_age = $min_age, max_age = $max_age
        WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function edit_cover($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET featured_image = '$featured_image' WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function user_has_access($course_id = 0, $user = [])
    {
        if ($course_id == 0 or empty($user)) {
            return false;
        }

        $user_id = $user['user_id'];
        $hasAccess = false;
        switch ($user['user_type']) {
            case 'administrador':
                $hasAccess = true;
                break;

            default:
                $sql = "SELECT user_id FROM {$this->table} WHERE {$this->id_column} = $course_id AND {$this->id_user_column} = $user_id LIMIT 1";
                $query = $this->execute_query($sql);
                if (!empty($query->fetch_object())) {
                    $hasAccess = true;
                } else {
                    $sql = "SELECT user_id FROM {$this->table_student_courses} WHERE {$this->id_column} = $course_id AND {$this->id_user_column} = $user_id AND user_rol = 'profesor' LIMIT 1";
                    $query = $this->execute_query($sql);
                    if (!empty($query->fetch_object())) {
                        $hasAccess = true;
                    }
                }
                break;
        }
        return $hasAccess;
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

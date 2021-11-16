<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class CourseCategory extends DB
{
    private $table = "course_category";
    private $id_column = "course_id";

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

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        $data['subcategory_id'] = empty($data['subcategory_id']) ? 'NULL' : intval($data['subcategory_id']);
        extract($data);
        $sql = "INSERT INTO {$this->table} (category_id, subcategory_id, course_id) VALUES($category_id, $subcategory_id, $course_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        $data['subcategory_id'] = empty($data['subcategory_id']) ? 'NULL' : intval($data['subcategory_id']);
        extract($data);
        $sql = "UPDATE {$this->table} SET category_id = $category_id, subcategory_id = $subcategory_id WHERE {$this->id_column} = $id";
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

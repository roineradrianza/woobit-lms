<?php
namespace Model;

use Model\Helper\DB;

/**
 * Lesson Material Sent Model
 */

class LessonMaterialSent extends DB
{
    private $table = "lesson_materials_sent";
    private $id_column = "material_id";
    private $id_child_column = "children_id";
    private $id_lesson_column = "lesson_id";

    public function get($lesson_id, $child_id = 0)
    {
        if (empty($lesson_id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_lesson_column} = $lesson_id";
        $sql .= !empty($child_id) ? " AND {$this->id_child_column} = $child_id" : "";

        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function update($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $material_id = empty($data['material_id']) ? null : $material_id;
        $sql = "SELECT material_id FROM {$this->table} WHERE url = '$url'";
        if (!empty($material_id)) {
            $sql .= " OR material_id = $material_id";
        }

        $result = $this->execute_query($sql);
        $arr = [];
        $resource_name = empty($resource_name) ? '' : $resource_name;
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        if (!empty($arr[0])) {
            $sql = "UPDATE {$this->table} SET name= '$resource_name', url = '$url' WHERE material_id = $material_id";
            $result = $this->execute_query($sql);
        } else {
            $sql = "INSERT INTO {$this->table} (url, name, sender, lesson_id, children_id)
			VALUES('$url', '$resource_name', $sender, $lesson_id, $children_id)";
            $result = $this->execute_query_return_id($sql);
        }
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

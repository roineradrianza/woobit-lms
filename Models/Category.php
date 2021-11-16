<?php 
namespace Model;

use Model\Helper\DB;
/**
 * 
 */

class Category extends DB
{
	private $table = "course_categories";
	private $table_courses = "courses";
	private $table_course_category = "course_category";
	private $id_column = "category_id";

	public function get(int $id = 0) 
	{
		if ($id != 0) {
			$sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
		}
		else{
			$sql = "SELECT * FROM {$this->table}";
		}
		$result = $this->execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}	

	public function get_courses() 
	{
		$sql = "SELECT name, (SELECT COUNT(course_id) FROM {$this->table_course_category} WHERE category_id = C.category_id) courses FROM {$this->table} C";
		$result = $this->execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function create($data = [], $columns = []) 
	{
		if (empty($data)) return false;
		$columns = implode(',',$columns);
		extract($data);
		$sql = "INSERT INTO {$this->table} ($columns) VALUES('$name')";
		$result = $this->execute_query_return_id($sql);
		return $result;
	}

	public function edit($id, $data = []) 
	{
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET name = '$name' WHERE {$this->id_column} = $id";
		$result = $this->execute_query($sql);
		return $result;
	}

	public function delete($id) 
	{
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id";
		$result = $this->execute_query($sql);
		return $result;
	}

}
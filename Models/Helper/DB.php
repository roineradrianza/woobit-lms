<?php 
namespace Model\Helper;

class DB 
{
	public $db;

	public function __construct() {
		$this->db =	new \mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			printf("Falló la conexión a la base de datos, verifique que las credenciales de acceso sean las correctas y/o que el servidor de la base de datos se encuentre activo, el error generador se muestra a continuación: %s\n",mysqli_connect_error());
			exit();
		}
	}

	function execute_query($sql) : Mixed
	{
		$query = $this->db->query($sql);
		return $query;
	}

	function execute_query_return_row($sql) : Array
	{
		$query = $this->db->query($sql);		
		$row = $query->fetch_assoc();
		return $row;
	}

	function execute_query_return_id($sql) : Int
	{
		$query = $this->db->query($sql);		
		return $this->db->insert_id;			
	}

}

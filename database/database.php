<?php 

// database connection in class

class Database
{
	private $conn;

	public function connect(){
		include_once("constants.php");
		$this->conn = new mysqli(HOST,USER,PASS,DB);

		if ($this->conn){
			//echo "connected";
			return $this->conn;
		}

		return "DATABASE_CONNECTION_FAIL";
	}
}

// $db = new Database();
// $db->connect();














?>
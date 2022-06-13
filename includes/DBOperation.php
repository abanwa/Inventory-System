

<?php 



/**
 * 
 */
class DBOperation 
{
	
	private $conn;

	function __construct()
	{
		include_once("../database/database.php");
		$database = new Database();
		$this->conn = $database->connect();
	}

	// (PARENT_CAT is our unique key)
	public function addCategory($parent, $cat){
		$pre_stmt = $this->conn->prepare("INSERT INTO `categories`(`parent_cat`, `category_name`, `status`) VALUES (?, ?, ?)");
		$status = 1; // status is 1 because we are inserting
		$pre_stmt->bind_param("isi", $parent, $cat, $status);
		// isi means integar,string,integar.parent_cat,category_name,status = INTEGAR,STRING,INTEGAR
		$result = $pre_stmt->execute() or die($this->conn->error);

		if ($result){
			 return "CATEGORY_ADDED";
		} else {
			return 0;
		}


	}




	// (Brand_Name is our unique key)
	public function addBrand($brand_name){
		$pre_stmt = $this->conn->prepare("INSERT INTO `brands`(`brand_name`, `status`) VALUES (?, ?)");
		$status = 1; // status is 1 because we are inserting
		$pre_stmt->bind_param("si", $brand_name, $status);
		// isi means integar,string,integar.parent_cat,category_name,status = INTEGAR,STRING,INTEGAR
		$result = $pre_stmt->execute() or die($this->conn->error);

		if ($result){
			 return "BRAND_ADDED";
		} else {
			return 0;
		}


	}




	// (product_name is our unique key, cid,bid are forigen keys referencing their tables respectively. pid is the primary key)
	public function addProduct($cid,$bid,$pro_name,$price,$stock,$date){
		$pre_stmt = $this->conn->prepare("INSERT INTO `products`(`cid`, `bid`, `product_name`,
		 `product_price`,`product_stock`, `added_date`, `p_status`)
		  VALUES (?, ?, ?, ?, ?, ?, ?)");

		$status = 1; // status is 1 because we are inserting
		$pre_stmt->bind_param("iisdisi", $cid, $bid, $pro_name, $price, $stock, $date, $status); // check the table to know which is INT,STR or DOUBLE
		// isi means integar,string,integar.parent_cat,category_name,status = INTEGAR,STRING,INTEGAR
		$result = $pre_stmt->execute() or die($this->conn->error);

		if ($result){
			 return "NEW_PRODUCT_ADDED";
		} else {
			return 0;
		}


	}






	public function getAllRecord($table){
		$pre_stmt = $this->conn->prepare("SELECT * FROM ".$table);
		$pre_stmt->execute() or die($this->conn->error);
		$result = $pre_stmt->get_result();
		$row = array();

		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}
		return "NO_DATA";
	}



} //end of class DBOperation





 //$opr = new DBOperation();
 //echo $opr->addCategory(1,"dvd");
//echo "<pre>";
//print_r($opr->getAllRecord("categories"));


?>




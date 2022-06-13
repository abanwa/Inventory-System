<?php


/**
 * 
 */
class Manage 
{
	

	private $conn;

	function __construct()
	{
			include_once("../database/database.php");
			$database = new Database();
			$this->conn = $database->connect();
	}



	public function manageRecordWithPagination($table,$pno){
		$a = $this->pagination($this->conn,$table,$pno,5); // we called our pagination function here. i want 5 records
		if ($table == "categories"){
			
			// join the category table with their unique keys or ids
			$sql = "SELECT p.category_name as category,c.category_name as parent,p.cid,p.status FROM categories p LEFT JOIN categories c ON p.parent_cat=c.cid ".$a["limit"]; // we set our limits to 5 or check from down how we did it
		} else if ($table == "brands"){
			// this is for tables for brands and others except for categories and product
			$sql = "SELECT * FROM ".$table." ".$a["limit"];
		} else {
			// this is for tables for product.it's concantenation of the three tables. categories,brands and products table 
			$sql = "SELECT p.pid,p.product_name,c.category_name,b.brand_name,p.product_price,p.product_stock,p.added_date,p.p_status FROM products p,brands b,categories c WHERE p.bid = b.bid AND p.cid = c.cid ".$a["limit"];
		}

		//$result = $this->conn->query($sql) or die($this->conn->error);
		$result = mysqli_query($this->conn, $sql);
		if ($result === FALSE) {
		  die(mysqli_error($this->conn));
		}
		$rows = array();
		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
		}
		return ["rows"=>$rows,"pagination"=>$a["pagination"]];

	}



			// pagination function
	private function pagination($conn,$table,$pno,$n){
		//$totalRecords = 100000; i want to get the records from database. $row and $totalRecords is the same.
		$sql = ("SELECT count(*) as row FROM ".$table);//row was rows b4 i changed it

		$result = mysqli_query($conn, $sql);
		if ($result === FALSE) {
		  die(mysqli_error($conn));
		}

		$row = mysqli_fetch_assoc($result);

		$pageno = $pno;
		$numberOfRecordsPerPage = $n;

		// $row["row"] the ("row") was "rows" before i changed it
		$lastPage = ceil($row["row"]/$numberOfRecordsPerPage); // round up to higher value. this'll give us no of pages

		//echo "Total Pages ".$lastPage."</br>";

		$pagination = "<ul class='pagination'>"; // for all pagination, treat it like bootstrap pagination

		if ($lastPage != 1){
			if ($pageno > 1){
				$previous = "";
				$previous = $pageno - 1; 
				// we use pn to target their pagenos (page numbers)
				$pagination .= "<li class='page-item'><a class='page-link' pn='" .$previous. "' href='#' style='color:#333;'> Previous </a></li>";
			}
			// for the first if. i want it to start from 5pages before the current page
			for ($i = $pageno - 5; $i < $pageno; $i++){
				if ($i > 0){
					//list of pages	before current page		
					$pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'> ".$i." </a></li>";
				}
			
			}

//current page. i also removed "pagination.php?pageno=" from "<a href='the link here"..."because i want to use jquery or ajax
			$pagination .= "<li class='page-item'><a class='page-link' pn='".$pageno."' href='#' style='color:#333;'> $pageno </a></li>";

			for ($i = $pageno + 1; $i <= $lastPage; $i++){
				// list of pages after the current page
				$pagination .= "<li class='page-item'><a class='page-link' pn='" .$i. "' href='#'> ".$i." </a></li>";
				if ($i > $pageno + 4){
					break;
				}
			}

			if ($lastPage > $pageno){
				$next = $pageno + 1;
				$pagination .= "<li class='page-item'><a class='page-link' pn='".$next."' href='#' style='color:#333;'> Next </a></li></ul>"; // close the pagination ul tag here
			}
		}
		//num of records to display on each pages
		// LIMIT 0,10
		// LIMIT 20,10
		$limit = "LIMIT ".($pageno - 1) * $numberOfRecordsPerPage.",".$numberOfRecordsPerPage;

		return ["pagination"=>$pagination,"limit"=>$limit];

	} // pagination function ends Here



	// to delete records from the database for the manage AND $pk is the primary key. it can be cid, bid ,etc
	public function deleteRecord($table,$pk,$id){
		if ($table == "categories"){
			$pre_stmt = $this->conn->prepare("SELECT ".$id." FROM categories WHERE parent_cat = ?");
			$pre_stmt->bind_param("i",$id);
			$pre_stmt->execute();
			$result = $pre_stmt->get_result() or die($this->conn->error);

			if ($result->num_rows > 0){
		// if it is the parent category which has 0,0,0 parent_cat ids, it will return DEPENDENT CATEGORY. others can be deleted
				return "DEPENDENT_CATEGORY";
			} else{
		//if it's not the parent category, it will be deleted
				$pre_stmt = $this->conn->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->conn->error);

				if ($result){
					return "CATEGORY_DELETED";
				}
			}

		} else {
		//if it's not the categories table, the record will be deleted
			$pre_stmt = $this->conn->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
			$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->conn->error);

				if ($result){
					return "DELETED";
				} 
		}  //end of the if ($table == "categories")

	} // End of deleteRecord




// we can delete from every other table exept the parent_categories from categories table




			// To Get A SIngle Row TO Update or Edit

	public function getSingleRecord($table,$pk,$id){
		$pre_stmt = $this->conn->prepare("SELECT * FROM ".$table." WHERE ".$pk." = ?");
		$pre_stmt->bind_param("i",$id);
		$pre_stmt->execute() or die($this->conn->error);
		$result = $pre_stmt->get_result();

		if ($result->num_rows == 1){
			$row = $result->fetch_assoc();
		}
		return $row;
	}




		// This code is used to perform CRUD (create,selete,update and delete) from sql
	//$where is an array (["cid"=>1])
	//$field is an array(["parent_cat"=>0,"category_name"=>"Electro","status"=>1])


	public function update_record($table,$where,$fields){
		$sql = "";
		$condition = "";
		foreach($where as $key => $value){
			// id = '5' AND m_name = 'something'
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		foreach ($fields as $key => $value){
			//UPDATE table SET m_name = '' , qty = '' WHERE id = '';
			$sql .=$key . "='".$value."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;

		if (mysqli_query($this->conn,$sql)){
			return "UPDATED";
		}

	} //End of update_record function




						// FOR THE INVOICE TABLE FROM new_order.php FORM


			public function storeCustomerOrderInvoice($orderdate,$cust_name,$ar_total_qty,$ar_qty,$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type){

				// we use the getSingleRecord code above
				$pre_stmt = $this->conn->prepare("INSERT INTO `invoice`(`customer_name`, `order_date`, `sub_total`, `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`) VALUES (?,?,?,?,?,?,?,?,?)");
				$pre_stmt->bind_param("ssdddddds",$cust_name,$orderdate,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);
				$pre_stmt->execute() or die($this->conn->error);

				// i want to get the id of the last variable we inserted. which is Payment_type. from new_order.php form.
				$invoice_no = $pre_stmt->insert_id; // this statement is to get the last id of anything we inserted.

				// note: invoice_no here isb the last id of the form which is payment_type.
				if ($invoice_no != null){
					//we loop through the array because the invoice details was stored in an array. check process.php again
					for ($i = 0; $i < count($ar_price); $i++){

						// here we find the remaining ar_total_qty after the customer bought some ar_qty from the ar_total_qty
						$rem_qty = $ar_total_qty[$i] - $ar_qty[$i];

						if ($rem_qty < 0){
							return "ORDER_FAIL_TO_COMPLETE";
						} else {
							// update the product_stock (ar_total_qty) from the products table
							$sql = ("UPDATE products SET product_stock ='$rem_qty' WHERE product_name = '".$ar_pro_name[$i]."' ");
							mysqli_query($this->conn, $sql); // to query the sql...when connected
						}

						$insert_product = $this->conn->prepare("INSERT INTO `invoice_details`(`invoice_no`, `product_name`, `price`, `qty`) VALUES (?,?,?,?)");
						$insert_product->bind_param("isdd",$invoice_no,$ar_pro_name[$i],$ar_price[$i],$ar_qty[$i]);//the [$i] is because it's an array
						$insert_product->execute() or die($this->conn->error);
					}
					return $invoice_no;              //"ORDER_COMPLETED"; this'll help to identify the admon that sold the products and we check order.js because this will return only positive numbers
				}else{
					return "Something went wrong";
				}
			}











}


 //$obj = new Manage();
// echo "<pre>";
// print_r($obj->manageRecordWithPagination("categories",1));
 //echo $obj->deleteRecord("categories","cid",18);

 // the $pk (primary key) is cid and the cid number or (id) is 17

 //print_r($obj->getSingleRecord("categories","cid",1));

 //echo $obj->update_record("categories",["cid"=>1],["parent_cat"=>0,"category_name"=>"Electro","status"=>1]);
//echo $obj->update_record($table,$where,$fields) they stand for the table,where and fields

?>

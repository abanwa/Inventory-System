

<?php

// NOTE: the convention for post is | $_POST["the value of the name attribute you used"] | and not the id

include_once("../database/constants.php"); // contains data url

include_once("DBOperation.php");

include_once("user.php"); // contains the user class and connection too

include_once("manage.php"); // contains the manage class for categories and others


		// FOR REGISTRATION PROCESSING

if (isset($_POST["username"]) AND isset($_POST["email"])){
	//create instance of the class user
	$user = new User();
	$result = $user->createUserAccount($_POST["username"],$_POST["email"],$_POST["password1"],$_POST["usertype"]);
	echo $result;
	exit();
}


			// FOR LOGIN PROCESSING
	
if (isset($_POST["log_email"]) AND isset($_POST["log_password"])){
	//create instance of the class user
	$user = new User();
	$result = $user->userLogin($_POST["log_email"],$_POST["log_password"]);
	echo $result;
	exit();
}

			// TO getCategory AND PROCESS IT (it is called in main.js  ajax(data:))
if (isset($_POST["getCategory"])){
	//create instance of the class DBOperation
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("categories");

	foreach($rows as $row){
		echo "<option value='".$row["cid"]."'>".$row["category_name"]."</option>";
	}
	exit();
}



			// TO getBrand AND PROCESS IT (it is called in main.js  ajax(data:))  fetch Brand
if (isset($_POST["getBrand"])){
	//create instance of the class DBOperation
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("brands");

	foreach($rows as $row){
		echo "<option value='".$row["bid"]."'>".$row["brand_name"]."</option>";
	}
	exit();
}


			
			// ADD CATEGORY

if (isset($_POST["category_name"]) AND isset($_POST["parent_cat"])){
	// create instance of the class DBOperation
	$obj = new DBOperation();
	$result = $obj->addCategory($_POST["parent_cat"], $_POST["category_name"]);
	echo $result;
	exit();
}


			// ADD BRAND

if (isset($_POST["brand_name"])){
	// create instance of the class DBOperation
	$obj = new DBOperation();
	$result = $obj->addBrand($_POST["brand_name"]);
	echo $result;
	exit();
}



			// ADD PRODUCT

if (isset($_POST["added_date"]) AND isset($_POST["product_name"])){
	// create instance of the class DBOperation
	$obj = new DBOperation();
	$result = $obj->addProduct($_POST["select_cat"],$_POST["select_brand"],$_POST["product_name"],$_POST["product_price"],$_POST["product_qty"],$_POST["added_date"]); // these were gotten from products table except cid,bid
	echo $result;
	exit();
}




		// Manage Category for the manage_categories.php page . pass data from here to the manageCategory in main.js page
		// this manageCategory we are issetting is a function from the main.js for the manage_categories.php page
if (isset($_POST["manageCategory"])){
	// create instance of the class Manage
	$manage = new Manage();
	$result = $manage->manageRecordWithPagination("categories",$_POST["pageno"]); //if manageCategory is set, pass pageno
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	
// this is for rows
	if (count($rows) > 0){
		//we want the # column numbering should continue when we go to the next page instead of starting from 1 again
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row){ ?>

		<tr>
	        <td><?php echo $n; ?></td>
	        <td><?php echo $row["category"]; ?></td> 
	        <!--these were called from the table "categories" after it was merged. check from the sql statement in manage.php-->
	        <td><?php echo $row["parent"]; ?></td>
	        <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
	        <td>
		<!--  did and eid for delete id and edit id. they is used in manage.js page -->
	        	<a href="#" did="<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm del_cat">Delete</a>
	        	<a href="#" eid="<?php echo $row['cid']; ?>" class="btn btn-info btn-sm edit_cat" data-toggle="modal" data-target="#form_category">Edit</a> 
	<!-- we added the same data(modal and target) in add category here so that it will fetch when we click edit button -->
	<!-- id in add category modal and edit modal are the same -->
	        </td>
	     </tr>

		<?php

		$n++;  //for the # colunm. it loops again here

		} //for rows ends here

		?>
		<!-- the pagination srtars here -->
		<!--  This is the row for the pagination -->
		<tr><td colspan="5"><?php echo $pagination; ?></td></tr> 

		<?php
		exit();
	} 

}



			// DELETE CATEGORY

	if (isset($_POST["deleteCategory"])){
		// create instance of the class Manage
		$manage = new Manage();
		$result = $manage->deleteRecord("categories","cid",$_POST["id"]);
		echo $result;
		exit();
	}




			// UPDATE CATEGORY

	if (isset($_POST["updateCategory"])){
		// create instance of the class Manage
		$manage = new Manage();
		$result = $manage->getSingleRecord("categories","cid",$_POST["id"]);
		echo json_encode($result);
		// we use json_encode because we want to get the array( which is the $result) in our javascript in manage.js page
		exit();
	}



		// UPDATE RECORD AFTER GETING DATA BY THE USER OR ADMIN

	if (isset($_POST["update_category"])){
		// create instance of the class Manage
		$manage = new Manage();
		$id = $_POST["cid"];
		$name = $_POST["update_category"];
		$parent = $_POST["parent_cat"];
		//$status = 1; status is always 1
		$result = $manage->update_record("categories",["cid"=>$id],["parent_cat"=>$parent,"category_name"=>$name,"status"=>1]);
		echo $result;
		exit();
	}





//********************************************* For Manage Brand ************************************************


// Manage Brand for the manage_brand.php page . pass data from here to the manageBrand in main.js page
		// this manageBrand we are issetting is a function from the main.js for the manage_brand.php page
if (isset($_POST["manageBrand"])){
	// create instance of the class Manage
	$manage = new Manage();
	$result = $manage->manageRecordWithPagination("brands",$_POST["pageno"]); //if manageBrand is set, pass pageno
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	
// this is for rows
	if (count($rows) > 0){
		//we want the # column numbering should continue when we go to the next page instead of starting from 1 again
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row){ ?>

		<tr>
	        <td><?php echo $n; ?></td>
	        <td><?php echo $row["brand_name"]; ?></td> 
	        <!--these were called from the table "brand" after it was merged. check from the sql statement in manage.php-->
	        <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
	        <td>
		<!--  did and eid for delete id and edit id. they is used in manage.js page  and they row is bid-->
	        	<a href="#" did="<?php echo $row['bid']; ?>" class="btn btn-danger btn-sm del_brand">Delete</a>
	        	<a href="#" eid="<?php echo $row['bid']; ?>" class="btn btn-info btn-sm edit_brand" data-toggle="modal" data-target="#form_brand">Edit</a> 
	<!-- we added the same data(modal and target) in add brand here so that it will fetch when we click edit button -->
	<!-- id in add brand modal and edit modal are the same -->
	        </td>
	     </tr>

		<?php

		$n++;  //for the # colunm. it loops again here

		} //for rows ends here

		?>
		<!-- the pagination srtars here -->
		<!--  This is the row for the pagination -->
		<tr><td colspan="5"><?php echo $pagination; ?></td></tr> 

		<?php
		exit();
	} 

}



					// DELETE BRAND

			if (isset($_POST["deleteBrand"])){
				// create instance of the class Manage
				$manage = new Manage();
				$result = $manage->deleteRecord("brands","bid",$_POST["id"]); // primary key here is bid
				echo $result;
				exit();
			}			





							// UPDATE BRAND

			if (isset($_POST["updateBrand"])){
				// create instance of the class Manage
				$manage = new Manage();
				$result = $manage->getSingleRecord("brands","bid",$_POST["id"]);
				echo json_encode($result);
				// we use json_encode because we want to get the array( which is the $result) in our javascript in manage.js page
				exit();
			}



				// UPDATE RECORD AFTER GETING DATA BY THE USER OR ADMIN

			if (isset($_POST["update_brand"])){
				// create instance of the class Manage
				$manage = new Manage();
				$id = $_POST["bid"];
				$name = $_POST["update_brand"];
				//$status = 1; status is always 1
				$result = $manage->update_record("brands",["bid"=>$id],["brand_name"=>$name,"status"=>1]);
				echo $result;
				exit();
			}



//********************************************* For Manage Product ************************************************


// Manage Product for the manage_product.php page . pass data from here to the manageProduct in main.js page
		// this manageProduct we are issetting is a function from the main.js for the manage_product.php page
if (isset($_POST["manageProduct"])){
	// create instance of the class Manage
	$manage = new Manage();
	$result = $manage->manageRecordWithPagination("products",$_POST["pageno"]); //if manageProduct is set, pass pageno
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	
// this is for rows
	if (count($rows) > 0){
		//we want the # column numbering should continue when we go to the next page instead of starting from 1 again
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row){ ?>

		<tr>
	        <td><?php echo $n; ?></td>
	        <td><?php echo $row["product_name"]; ?></td>
	        <td><?php echo $row["category_name"]; ?></td>
	        <td><?php echo $row["brand_name"]; ?></td> 
	        <td><?php echo $row["product_price"]; ?></td>
	        <td><?php echo $row["product_stock"]; ?></td>
	        <td><?php echo $row["added_date"]; ?></td>
	        <!--these were called from the table "products" after it was merged. check from the sql statement in manage.php-->
	        <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
	        <td>
		<!--  did and eid for delete id and edit id. they is used in manage.js page  and they row is pid-->
	        	<a href="#" did="<?php echo $row['pid']; ?>" class="btn btn-danger btn-sm del_product">Delete</a>
	        	<a href="#" eid="<?php echo $row['pid']; ?>" class="btn btn-info btn-sm edit_product" data-toggle="modal" data-target="#form_products">Edit</a> 
	<!-- we added the same data(modal and target) in add products here so that it will fetch when we click edit button -->
	<!-- id in add product modal and edit modal are the same -->
	        </td>
	     </tr>

		<?php

		$n++;  //for the # colunm. it loops again here

		} //for rows ends here

		?>
		<!-- the pagination srtars here -->
		<!--  This is the row for the pagination -->
		<tr><td colspan="5"><?php echo $pagination; ?></td></tr> 

		<?php
		exit();
	} 

}




					// DELETE PRODUCT

			if (isset($_POST["deleteProduct"])){
				// create instance of the class Manage
				$manage = new Manage();
				$result = $manage->deleteRecord("products","pid",$_POST["id"]); // primary key here is bid
				echo $result;
				exit();
			}




					// UPDATE PRODUCT

			if (isset($_POST["updateProduct"])){
				// create instance of the class Manage
				$manage = new Manage();
				$result = $manage->getSingleRecord("products","pid",$_POST["id"]);
				echo json_encode($result);
				// we use json_encode because we want to get the array( which is the $result) in our javascript in manage.js page
				exit();
			}



				// UPDATE RECORD AFTER GETING DATA BY THE USER OR ADMIN

			if (isset($_POST["update_product"])){
				// create instance of the class Manage
				$manage = new Manage();
				$id = $_POST["pid"];
				$name = $_POST["update_product"];
				$cat = $_POST["select_cat"];
				$brand = $_POST["select_brand"];
				$price = $_POST["product_price"];				
				$qty = $_POST["product_qty"];
				$date = $_POST["added_date"];
				$result = $manage->update_record("products",["pid"=>$id],["cid"=>$cat,"bid"=>$brand,"product_name"=>$name,"product_price"=>$price,"product_stock"=>$qty,"added_date"=>$date]);
				echo $result;
				exit();
			}



//********************************************* For New Order Processing ************************************************


				if (isset($_POST["getNewOrderItem"])){
					// create instance of the class DBOperation to get all records
					$obj = new DBOperation();
					$rows = $obj->getAllRecord("products");


					?>

					<tr>
  						<td><b class="number">1</b></td>
  						<td>
  							<!-- the [] means they are array, not a normal input -->
  							<select name="pid[]" class="form-control form-control-sm pid" required>
  								<option value="">Choose Products</option>
  								<?php  foreach ($rows as $row){
  									?>
  									<!-- we are calling the products from the database throup their ids (value) -->
  									<option value="<?php echo $row["pid"]; ?>"><?php echo $row["product_name"] ?></option> 

  									<?php
  									}
  								 ?>
  							</select>
  						</td>
  						<td><input type="text" name="total_qty[]" class="form-control form-control-sm total_qty" readonly></td>
  						<td><input type="text" name="qty[]" class="form-control form-control-sm qty" required></td>
  						<td><input type="text" name="price[]" class="form-control form-control-sm price" readonly></span>
  						<!-- here we will get the name of the product. if we use <td>  tag, it will take space so we will use  <span> tag  the price and pro_name are in one tag check very very very well-->
  						<span ><input type="hidden" name="pro_name[]" class="form-control form-control-sm pro_name"></td>
  						<td>NGN<span class="amt">0</span></td>
  					</tr>

					<?php 

					exit();
				}



				// GET PRICE AND QUANTITY OF ONE ITEM

				if (isset($_POST["getPriceAndQty"])){
					// create instance of the class Manage
					$manage = new Manage();
					$result = $manage->getSingleRecord("products","pid",$_POST["id"]);
					echo json_encode($result); // we always use json_encode to get array data 
					exit();
				}




					//  TO PROCESS THE ORDER THAT WAS ORDERED OR REQUESTED FOR. we are getting the ids of order_date and cust_name from the order form in new_order.php


				if (isset($_POST["order_date"]) AND $_POST["cust_name"]){

					$orderdate = $_POST["order_date"];
					$cust_name = $_POST["cust_name"];


					//Now getting array from new_order.php form
					$ar_total_qty = $_POST["total_qty"];
					$ar_qty = $_POST["qty"];
					$ar_price = $_POST["price"];
					$ar_pro_name = $_POST["pro_name"];

					// the sub fields
					$sub_total = $_POST["sub_total"];
					$gst = $_POST["gst"];
					$discount = $_POST["discount"];
					$net_total = $_POST["net_total"];
					$paid = $_POST["paid"];
					$due = $_POST["due"];
					$payment_type = $_POST["payment_type"];
					

// we created a new table called invoice in the database. then, in the invoice table, we created anothe table called the invoice_details (with foreign key, invoice_no references the table invoice)

					// create instance of the class Manage
					$manage = new Manage();
					$result = $manage->storeCustomerOrderInvoice($orderdate,$cust_name,$ar_total_qty,$ar_qty,$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);
					echo $result;



				}


?>




















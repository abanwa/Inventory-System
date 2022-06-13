<?php 

include_once("./database/constants.php");

if (!isset($_SESSION["userid"])){
	header("Location: ".DOMAIN."/");
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin - Dashboard</title>
	 <script src="js/jquery-3.6.0.min.js"></script> 
	 <script src="js/popper.min.js"></script>
	 <script src="js/bootstrap.min.js"></script>
	 <link rel="stylesheet" href="css/bootstrap.min.css">
	 <link rel="stylesheet" type="text/css" href="css/all.min.css">
	 <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
	 <!-- <script src="./js/main.js"></script> -->
	 <script src="./js/order.js"></script> <!--  This is for the new_order.php -->

</head>
<body>




<!--       Navbar     -->
<?php include_once("./templates/header.php") ?>

</br></br>

<div class="container">
	<div class="row">
		<div class="col-md-10 mx-auto">
			<div class="card" style="box-shadow: 0 0 2px 0 lightgrey;">
  				<div class="card-header">
  					<h4>New Orders</h4>
  				</div>
			  <div class="card-body">

			<!--  this is for the order.js  -->
			  	<form id="get_order_data" onsubmit="return false"> 
			  		<div class="form-group row">
			  			<label class="col-sm-3 col-form-label" align="right">Order Date</label>
			  			<div class="col-sm-6">
			  				<input type="text" id="order_date" name="order_date" class="form-control form-control-sm" name="form-control-sm" value="<?php echo date("Y-m-d"); ?>" readonly>
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label class="col-sm-3 col-form-label" align="right">Customer Name</label>
			  			<div class="col-sm-6">
			  				<input type="text" id="cust_name" name="cust_name" class="form-control form-control-sm" name="form-control-sm" placeholder="Enter Customer Name" required>
			  				 <small id="cust_name_error" class="form-text text-muted"></small> <!-- to validate cust_name error in order.js -->
			  			</div>
			  		</div>

			  		<div class="card" style="box-shadow: 0 0 15px 0 lightgrey;">
			  			<div class="card-body">
			  				<h3>Make an order list</h3>
<!--    --------------------------- table ----------------------------------------- -->
			  				<table align="center" style="width:800px;">
			  					<thead>
			  					<tr>
			  						<th>#</th>
			  						<th style="text-align: center;">Item Name</th>
			  						<th style="text-align: center;">Total Quantity</th>
			  						<th style="text-align: center;">Quantity</th>
			  						<th style="text-align: center;">Price</th>
			  						<th>Total</th>

			  					</tr>
			  				</thead>
			  				<tbody id="invoice_item"> <!-- the prodcts from database will display here -->
			  					<!-- <tr>
			  						<td><b id="number">1</b></td>
			  						<td> -->
			  							<!-- the [] means they are array, not a normal input -->
			  							<!-- <select name="pid[]" class="form-control form-control-sm" required>
			  								<option>Washing Machine</option>
			  							</select>
			  						</td>
			  						<td><input type="text" name="total_qty[]" class="form-control form-control-sm" readonly></td>
			  						<td><input type="text" name="qty[]" class="form-control form-control-sm" required></td>
			  						<td><input type="text" name="price[]" class="form-control form-control-sm" readonly></td>
			  						<td>NGN.1540</td>
			  					</tr>
			  					 -->
			  				</tbody>

			  				</table>
		<!------------------------------ Table Ends --------------------------------------------->
			  				<center style="padding: 10px;">
			  					<button class="btn btn-success" id="add" style="width:150px;">Add</button>
			  					<button class="btn btn-danger" id="remove" style="width:150px;">Remove</button>
			  				</center>
			  				
			  			</div>  <!-- Card body Ends -->
			  			
			  		</div>  <!-- Order List Card Ends -->

			  		<p></p>
			  		<div class="form-group row">
			  			<label for="sub_total" class="col-sm-3 col-form-label" align="right">Sub Total</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="sub_total" id="sub_total" class="form-control form-control-sm" readonly>
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="gst" class="col-sm-3 col-form-label" align="right">GST (18%)</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="gst" id="gst" class="form-control form-control-sm" readonly>
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="discount" class="col-sm-3 col-form-label" align="right">Discount</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="discount" id="discount" class="form-control form-control-sm" required>
			  				<small id="dis_error" class="form-text text-muted"></small> <!-- to validate discount error in order.js -->
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="net_total" class="col-sm-3 col-form-label" align="right">Net Total</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="net_total" id="net_total" class="form-control form-control-sm" readonly>
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="paid" class="col-sm-3 col-form-label" align="right">Paid</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="paid" id="paid" class="form-control form-control-sm" required>
			  				<small id="paid_error" class="form-text text-muted"></small> <!-- to validate paid error in order.js -->
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="due" class="col-sm-3 col-form-label" align="right">Due</label>
			  			<div class="col-sm-6">
			  				<input type="text" name="due" id="due" class="form-control form-control-sm" readonly>
			  			</div>
			  		</div>
			  		<div class="form-group row">
			  			<label for="payment_type" class="col-sm-3 col-form-label" align="right">Payment Method</label>
			  			<div class="col-sm-6">
			  				<select name="payment_type" id="payment_type" class="form-control form-control-sm" required>
			  					<option>Cash</option>
			  					<option>Card</option>
			  					<option>Draft</option>
			  					<option>Cheque</option>
			  				</select>
			  			</div>
			  		</div>

			  		<center>
			  			<input type="submit" id="order_form" class="btn btn-info" value="Order" style="width:150px;">
			  			<input type="submit" id="print_invoice" class="btn btn-success d-none" value="Print Invoice" style="width:150px;"> <!-- d-none is a bootstrap class that makes something invisible. it hides it -->
			  		</center>


			  	</form>
			    
			  </div>
			</div>
		</div>
	</div>
</div>


















</body>
</html>





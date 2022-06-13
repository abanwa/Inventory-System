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
	 <!-- Here , we will use manage.js because we are using only that function in manage.js for this page -->
	 <!-- <script src="./js/main.js"></script> -->
	 <script src="./js/manage.js"></script>

</head>
<body>


<!--       Navbar     -->
<?php include_once("./templates/header.php") ?>


</br></br>

	<div class="container">
		<table class="table table-hover table-bordered">
	    <thead>
	      <tr>
	        <th>#</th>
	        <th>Product</th>
	        <th>Category</th>
	        <th>Brand</th>
	        <th>Price</th>
	        <th>Stock</th>
	        <th>Added Date</th>
	        <th>Status</th>
	        <th>Action</th>
	      </tr>
	    </thead>
	    <tbody id="get_product">
	    	<!--   We Used this part we commented in the process.php page for manageRecordswitPagination for category -->
	      <!-- <tr>
	        <td>1</td>
	        <td>Electronics</td>
	        <td>Root</td>
	        <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
	        <td>
	        	<a href="#" class="btn btn-danger btn-sm">Delete</a>
	        	<a href="#" class="btn btn-info btn-sm">Edit</a>
	        </td>
	      </tr> -->
	      
	    </tbody>
	  </table>
	</div>


<?php include_once("./templates/update_products.php"); ?>




</body>
</html>




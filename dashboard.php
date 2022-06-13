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
	 <script src="./js/main.js"></script>

</head>
<body>

<!--       Navbar     -->
<?php include_once("./templates/header.php") ?>


</br></br>
<div class="container">
	
	<div class="row">
		<div class="col-md-4">
			<div class="card mx-auto">
			  <img src="./images/user.png" class="card-img-top mx-auto" style="width: 60%;" alt="Card image">
			  <div class="card-body">
			    <h4 class="card-title">Profile Info</h4>
			   <p class="card-text"><i class="fa fa-user">&nbsp;</i>Abanwa Raphael</p>
			   <p class="card-text"><i class="fa fa-user">&nbsp;</i>Admin</p>
			   <p class="card-text">Last Login : xxxx-xx-xx</p>
			   <a href="#" class="btn btn-primary"><i class="fa-solid fa-edit">&nbsp;</i>Edit Profile</a>
			  </div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="jumbotron" style="width: 100%; height: 100%;">
				<h1>Welcome Admin,</h1>
				<div class="row">
					<div class="col-sm-6">
						<iframe src="https://free.timeanddate.com/clock/i874e0z5/n4843/szw160/szh160/cf100/hnce1ead6" frameborder="0" width="160" height="160"></iframe>
					</div>
					<div class="col-sm-6">
						<div class="card">
					      <div class="card-body">
					        <h5 class="card-title">New Orders</h5>
					        <p class="card-text">Here you can make invoices and new orders</p>
					        <a href="new_order.php" class="btn btn-primary">New Orders</a>
					      </div>
					    </div>
					</div>
				</div>
			</div>
			
		</div>

	</div>

</div>
<p></p>
<p></p>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
		      <div class="card-body">
		        <h4 class="card-title">Categories</h4>
		        <p class="card-text">Here you can manage your categories and you can add new parents and sub parents categories</p>
		        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#form_category">Add</a>
		        <a href="manage_categories.php" class="btn btn-primary">Manage</a>
		      </div>
		    </div>
		</div>

		<div class="col-md-4">
			<div class="card">
		      <div class="card-body">
		        <h4 class="card-title">Brands</h4>
		        <p class="card-text">Here you can manage your brand and you can add new brand</p>
		        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#form_brand">Add</a>
		        <a href="manage_brand.php" class="btn btn-primary">Manage</a>
		      </div>
		    </div>
		</div>

		<div class="col-md-4">
			<div class="card">
		      <div class="card-body">
		        <h4 class="card-title">Products</h4>
		        <p class="card-text">Here you can manage your brand and you can add new brand</p>
		        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#form_products">Add</a>
		        <a href="manage_product.php" class="btn btn-primary">Manage</a>
		      </div>
		    </div>
		</div>
	</div>
</div>




<!-- Modal for category form -->
<?php include_once("./templates/category.php"); ?>

<!-- Modal for brand form -->
<?php include_once("./templates/brand.php"); ?>

<!-- Modal for product form -->
<?php include_once("./templates/products.php"); ?>




</body>
</html>





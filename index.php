<?php 

include_once("./database/constants.php");
if (isset($_SESSION["userid"])){
	header("Location: ".DOMAIN."/dashboard.php");
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inventory Management System</title>
	 <script src="js/jquery-3.6.0.min.js"></script> 
	 <script src="js/popper.min.js"></script>
	 <script src="js/bootstrap.min.js"></script>
	 <link rel="stylesheet" href="css/bootstrap.min.css">
	 <link rel="stylesheet" type="text/css" href="css/all.min.css">
	 <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
	 <link rel="stylesheet" type="text/css" href="includes/style.css">
	 <script rel="stylesheet" src="./js/main.js"></script>

</head>
<body>
	<!-- loader -->
	<div class="overlay"><div class="loader"></div></div>

<!--       Navbar     -->
<?php  include_once("./templates/header.php"); ?>

</br></br>
<div class="container">
	<!--  get message from main.js -->
	<?php 
	
	if (isset($_GET["msg"]) AND !empty($_GET["msg"])){ ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?php echo $_GET["msg"]; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  	<span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php 
	}
	?>
	
	<div class="card mx-auto" style="width: 18rem;">
	  <img src="./images/login.png" class="card-img-top mx-auto" style="width: 60%;" alt="Login Icon">
	  <div class="card-body">
    	<form id="form_login" onsubmit="return false">
  			<div class="form-group">
		    	<label for="email">Email address</label>
		    	<input type="email" class="form-control" name="log_email" id="log_email" placeholder="Enter your Email">
		    	<small id="e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
		  	</div>
  			<div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" name="log_password" id="log_password" placeholder="Enter your Password">
			    <small id="p_error" class="form-text text-muted"></small>
  			</div>

  			<button type="submit" class="btn btn-primary"><i class="fa fa-lock">&nbsp;</i>Login</button>
  			<span><a href="register.php">Register</a></span>
		</form>
  	</div>
  	<div class="card-footer"><a href="#">Forget Password ?</a></div>

</div>

</div>



</body>
</html>







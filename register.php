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
	 <script src="./js/main.js"></script>

</head>
<body>
	<!-- loader -->
	<div class="overlay"><div class="loader"></div></div>


<!--       Navbar     -->
<?php include_once("./templates/header.php"); ?>


</br></br>
<div class="container">
	<!--   this form is treated using javascript jquery in ./js/main.js -->
	<div class="card mx-auto" style="width: 30rem;margin: 0 auto;">
		  <div class="card-header">Register</div>
		  <div class="card-body">
		    <form id="register_form" onsubmit="return false" autocomplete="off">
			  <div class="form-group">
			    <label for="username">Full Name</label>
			    <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
			    <small id="u_error" class="form-text text-muted"></small>
			  </div>
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
			    <small id="e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
			    <label for="password1">Password</label>
			    <input type="password" name="password1" class="form-control" id="password1" placeholder="Password">
			    <small id="p1_error" class="form-text text-muted"></small>
			  </div>
			  <div class="form-group">
			    <label for="password2">Re-enter Password</label>
			    <input type="password" name="password2" class="form-control" id="password2" placeholder="Password">
			    <small id="p2_error" class="form-text text-muted"></small>
			  </div>
			  <div class="form-group">
			    <label for="usertype">Usertype</label>
			    <select name="usertype" class="form-control" id="usertype">
			    	<option value="">Choose User Type</option>
			    	<option value="1">Admin</option>
			    	<option value="0">Other</option>
			  	</select>
			  	<small id="t_error" class="form-text text-muted"></small>
			</div>
			  
			  <button type="submit" name="user_register" id="reg" class="btn btn-primary"><span class="fa fa-user"></span>&nbsp;Register</button>
			  <span><a href="index.php">Login</a></span>
			</form>
		  </div>
		  
	</div>

</div>


<!-- <script type="text/javascript">
	console.log("hello");
	$("#reg").click(function(){
		alert("clicked");
	});

</script> -->
</body>
</html>






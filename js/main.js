
// NOTE: everything is processed here before going to the process pages to collect some data before continuing expecially at the ajax point


$(document).ready(function(){

			// FOR REGISTRATION

		var DOMAIN = "http://localhost/inventory_1/public"; //file path to the page where the ajax process data. take note, the path file(url) continues down

	$("#register_form").on("submit", function(){
		var status = false;
		var name = $("#username");
		var email = $("#email");
		var pass1 = $("#password1");
		var pass2 = $("#password2");
		var type = $("#usertype");
		//var n_patt = new RegExp(/^[A-Za-z ]+$/);
		//naza.aba@gmail.com
		var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/);
		// for username
		if(name.val() == "" || name.val().length < 6){
			name.addClass("border-danger");
			$("#u_error").html("<span class='text-danger'>Please Enter your Name and your name must be more than 6 characters</span>");
			status = false;
		} else {
			name.removeClass("border-danger");
			$("#u_error").html("");
			status = true;
		}
		// for email
		if(!e_patt.test(email.val())){
			email.addClass("border-danger");
			$("#e_error").html("<span class='text-danger'>Please Enter a valid Email address</span>");
			status = false;
		} else {
			email.removeClass("border-danger");
			$("#e_error").html("");
			status = true;
		}
		// for password 1
		if(pass1.val() == "" || pass1.val().length < 9){
			pass1.addClass("border-danger");
			$("#p1_error").html("<span class='text-danger'>Please Enter more than 9 digit password</span>");
			status = false;
		} else {
			pass1.removeClass("border-danger");
			$("#p1_error").html("");
			status = true;
		}
		// for password 2
		if(pass2.val() == "" || pass2.val().length < 9){
			pass2.addClass("border-danger");
			$("#p2_error").html("<span class='text-danger'>Please Enter more than 9 digit password</span>");
			status = false;
		} else {
			pass2.removeClass("border-danger");
			$("#p2_error").html("");
			status = true;
		}
		// for User Type 
		if(type.val() == ""){
			type.addClass("border-danger");
			$("#t_error").html("<span class='text-danger'>Please choose a usertype</span>");
			status = false;
		} else {
			type.removeClass("border-danger");
			$("#t_error").html("");
			status = true;
		}


		// checking if the passwords are the same. This will work if status == true bcos it returned false in the form
		if ((pass1.val() == pass2.val()) && status == true){
			$(".overlay").show(); // shows the loader
			$.ajax({
				url: DOMAIN+"/includes/process.php",
				method: "POST",
				data: $("#register_form").serialize(),
				success: function(data){
					//alert(data);
					if (data.trim() == "EMAIL_ALREADY_EXISTS"){
						$(".overlay").hide(); // hide the loader
						alert("your email is already registered");
					} else if (data.trim() == "SOME_ERROR"){
						$(".overlay").hide(); // hide the loader
						alert("Something is wrong");
					} else {
						$(".overlay").hide(); // hide the loader
						window.location.href = encodeURI(DOMAIN+"/index.php?msg=You are registered. Now you can login.");
					}
				}
			})
		} else {
			pass2.addClass("border-danger");
			$("#p2_error").html("<span class='text-danger'>Password does not match</span>");
			status = false; //it was true before
		}



	})




		// FOR LOGIN

		$("#form_login").on("submit",function(){
			var email = $("#log_email");
			var pass = $("#log_password");
			var status = false;

			// For Email
			if (email.val() == ""){
				email.addClass("border-danger");
				$("#e_error").html("<span class='text-danger'>Please Enter a valid Email Address</span>");
				status = false;
			} else {
				email.removeClass("border-danger");
				$("#e_error").html("");
				status = true;
			}
			// For Password
			if (pass.val() == ""){
				pass.addClass("border-danger");
				$("#p_error").html("<span class='text-danger'>Please Enter Password</span>");
				status = false;
			} else {
				pass.removeClass("border-danger");
				$("#p_error").html("");
				status = true;
			}

			if (status){
				$(".overlay").show(); // for loading to show it

				$.ajax({

					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#form_login").serialize(),
					success : function(data){
						if (data.trim() == "NOT_REGISTERD"){
							$(".overlay").hide(); // for loading to hide it
							email.addClass("border-danger");
							$("#e_error").html("<span class='text-danger'>User not registered</span>");
							status = false;
							return;
						} else if (data.trim() == "PASSWORD_NOT_MATCHED"){
							$(".overlay").hide(); // for loading to hide it
							pass.addClass("border-danger");
							$("#p_error").html("<span class='text-danger'>Incorrect Password</span>");
							status = false;
						}  else if (data.trim() == "not_logged_in"){
							$(".overlay").hide(); // for loading to hide it
							pass.addClass("border-danger");
							$("#e_error").html("<span class='text-danger'>something went wrong</span>");
							status = false;
						} else {
							$(".overlay").hide(); // for loading to hide it
							console.log(data.trim());
							window.location.href = DOMAIN+"/dashboard.php";
						}
					}

				})
			}


		});
	


			// fetch category  is to get data from add category ( in modal form-body )
		fetch_category(); // i decided to call the function here
		function fetch_category(){

			$.ajax({

				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {getCategory:1}, // get the data from database and process it in the getCategory in process.php page
				success : function(data){
					//alert(data);
					var root = "<option value='0'>Root</option>";//from add caegory modal form
					var choose = "<option value=''>Choose Category</option>"; // category from add product modal form
					$("#parent_cat").html(root+data.trim()); //this gets the category_name from database in put in our form html. it always has to deal with "select" elements
					$("#select_cat").html(choose+data.trim()); // this is for the category in the  product modal form. it ia taken from the database
				}
			})
		}




			// fetch Brand  is to get data from add ca ( in modal form-body )
		fetch_brand(); // i decided to call the function here
		function fetch_brand(){

			$.ajax({

				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {getBrand:1}, // get the data from database and process it in the getBrand in process.php page
				success : function(data){
					var choose = "<option value=''>Choose Brand</option>";// brand from add product modal form
					$("#select_brand").html(choose+data.trim()); // this is for the brand select option in the product modal form. it ia taken from the database
				}
			})
		}




		// Add CAtegory from the add category modal form

		$("#category_form").on("submit",function(){

			if ($("#category_name").val() == ""){
				$("#category_name").addClass("border-danger");
				$("#cat_error").html("<span class='text-danger'>Please Enter Category Name.</span>");
			} else {
				$.ajax({
					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#category_form").serialize(),
					success : function(data){
						//console.log(data.trim()); the trim is to remove white spaces.
						//console.log("hello");
						//alert(data.trim());
						if (data.trim() == "CATEGORY_ADDED"){
							$("#category_name").removeClass("border-danger");
							$("#cat_error").html("<span class='text-success'>New Category Added Successfully..!</span>");
							$("#category_name").val("");
							fetch_category();// so that any category added from the modal form will be on the list in that modal form
						} else {
							alert(data.trim());
						}
					 }
				})
			}

		});




		// Add Brand from the add brand modal form

		$("#brand_form").on("submit", function(){

			if ($("#brand_name").val() == ""){
				$("#brand_name").addClass("border-danger");
				$("#brand_error").html("<span class='text-danger'>Please Enter Brand Name.</span>")
			} else {
				// we write code for ajax

				$.ajax({

					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#brand_form").serialize(),
					success : function(data){
						if (data.trim() == "BRAND_ADDED"){
							$("#brand_name").removeClass("border-danger");
							$("#brand_error").html("<span class='text-success'>New Brand Added Successfully..!</span>");
							$("#brand_name").val("");
							fetch_brand();// so that any brand added from the modal form will be on the list in that modal form that deals with select like it appeared in the brand, in product modal form
						} else {
							alert(data.trim());
						}
						
					}
				})

			}


		});





			// add product

			$("#product_form").on("submit", function(){

				$.ajax({

					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#product_form").serialize(),
					success : function(data){
						if (data.trim() == "NEW_PRODUCT_ADDED"){
							alert("New Product added Successfully..!");
							$("#product_name").val("");
							$("#select_cat").val("");
							$("#select_brand").val("");
							$("select_price").val("");
							$("#product_qty").val("");

							//alert(data.trim());
						} else {
							//console.log(data.trim());
							alert(data.trim());
						}
						
					}
				})

			})






		}); // End of  document.ready function






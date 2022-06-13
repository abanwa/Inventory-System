
// NOTE: we created this page specially for managing of categories,brands and others because it if we put this codes in main.js, it will be slow to load.
// other functions will interfer with it
// our applications will be more efficient thats why we created a ne js file or page for it


$(document).ready(function(){

var DOMAIN = "http://localhost/inventory_1/public"; //file path to the page where the ajax process data. take note, the path file(url) continues down



//*******************************************************************************************************************
//							FOR CATEGORY
//********************************************************************************************************************

				// Manage Category for the manage_categories.php page to get data from database and display it there
		manageCategory(1); // we passed 1 as the pageno
		function manageCategory(pn){
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {manageCategory:1,pageno:pn},  // when it is not a form, we do it like this
				success : function(data){
					//this is the only time the id of the table body is used to display the records from databsae to users
					$("#get_category").html(data.trim());
					//alert(data.trim());
				}

			})
		}



		// for the pagination especially for those pn
		$("body").delegate(".page-link","click",function(){
			var pn = $(this).attr("pn");
			//alert(pn); pn will give out a number depending on the page you clicked
			manageCategory(pn);


			// this code means after delegation, when you click any of the pagination link with the class ".page-link", (in this case
			// all of them have the link).it will select that particular one you clicked that has an attribute ("pn") bacuse of the $this you used.
			//we call the function and passed the pn so that it will work in that particular function
		});



			// TO DELETE RECORD FROM manage_categories.php
			// .del_cat class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".del_cat","click",function(){
			var did = $(this).attr("did");
			// alert(did);
			// to confirm if you really want to delete the record
			if (confirm("Are you sure you want to delete...!?")){
				
				$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteCategory:1,id:did}, // requires id from the process.php page
				success : function(data){
					//this is the only time the id of the table body is used to delete the records from databsae to users
					// when it's the parent category
					if (data.trim() == "DEPENDENT_CATEGORY"){
						alert("Sorry! this Category is dependent on other sub categories");
					} else if (data.trim() == "CATEGORY_DELETED"){
						//when it's still a category but not the parent category
						alert("Category deleted Successfully..");
						manageCategory(1); //we added it here so that when we add another category, it will appear at the manage_Category.php page
					} else if (data.trim() == "DELETED"){
						//when it's a different table but not category
						alert("Deleted Successfully");
					} else {
						alert(data.trim());
					}


				}

			})

			} else {
				// alert("No");
			} // End of (confirm) if..

		})



		// we just copied it from main.js and paste here so that we can use it for the selete option in update category.
		// it will help fetch the categories in the database for update
		fetch_category(); 
		function fetch_category(){

			$.ajax({

				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {getCategory:1}, 
				success : function(data){
					//alert(data);
					var root = "<option value='0'>Root</option>";
					var choose = "<option value=''>Choose Category</option>";
					$("#parent_cat").html(root+data.trim()); //this gets the category_name from database in put in our form html. it always has to deal with "select" elements
					$("#select_cat").html(choose+data.trim()); //this gets the category_name from database in put in our form html. it always has to deal with "select" elements. this is for manage_products.php edit button modal form for the category input with id, select_cat
				}
			})
		}





		// we just copied it from main.js and paste here so that we can use it for the selete option in update products.
		// it will help fetch the brands in the database for update
		fetch_brand(); 
		function fetch_brand(){

			$.ajax({

				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {getBrand:1}, // get the data from database and process it in the getBrand in process.php page
				success : function(data){
					var choose = "<option value=''>Choose Brand</option>";// brand from add product modal form
					$("#select_brand").html(choose+data.trim()); // this is for the brand select option in the product modal form. it ia taken from the database and also the manage_products edit moda form because they share the same id, "select_brand"
				}
			})
		}





				// UPDATE CATEGORY
				// .edit_cat class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".edit_cat","click",function(){
			var eid = $(this).attr("eid");
			// 
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				dataType : "json",
				data : {updateCategory:1,id:eid}, // id is eid for edit
				success : function(data){
					//alert(data); // it gives us an object from the database because of json
					console.log(data);
					$("#cid").val(data["cid"]); //the id(cid) was gotten from the update_category form in updata_category.php page 
					//and given the value of the cid in the database which was clicked. same for others
					$("#update_category").val(data["category_name"]); //update_category is from the edit modal form in  update_category.php 
					$("#parent_cat").val(data["parent_cat"]);
					
				} 

			})

		}); // end of update category




				// UPDATE BUTTON FORM for edit modal in  update_category.php 

		$("#update_category_form").on("submit",function(){
			// we paste the add category code here from main.js. it's the code that's why

			if ($("#update_category").val() == ""){
				$("#update_category").addClass("border-danger");
				$("#cat_error").html("<span class='text-danger'>Please Enter Category Name.</span>");
			} else {
				$.ajax({
					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#update_category_form").serialize(),
					success : function(data){
						// alert(data.trim());
						window.location.href = "";
					 }
				})
			}

		});




//*******************************************************************************************************************
//							FOR BRAND
//********************************************************************************************************************


				// Manage Brand for the manage_brand.php page to get data from database and display it there
		manageBrand(1); // we passed 1 as the pageno
		function manageBrand(pn){
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {manageBrand:1,pageno:pn},  // when it is not a form, we do it like this
				success : function(data){
					//this is the only time the id of the table body is used to display the records from databsae to users
					$("#get_brand").html(data.trim());
					//alert(data.trim());
				}

			})
		}


		// for the pagination especially for those pn
		$("body").delegate(".page-link","click",function(){
			var pn = $(this).attr("pn");
			//alert(pn); pn will give out a number depending on the page you clicked
			manageBrand(pn);


			// this code means after delegation, when you click any of the pagination link with the class ".page-link", (in this case
			// all of them have the link).it will select that particular one you clicked that has an attribute ("pn") bacuse of the $this you used.
			//we call the function and passed the pn so that it will work in that particular function
		});



		// TO DELETE RECORD FROM manage_brand.php
		// .del_brand class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".del_brand","click",function(){
			var did = $(this).attr("did");
			// alert(did);
			// to confirm if you really want to delete the record
			if (confirm("Are you sure you want to delete...!?")){
				
				$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteBrand:1,id:did}, // requires id from the process.php page
				success : function(data){
					//this is the only time the id of the table body is used to delete the records from databsae to users
					// when it's the parent category
					if (data.trim() == "DELETED"){
						alert("Brand is deleted");
						manageBrand(1); // we called it here so that when we delete, we won't have to refresh before that record leaves
					} else {
						alert(data.trim());
					}

				}

			})

			} // End of (confirm) if 

		}) // eEnd of body






				// UPDATE BRAND
				// .edit_brand class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".edit_brand","click",function(){
			var eid = $(this).attr("eid");
			// 
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				dataType : "json",
				data : {updateBrand:1,id:eid}, // id is eid for edit
				success : function(data){
					//alert(data); // it gives us an object from the database because of json
					console.log(data);
					$("#bid").val(data["bid"]); //the id(bid) was gotten from the update_brand form in update_brand.php page 
					//and given the value of the bid in the database which was clicked. same for others
					$("#update_brand").val(data["brand_name"]); //update_brand is from the edit modal form in  update_brand.php 
					
				} 

			})

		}); // end of update brand





					// UPDATE BUTTON FORM for edit modal in  update_brand.php 

		$("#update_brand_form").on("submit",function(){
			// we paste the add category code here from main.js. it's the code that's why

			if ($("#update_brand").val() == ""){
				$("#update_brand").addClass("border-danger");
				$("#cat_error").html("<span class='text-danger'>Please Enter Brand Name.</span>");
			} else {
				$.ajax({
					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#update_brand_form").serialize(),
					success : function(data){
						 alert(data.trim());
						window.location.href = "";
					 }
				})
			}

		});




//*******************************************************************************************************************
//							FOR PRODUCT
//********************************************************************************************************************


				// Manage Product for the manage_product.php page to get data from database and display it there
		manageProduct(1); // we passed 1 as the pageno
		function manageProduct(pn){
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {manageProduct:1,pageno:pn},  // when it is not a form, we do it like this
				success : function(data){
					//this is the only time the id of the table body is used to display the records from databsae to users
					$("#get_product").html(data.trim());
					//alert(data.trim());
				}

			})
		}


		// for the pagination especially for those pn
		$("body").delegate(".page-link","click",function(){
			var pn = $(this).attr("pn");
			//alert(pn); pn will give out a number depending on the page you clicked
			manageProduct(pn);


			// this code means after delegation, when you click any of the pagination link with the class ".page-link", (in this case
			// all of them have the link).it will select that particular one you clicked that has an attribute ("pn") bacuse of the $this you used.
			//we call the function and passed the pn so that it will work in that particular function
		});



		// TO DELETE RECORD FROM manage_product.php
		// .del_product class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".del_product","click",function(){
			var did = $(this).attr("did");
			// alert(did);
			// to confirm if you really want to delete the record
			if (confirm("Are you sure you want to delete...!?")){
				
				$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteProduct:1,id:did}, // requires id from the process.php page
				success : function(data){
					//this is the only time the id of the table body is used to delete the records from databsae to users
					// when it's the parent category
					if (data.trim() == "DELETED"){
						alert("Product is deleted");
						manageProduct(1); // we called it here so that when we delete, we won't have to refresh before that record leaves
					} else {
						alert(data.trim());
					}

				}

			})

			} // End of (confirm) if 

		}) // eEnd of body





					// UPDATE PRODUCT
				// .edit_product class is given in the process.php page for the foreach loop. the <a> tag link
		$("body").delegate(".edit_product","click",function(){
			var eid = $(this).attr("eid");
			// 
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				dataType : "json",
				data : {updateProduct:1,id:eid}, // id is eid for edit
				success : function(data){
					//alert(data); // it gives us an object from the database because of json
					console.log(data);
					$("#pid").val(data["pid"]); //the id(pid) was gotten from the update_product form in update_product.php page 
					//and given the value of the pid in the database which was clicked. same for others
					$("#update_product").val(data["product_name"]); //update_product is from the edit modal form in  update_product.php 
					$("#select_cat").val(data["cid"]);
					$("#select_brand").val(data["bid"]);
					$("#product_price").val(data["product_price"]);
					$("#product_qty").val(data["product_stock"]);
					
				} 

			})

		}); // end of update product




					// UPDATE PRODUCT FORM

			$("#update_product_form").on("submit", function(){

				$.ajax({

					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#update_product_form").serialize(),
					success : function(data){
						if (data.trim() == "UPDATED"){
							alert("Product Updated Successfully..!");
							window.location.href = "";

							//alert(data.trim());
						} else {
							//console.log(data.trim());
							alert(data.trim());
						}
						
					}
				})

			})









	}); // End of Document.ready function



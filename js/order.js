
$(document).ready(function(){
			
		var DOMAIN = "http://localhost/inventory_1/public"; //file path to the page where the ajax process data. take note, the path file(url) continues down

						// ADD IN NEW ORDER

			addNewRow(); // add new row  is to get data from add products and added a row when we click add . it will automatically show us the first row from the database because we called the addNewRow function here
			$("#add").click(function(){

				addNewRow(); // we call it here so that it will add a new row when we click on add in new_order.php
			})


	function addNewRow(){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {getNewOrderItem:1}, // go to the process page to know how the data was used
			success: function(data){
				//alert(data.trim());
				$("#invoice_item").append(data.trim()); // append is used to add data with the existing data
				// for the numbers to increase as you add more rows
				var n = 0;
				$(".number").each(function(){
					$(this).html(++n);  // the class .number should be increasing 
				})
			}
		})
	}




					// FOR REMOVE TO REMOVE A ROW

			$("#remove").click(function(){
				// this means from new_order.php page, the table body id(invoice_item) has many children. so we want to remove the last child by clicking remove.
				$("#invoice_item").children("tr:last").remove();
				calculate(0,0); // so that when we remove a record or item, it will re-calculate. you only call these when you have written your calculate() function
			});



			// This is to change the quantity of a product when another product is selected 

			$("#invoice_item").delegate(".pid","change",function(){
				var pid = $(this).val();
				//alert(pid);
				// to know which qty,price etc is click, (this) is the one or class clicked, it has a parent(td) and the td has a parent(tr)
				var tr = $(this).parent().parent();
				$(".overlay").show(); // we show this because there is delay in live server so instead of them to just be waiting, this should be showing

				$.ajax({
					url : DOMAIN+"/includes/process.php",
					method : "POST",
					dataType : "json",
					data : {getPriceAndQty:1,id:pid},
					success : function(data){
						//console.log(data); // i need only product price and stock from the database
						tr.find(".total_qty").val(data["product_stock"]); //stock is the total quantity available . fimd is use to go get the the class from the process.php page for the getNewOrderItem
						tr.find(".pro_name").val(data["product_name"]); // it's hidden so we can't see it
						tr.find(".qty").val(1); // we work faster with one. we can increase or decrease it. it's the convention. quantity is not in the database
						tr.find(".price").val(data["product_price"]);
						tr.find(".amt").html(tr.find(".qty").val() * tr.find(".price").val()); // the amout is the qty value multiply by the price. but we gave quantity to be 1
						calculate(0,0); // we call the function wherever we use amt. we parse 0 as the initial discount until you change the value and the initial amt paid is zero 
					}
				})
			});






				// TO CALCULATE THE PRICE WHEN WE ADD MORE THAN ONE QUANTITY . this function will work when we press or add quantity

				$("#invoice_item").delegate(".qty","keyup",function(){
					var qty = $(this);
					// this simply target the overall parent tag. (.qty->td->tr) go to process.php page to see it
					var tr = $(this).parent().parent();
					//alert(tr.find(".total_qty").val()); // find and get the value of a class(.total_qty)

					//this if statement said if it's not a number, it should throw the alert statement
					if (isNaN(qty.val())){
						alert("Please enter a valid quantity");
						qty.val(1);  // just leave it to remain 1 as it was instead
					} else {
						//if the quantity is bigger than available quantity (total qty) in our database, it should throw an alert statement (error). we minus zero from both sides to make it the computer know we are dealing with numbers else it won't work
						if ((qty.val() - 0) > (tr.find(".total_qty").val() - 0)){
							alert("Sorry, this quantity is not available");
							qty.val(1);  // just leave it to remain 1 as it was instead
						} else {
							tr.find(".amt").html(qty.val() * tr.find(".price").val()); // amt multiply by qauntity (qty)
							calculate(0,0);  // we call the function wherever we use amt. we parse 0 as the initial discount until you change the value and the initial amt paid is zero 
						}
					}

				});




					// TO CALCULATE THE PRICES DISCOUNTS AND OTHERS

			function calculate(dis,paid){
 // we said for each amt in the total column, it should be added . we made sub total so it can work.we can use any variable. then we called the calculate () on the functions that has to do with amt and change of qty so that it can work upon add or choosing product
				var sub_total = 0;
				var gst = 0; // tax
				var net_total = 0;
				var discount = dis;
				var paid_amt = paid;
				var due = 0;
				$(".amt").each(function(){
					sub_total = sub_total + ($(this).html() * 1); // we also multiply it by one so that javascript will treat it as a number
				})


				gst = (18/100) * sub_total;
				net_total = gst + sub_total;
				net_total = net_total - discount;
				due = net_total - paid_amt;
				$("#gst").val(gst);

				$("#sub_total").val(sub_total); //the values will display on the sub_total

				$("#net_total").val(net_total);

				$("#discount").val(discount); // discount is the value we input as discount
				
				// $("#paid")

				$("#due").val(due);




			}

				// function to for the discount when we change it

				$("#discount").keyup(function(){
					var discount = $(this).val(); // discount is the value we input as discount and we parse paid as 0 initially
					calculate(discount,0);
				});


				// function to for the paid amount 

				$("#paid").keyup(function(){
					var paid = $(this).val();
					var discount = $("#discount").val(); // we have to get the discount because we are need the discount when looking for the paid amount
					calculate(discount,paid); // discount is the value we input as discount and we parse paid as when the person pays a certain amount and to balance us later (which is the due)
				});



					// ORDER ACCEPTING to code how the "order" works by clicking the order button at new_order.php

				$("#order_form").click(function(){

					var invoice = $("#get_order_data").serialize(); // this gets the order form then validate those input fields that are not on readonly and we will add the serialised form to print invoice_bill.php page

					var status = false;
					var cust_name = $("#cust_name");
					var discount = $("#discount");
					var paid = $("#paid");

					var check = new RegExp(/^[a-zA-Z_-]+$/);
					//var check2 = new RegExp(/^[0-9]{1,100}$/);
					var check2 = new RegExp(/^[0-9]{1,100}(\.[0-9]{1,2})*$/); //regular expression which allow both decimals as well as integers
					

					if(cust_name.val() === ""){
						cust_name.addClass("border-danger");
						$("#cust_name_error").html("<span class='text-danger'>Please Enter Your Name</span>");
						status = false;
					}else{
						cust_name.removeClass("border-danger");
						//console.log(cust_name.val());
						$("#cust_name_error").html("");
						status = true;
					}
					if(discount.val() === "" || check.test(discount.val())){
						discount.addClass("border-danger");
						$("#dis_error").html("<span class='text-danger'>Please Enter valid figures</span>");
						status = false;
					}else{
						discount.removeClass("border-danger");
						//console.log(discount.val());
						$("#dis_error").html("");
						status = true;
					}
					if(paid.val() === "" || check.test(paid.val())){
						paid.addClass("border-danger");
						$("#paid_error").html("<span class='text-danger'>Please Enter valid figures</span>");
						status = false;
					}else{
						paid.removeClass("border-danger");
						// console.log(paid.val());
						$("#paid_error").html("");
						status = true;
					}
					if ((check2.test(discount.val())) && (check2.test(paid.val()))){
						//console.log("true");

						$.ajax({
						url : DOMAIN+"/includes/process.php",
						method : "POST",
						data : $("#get_order_data").serialize(), // this form id is for new_order.php form
						success : function(data){

							// data will return a postive integer from manage.php
							if (data.trim() < 0){
								alert(data.trim());
							} else {

								$("#get_order_data").trigger("reset"); // this empty every field in the form after we have sent it to the data base

								// confirm if you want to print your invoice, if yes, send them to invoice_bill.php page to print
								if(confirm("DO you want to print invoice ?")){
									window.location.href = DOMAIN+"/includes/invoice_bill.php?invoice_no="+data+"&"+invoice; // we added the invoice variable so that it will take the form to the invoice_bill.php page and remember the question mark at the end of the link
								}
							} // End of the if statement
							

						}
					})

				}

					

			});









});























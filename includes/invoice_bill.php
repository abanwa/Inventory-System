<?php
session_start();
// we downloaded a php library (fpdf) to print the invoice and now we are going to call it also check "php fpdf cell"

include_once("../fpdf/fpdf.php");
// we get the ordre_date and invoice_no from the manage.php which was sent to order.js before coming here throuth the location.href link
if ($_GET["order_date"] && $_GET["invoice_no"]){
	//echo "OK";
	// create an instance of the class FPDF
	$pdf = new FPDF();
	$pdf->AddPage();

	// we set the font-family,font-size and font-weight to "Ariel","B","16" for bold
	$pdf->SetFont("Arial","B",16);

	// we set the invoice width4rmLeft,height,name,border,new line,to align to "190","10","Inventory Management System",1,1,Center
	$pdf->Cell(190,10,"Inventory Management System",0,1,"C"); // 1 for new line, 0 for same line

//column starts here
	$pdf->SetFont("Arial",null,12); // we want to change the font-weight for the thing below
	$pdf->Cell(50,10,"Date",0,0); // width from left is 40, no border and same line
	$pdf->Cell(50,10,": ".$_GET["order_date"],0,1);// after this, go to a new line that's why it changed to 1
	$pdf->Cell(50,10,"Customer Name",0,0);
	$pdf->Cell(50,10,": ".$_GET["cust_name"],0,1); // get the customer name from neww_order.php page. after this, go to new line

	$pdf->Cell(50,10,"",0,1); // gives us a gap

// WE created a Table here. Starting with table headings and they all have border 1 and centered
	$pdf->Cell(10,10,"#",1,0,"C");
	$pdf->Cell(70,10,"Product Name",1,0,"C");
	$pdf->Cell(30,10,"Quantity",1,0,"C");
	$pdf->Cell(40,10,"Price",1,0,"C");
	$pdf->Cell(40,10,"Total (NGN)",1,1,"C");

	// loop to get all the records of the products the customer bought
	for ($i = 0; $i < count($_GET["pid"]); $i++){
		$pdf->Cell(10,10, ($i+1),1,0,"C");
		$pdf->Cell(70,10, $_GET["pro_name"][$i],1,0,"C");
		$pdf->Cell(30,10, $_GET["qty"][$i],1,0,"C");
		$pdf->Cell(40,10, $_GET["price"][$i],1,0,"C");
		$pdf->Cell(40,10, ($_GET["qty"][$i] * $_GET["price"][$i]),1,1,"C");
	}

	$pdf->Cell(70,10,"",0,1,);

	// for the sub invoice
	$pdf->Cell(50,10,"Sub Total",0,0,);
	$pdf->Cell(50,10,": ".$_GET["sub_total"],0,1);
	$pdf->Cell(50,10,"Gst Tax",0,0);
	$pdf->Cell(50,10,": ".$_GET["gst"],0,1);
	$pdf->Cell(50,10,"Discount",0,0);
	$pdf->Cell(50,10,": ".$_GET["discount"],0,1);
	$pdf->Cell(50,10,"Net Total",0,0);
	$pdf->Cell(50,10,": ".$_GET["net_total"],0,1);
	$pdf->Cell(50,10,"Paid",0,0);
	$pdf->Cell(50,10,": ".$_GET["paid"],0,1);
	$pdf->Cell(50,10,"Due Amount",0,0);
	$pdf->Cell(50,10,": ".$_GET["due"],0,1);
	$pdf->Cell(50,10,"Payment Type",0,0);
	$pdf->Cell(50,10,": ".$_GET["payment_type"],0,1);


	$pdf->Cell(180,10,"Signature",0,0,"R");

	// this is to download the invoice or print or save to server depending on what we choose either D,I,F
	$pdf->Output("../PDF_INVOICE/PDF_INVOICE_".$_GET["invoice_no"].".pdf","F"); //F,I,D for save to server, print and download. to know the admin that print the invoice, we get the invoice ni from the one we posted above

	$pdf->Output();

}


?>
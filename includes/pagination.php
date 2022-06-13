<?php
// for our record pages
$conn = new mysqli("localhost","root","","admin");

		// pagination function
function pagination($conn,$table,$pno,$n){
	//$totalRecords = 100000; i want to get the records from database. $row and $totalRecords is the same.
	$sql = ("SELECT count(*) as row FROM ".$table);

		$result = mysqli_query($conn, $sql);
		if ($result === FALSE) {
		  die(mysqli_error($conn));
		}


	$row = mysqli_fetch_assoc($result);

	$pageno = $pno;
	$numberOfRecordsPerPage = $n;

	$lastPage = ceil($row["row"]/$numberOfRecordsPerPage); // round up to higher value. this'll give us no of pages

	echo "Total Pages ".$lastPage."</br>";

	$pagination = "";

	if ($lastPage != 1){
		if ($pageno > 1){
			$previous = "";
			$previous = $pageno - 1;
			$pagination .= "<a href='pagination.php?pageno=" .$previous. "' style='color:#333;'> Previous </a>";
		}
		// for the first if. i want it to start from 5pages before the current page
		for ($i = $pageno - 5; $i < $pageno; $i++){
			if ($i > 0){
				//list of pages	before current page		
				$pagination .= "<a href='pagination.php?pageno=".$i."'> ".$i." </a>";
			}
		
		}

		//current page
		$pagination .= "<a href='pagination.php?pageno=".$pageno."' style='color:#333;'> $pageno </a>";

		for ($i = $pageno + 1; $i <= $lastPage; $i++){
			// list of pages after the current page
			$pagination .= "<a href='pagination.php?pageno=" .$i. "'> ".$i." </a>";
			if ($i > $pageno + 4){
				break;
			}
		}

		if ($lastPage > $pageno){
			$next = $pageno + 1;
			$pagination .= "<a href='pagination.php?pageno=".$next."' style='color:#333;'> Next </a>";
		}
	}
	//num of records to display on each pages
	// LIMIT 0,10
	// LIMIT 20,10
	$limit = "LIMIT ".($pageno - 1) * $numberOfRecordsPerPage.",".$numberOfRecordsPerPage;

	return ["pagination"=>$pagination,"limit"=>$limit];


} // pagination function Ends Here



// To get any page clicked
if (isset($_GET["pageno"])){
	$pageno = $_GET["pageno"];

	$table = "category";

	$array = pagination($conn,$table,$pageno,10);

	$sql = "SELECT * FROM ".$table." ".$array["limit"];

	//$result = $conn->query($sql);
	$result = mysqli_query($conn, $sql);
		if ($result === FALSE) {
		  die(mysqli_error($conn));
		}

	while ($row = mysqli_fetch_assoc($result)){
		echo "<div style='margin: 0 auto; font-size: 20px;'><b>".$row["categoryId"]."</b> ".$row["categoryTitle"]."</div>";
	}
	echo "<div style='font-size: 22px;'>".$array["pagination"]."</div>";
}


?>


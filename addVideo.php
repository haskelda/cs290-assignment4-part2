<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'WARNING_VIRUS.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "haskelda-db", $myPassword, "haskelda-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
} else {
	//echo "Successfully connected to haskelda-db<br>";	
}
/*

echo "addVideo.php<br>";

if ($_POST != NULL) {
	var_dump ($_POST);
}
*/
$title = $_POST['title'];
$category = $_POST['category'];
if ($_POST['length'] == "") { // if nothing entered
	$length = NULL;
} else {
	$length = $_POST['length'] + 0; // cast to integer
}

// Data validation - title is required field
if ($_POST['title'] == "") {
	echo 'Title is a required field.<br>';
	echo '<a href="davidsvideoshoppe.php"> Return </a>';
	exit;
}


// Data validatiom - length must be positive integer
if ($length != NULL) {
	if (!is_int($length) || $length < 1) {  // 
		echo 'Length needs to be a positive integer.<br>';
		echo '<a href="davidsvideoshoppe.php"> Return </a>';
		exit;
	}
}





// User data is valid - add video to DB
		if (!($stmt = $mysqli->prepare("INSERT INTO videoshoppe (name, category, length) VALUES (?,?,?);"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("ssi", $title, $category, $length)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    //echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    if ($mysqli->errno == 1062) {
		    	echo "Duplicate entry. Try again<br>";
		    	echo '<a href="davidsvideoshoppe.php"> Return </a>';
		    }
		    exit;
		}
		//echo'video added';



$stmt->close();
header('Location: http://web.engr.oregonstate.edu/~haskelda/cs290/Assns/Assn4-2/davidsvideoshoppe.php');
?>

<!--<a href="davidsvideoshoppe.php"> Return </a>
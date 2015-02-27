<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'WARNING_VIRUS.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "haskelda-db", $myPassword, "haskelda-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
} else {
	echo "Successfully connected to haskelda-db<br>";	
}

echo "clearInventory.php<br>";

if ($_POST != NULL) {
	var_dump ($_POST);
}
























$stmt->close();
header('Location: http://web.engr.oregonstate.edu/~haskelda/cs290/Assns/Assn4-2/davidsvideoshoppe.php');
?>

<a href="davidsvideoshoppe.php"> Return </a>
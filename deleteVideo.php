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
echo "deleteVideo.php<br>";

if ($_POST != NULL) {
	var_dump ($_POST);
}
*/
$video_id = $_POST['video_id'];

		if (!($stmt = $mysqli->prepare("DELETE FROM videoshoppe WHERE id = ?"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("i", $video_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

$stmt->close();
header('Location: http://web.engr.oregonstate.edu/~haskelda/cs290/Assns/Assn4-2/davidsvideoshoppe.php');
?>

<!--<a href="davidsvideoshoppe.php"> Return </a>
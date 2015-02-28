<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'WARNING_VIRUS.php'; // Don't eve THINK of opening this file for any reason....

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "haskelda-db", $myPassword, "haskelda-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
} else {
	//echo "Successfully connected to haskelda-db<br>";
}
/*
if ($_POST != NULL) {
	var_dump ($_POST);
}
*/
?>

<!DOCTYPE html>

<!-- Text fiekds and submit button for adding videos -->
<form action="addVideo.php" method="POST">
	<title>David's Video Shoppe</title>
	<center>
	<h1>David's Video Shoppe</h1>
	<p>To add an video to the inventory, enter the relevent info, and click on "Add Video" below</p>
	Title: <input type="text" name="title"><br>
	Category: <input type ="text" name="category"><br>
	Length: <input type ="text" name="length"><br>
	<br>
	<input type="submit" value = "Add Video"><br>
</form>
<br>

<!-- Table of Video INventory -->
	<table border='1'>
	<caption> Video Inventory </caption>
	<tr>
	<th>Name
	<th>Category
	<th>Length
	<th>Status
	<th>Action
	<th>Delete
<?php
//  gets table rows from DB
// "All Movies" / Default
if ($_POST == NULL || (isset($_POST['selectCategory']) && $_POST['selectCategory'] == "All Movies")) {
	//if (1) {
		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoshoppe ORDER BY name"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
} else { 
// gets table rows from DB
// User selected categories - $_POST['selectCategory'] is set to anything other than "All Movies"
		$category = $_POST['selectCategory'];

		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoshoppe WHERE category = ? ORDER BY name"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("s", $category)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
}// end else
// fills table rows from DB
		$out_id = NULL;
		$out_name = NULL;
		$out_category = NULL;
		$out_length = NULL;
		$out_rented = NULL;

		if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$out_name" . '</td>
		    	  	<td>' . "$out_category" . '</td>
		    	 	<td>' . "$out_length" . '</td>
		    	 	<form action="videoStatus.php" method="POST">';
		    	 	if ($out_rented == 0) {
		    	 		echo '<td>Available</td>
		    	 			<td>
		    	 			<input type="hidden" name="video_id" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Check Out">
					  		</td>';
		    	  	} else {
						echo '<td>Rented</td>
							<td>
							<input type="hidden" name="video_id" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Return">
							</td>';
					}
					echo '
					</form>
					<form action="deleteVideo.php" method="POST">
					<td>
					
					 <input type="hidden" name="video_id" value="' . "$out_id" . '">
					 <input type="submit" value="X">
					 
					 </td>
					 </form>
				</tr>';
		}
?>
	</table>
	<br>


<!--Drop down menu for Select Category Filter-->
	<form action="davidsvideoshoppe.php" method="POST">
	Select Category: 
	<select name="selectCategory"> 
	<option value="All Movies">All Movies</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT category FROM videoshoppe WHERE category != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_category = NULL;

		if (!$stmt->bind_result($out_category)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		//if ($out_category != NULL) {
		//	echo '			<option value="All Movies">All Movies</option>'; // Default
		//}
		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_category" . '">' . "$out_category" . '</option>';
		}

		//var_dump ($out_category);
?>
	</select>
	<input type="submit" value = "Filter Results"/><br>
	</form>
	<br>


<!-- Delete All Videos Button -->
	<form action="clearInventory.php" method="POST">
	Clear Inventory: 
	<input type="submit" value = "Delete All Videos"/><br>
	</form>
	</center>
</body>
</html>

<?php
$stmt->close();
?>

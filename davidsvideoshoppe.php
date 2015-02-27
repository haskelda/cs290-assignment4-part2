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

if ($_POST != NULL) {
	var_dump ($_POST);
}

?>

<!DOCTYPE html>

<form action="davidsvideoshoppe.php" method="POST">
	<title>David's Video Shoppe</title>
	<center>
	<h1>David's Video Shoppe</h1>
	
	<p>To add an video to the inventory, enter the relevent info, and click on "Add Video" below</p>
	Title: <input type="text" name="title"><br>
	Category: <input type ="text" name="category"><br>
	Length: <input type ="text" name="length"><br>
	<br>
	<input type="submit" name="addVideo" value = "Add Video"><br>
	
</form>
<br>
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
// fills table rows from DB
// All Categories / Default
if ($_POST == NULL || ($_POST != NULL && $_POST['selectCategory'] != NULL)) {
	if ($_POST['selectCategory'] == "All Movies") {
		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoshoppe"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

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
		    	 	<td>' . "$out_length" . '</td>';
		    	 	if ($out_rented == 0) {
		    	 		echo '<td>Available</td>
		    	 			<td>
					  		<input type="submit" name="status" value="Check Out">
					  		</td>';
		    	  	} else {
						echo '<td>Rented</td>
							<td>
					  		<input type="submit" name="status" value="Return">
							</td>';
					}
					echo '<td>
					  	<input type="hidden" name="delete_id" value="' . "$out_id" . '">
					  	<input type="submit" name="deleteVideo" value="X">
					 	 </td>
				</tr>';
		}
	} else { // $_POST['selectCategory'] is set to anything other than "All Movies"

// fills table rows from DB
// User selected categories
		$category = $_POST['selectCategory'];

		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoshoppe WHERE category = ?"))) {
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
		    	 	<td>' . "$out_length" . '</td>';
		    	 	if ($out_rented == 0) {
		    	 		echo '<td>Available</td>
		    	 			<td>
					  		<input type="submit" name="status" value="Check Out">
					  		</td>';
		    	  	} else {
						echo '<td>Rented</td>
							<td>
					  		<input type="submit" name="status" value="Return">
							</td>';
					}
					echo '<td>
					  	<input type="hidden" name="delete_id" value="' . "$out_id" . '">
					  	<input type="submit" name="deleteVideo" value="X">
					 	 </td>
				</tr>';
		}
	}// end else
} 
?>
	</table>

	<br>
	<!--Populate drop down menu from DB for Select Category Filter-->
	Select Category: 
	<select name="selectCategory"> 
		<option value="All Movies">All Movies</option> <!-- Default -->
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT category FROM videoshoppe"))) {
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
		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_category" . '">' . "$out_category" . '</option>';
		}
		
?>
	</select>
	<input type="submit" value = "Filter Results"/><br>
	<br><br>
	Clear Inventory: 
	<input type="submit" name = "clear" value = "Delete All Videos"/><br>
	</center>
</body>
</html>

<?php 

// This page is for deleting an artist record.
// This page is accessed through view_artists.php.

session_start(); // Accessing the existing session.

$page_title = 'Delete a Musician';
include ('../../includes/header.html');

echo '<h1>Delete an Musician</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('../../includes/footer.html'); 
	exit();
}

require_once ('../../mysqli_connect.php');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM esod_artists WHERE pk_artistid=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Print a message:
			echo '<p><strong>The artist has been deleted.</strong></p>';	
		
		} else { // If the query did not run OK.
			echo '<p class="error">The artist could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p><strong>The artist has NOT been deleted.</strong></p>';	
	}

} else { // Show the form.

	// Retrieve the artist's information:
	$q = "SELECT artist FROM esod_artists WHERE pk_artistid=$id";
	$r = @mysqli_query ($dbc, $q);
	
	if (mysqli_num_rows($r) == 1) { // Valid artist ID, show the form.

		// Get the artist's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Create the form:
		echo '<form action="delete_musician.php" method="post">
	<h3>Name: ' . $row[0] . '</h3>
	<p>Are you sure you want to delete this artist?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="id" value="' . $id . '" />
	</form>';
	
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.
		
include ('../../includes/footer.html');
?>

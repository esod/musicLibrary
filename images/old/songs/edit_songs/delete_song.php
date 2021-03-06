<?php 

// This page is for deleting a song.
// This page is accessed through /songs/edit_songs.php.

session_start(); // Accessing the existing session.

$page_title = 'Delete an Song';
include ('../../includes/header.html');
echo '<h1>Delete a Song</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From index.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('../../includes/footer.html'); 
	exit();
}

require_once ('../../../mysqli_connect.php');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM esod_songs WHERE pk_songid=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Print a message:
			echo '<p><strong>The song has been deleted.</strong></p>';	
		
		} else { // If the query did not run OK.
			echo '<p class="error">The song could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p><strong>The song has NOT been deleted.</strong></p>';	
	}

} else { // Show the form.

	// Retrieve the song's information:
	$q = "SELECT song FROM esod_songs WHERE pk_songid=$id";
	$r = @mysqli_query ($dbc, $q);
	
	if (mysqli_num_rows($r) == 1) { // Valid album ID, show the form.

		// Get the album's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Create the form:
		echo '<form action="delete_song.php" method="post">
	<h3>Name: ' . $row[0] . '</h3>
	<p>Are you sure you want to delete this song?<br />
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

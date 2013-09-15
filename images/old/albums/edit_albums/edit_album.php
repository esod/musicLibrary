<?php 

// This page is for editing an album record.
// This page is accessed through albums/index.php.

session_start(); // Accessing the existing session.

$page_title = 'Edit the Album';
include ('../../includes/header.html');

echo '<h1>Edit the Album</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From albums/index.php
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

	$errors = array();
	
	// Check for the album's name:
	if (empty($_POST['album'])) {
		$errors[] = 'You forgot to enter the album\'s name.';
	} else {
		$a = mysqli_real_escape_string($dbc, trim($_POST['album']));
	}
		
	if (empty($errors)) { // If everything's OK.
	
			// Make the query:
			$q = "UPDATE esod_albums SET album='$a' WHERE pk_albumid=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 0) { // No edits were made.
			
				// Print a message:
				echo '<p><strong>No edits were made.</strong></p>';	
				
			} elseif (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message:
				echo '<p><strong>The album has been edited.</strong></p>';	
							
			} else { // If it did not run OK.
				echo '<p class="error">The album could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
		
	} else { // Report the errors.
	
		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
		
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Always show the form...

// Retrieve the album's information:
$q = "SELECT album FROM esod_albums WHERE pk_albumid=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:
	echo '<form action="edit_album.php" method="post">
<p>Album: <input type="text" name="album" size="75" maxlength="150" value="' . $row[0] . '" /></p>
<p><input type="submit" name="submit" value="Submit" /></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
</form>';

} else { // Not a valid pkalbum_id.
	echo '<p class="error">This page has been accessed in error.</p>';
}
	
include ('../../includes/footer.html');
?>

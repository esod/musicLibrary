<?php 

// This page is for editing an artists record.
// This page is accessed through view_artists.php.

session_start(); // Accessing the existing session.

$page_title = 'Edit the Musician';
include ('../../includes/header.html');

echo '<h1>Edit the Musician</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_artists.php
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
	
	// Check for a artist's name:
	if (empty($_POST['artist'])) {
		$errors[] = 'You forgot to enter the artist\'s name.';
	} else {
		$a = mysqli_real_escape_string($dbc, trim($_POST['artist']));
	}
		
	if (empty($errors)) { // If everything's OK.
	
			// Make the query:
			$q = "UPDATE esod_artists SET artist='$a' WHERE pk_artistid=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 0) { // No edits were made.
			
				// Print a message:
				echo '<p><strong>No edits were made.</strong></p>';	
				
			} elseif (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message:
				echo '<p><strong>The artist has been edited.</strong></p>';	
							
			} else { // If it did not run OK.
				echo '<p class="error">The artist could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

// Retrieve the artist's information:
$q = "SELECT artist FROM esod_artists WHERE pk_artistid=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:
	echo '<form action="edit_musician.php" method="post">
<p>Artist: <input type="text" name="artist" size="20" maxlength="40" value="' . $row[0] . '" /></p>
<p><input type="submit" name="submit" value="Submit" /></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
</form>';

} else { // Not a valid pkartist_id.
	echo '<p class="error">This page has been accessed in error.</p>';
}
		
include ('../../includes/footer.html');
?>

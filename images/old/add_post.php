<?php 
define ('TITLE', 'Add a Message');
require('templates/header.html');

// This script adds a message from the message board.

//include the database connection info
require_once("db.php");

//connect to database
$cxn = @ConnectToDb($dbServer, $dbUser, $dbPass, $dbName);

if (isset($_POST['submitted'])) { // Handle the form.

	// Validate the form data:
	$problem = FALSE;
	if (!empty($_POST['author']) && !empty($_POST['title'])) {
		$author = mysql_real_escape_string(trim($_POST['author']));
		$title = mysql_real_escape_string(trim($_POST['title']));
		$body = mysql_real_escape_string(trim($_POST['body']));

	} else {
		print '<p style="color: red;">Please submit both an author and a title.</p>';
		$problem = TRUE;
	}

	if (!$problem) {

		// Define the query:
		$query = "INSERT INTO esod_messages (id, author, title, body, created) VALUES (0, '$author', '$title', '$body', NOW())";
		

		
		// Execute the query:
		if (@mysql_query($query)) {
			print '<p>The message has been added!</p>';
		} else {
			print '<p style="color: red;">Could not add the entry because:<br />' . mysql_error() . '.</p><p>The query being run was: ' . $query . '</p>';
		}
	
	} // No problem!

	mysql_close();
	
	// Check for an uploaded file:
	if (isset($_FILES['upload'])) {
		
		// Validate the type. Should be JPEG or PNG.	
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
		if (in_array($_FILES['upload']['type'], $allowed)) {
		
			// Move the file over.
			if (move_uploaded_file ($_FILES['upload']['tmp_name'], "../uploads/{$_FILES['upload']['name']}")) {
				echo '<p><em>The file has been uploaded!</em></p>';
			} // End of move... IF.
			
		} else { // Invalid type.
			echo '<p class="error">Please upload a JPEG or PNG image.</p>';			
		}

	} // End of isset($_FILES['upload']) IF.
	
	// Check for an error:
	if ($_FILES['upload']['error'] > 0) {
	
		// Print a message based upon the error:
		switch ($_FILES['upload']['error']) {
			case 1:
				print '<p style="color: red;">Your file could not be uploaded because: The file exceeds the upload_max_filesize setting in php.ini';
				break;
			case 2:
				print '<p style="color: red;">Your file could not be uploaded because: The file exceeds the MAX_FILE_SIZE setting in the HTML form';
				break;
			case 3:
				print '<p style="color: red;">Your file could not be uploaded because: The file was only partially uploaded';
				break;
			case 4 and (empty($_POST['upload'])):
				print '';
				break;
			case 4:
				print '<p style="color: red;">Your file could not be uploaded because: No file was uploaded';
				break;
			case 6:
				print '<p style="color: red;">Your file could not be uploaded because: The temporary folder does not exist.';
				break;
			default:
				print '<p style="color: red;">Your file could not be uploaded because: Something unforeseen happened.';
				break;
		}
		
		print '.</p>'; // Complete the paragraph.

	} // End of error IF.
	
	// Delete the file if it still exists:
	if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
		unlink ($_FILES['upload']['tmp_name']);
	}

} // End of form conditional.
// Leave PHP and display the form:

?>
<form action="add_post.php" enctype="multipart/form-data" method="post">
	<p>Author: <input type="text" name="author" size="40" maxsize="100" /></p>
	<p>Title: <input type="text" name="title" size="40" maxsize="100" /></p>
			<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
			<p>Please select a JPEG or PNG image of 512KB or smaller to be uploaded:</p>
		<p>File: <input type="file" name="upload" /></p>
	<p>Message: <textarea name="body" cols="40" rows="5"></textarea></p>
	<input type="submit" name="submit" value="Add This Message!" />
	<input type="hidden" name="submitted" value="true" />
</form>


<?php 
require('templates/footer.html'); // Include the footer.
?>
<?php // This page lets a user change their password.

session_start(); // Start the session.

$page_title = 'Change Your Password';
include ('includes/header.php');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

//Connect to the database:
require_once('../musiclibrary_connect.php');
		
	$errors = array(); // Initialize an error array.
	
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	// Check for the current password:
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}

	// Check for a new password and match 
	// against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Check that they've entered the right email address/password combination:
		$q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA1('$p') )";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		if ($num == 1) { // Match was made.
		
			// Get the user_id:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);

			// Make the UPDATE query:
			$q = "UPDATE users SET pass=SHA1('$np') WHERE user_id=$row[0]";		
			$r = @mysqli_query($dbc, $q);
			
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message.
				echo '<h1>Thank you!</h1>
				<p class="try_again">Your password has been updated.</p><p><br /></p>';	
			
			} else { // If it did not run OK.
			
				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
				
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
				
			}

			// Include the footer and quit the script (to not show the form).
			include ('includes/footer_login.php'); 
			exit();
				
		} else { // Invalid email address/password combination.
			echo '<h1>Error!</h1>
			<p class="error">The email address and password do not match those on file.</p>';
		}
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
		
} // End of the main Submit conditional.
?>
<h1>Change Your Password</h1>
<form action="password.php" method="post">
	<p><label>Email Address:</label><input type="text" name="email" class="pass_word" size="25" maxlength="100" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></p>
	<p><label>Current Password:</label><input type="password" name="pass"  class="pass_word" size="10" maxlength="20" /></p>
	<p><label>New Password:</label><input type="password" name="pass1"  class="pass_word" size="10" maxlength="20" /></p>
	<p><label>Confirm New Password:</label><input type="password" name="pass2"  class="pass_word" size="10" maxlength="20" /></p>
	<input class="buton" type="submit" name="submit" value="Change Password" /><br />
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
// A workaround. Please revisit. es 11.23.2009
require_once ('../musiclibrary_connect.php');
include ('includes/footer_login.php');
?>

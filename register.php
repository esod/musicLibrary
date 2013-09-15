<?php // This page lets the user register.

$page_title = 'Register';
include ('includes/header.php');

if (isset($_POST['submitted'])) { // Handle the form.

	//Connect to the database:
	require_once('../musiclibrary_connect.php');

	//Connect to the login_functions.inc:
	require_once ('includes/login_functions.inc.php');
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);
	
	// Assume invalid values:
	$fn = $ln = $e = $p = FALSE;

	$errors = array(); // Initialize an error array.
	
	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
		}
	elseif (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
	} else {
		$errors[] = 'First names can contain only letters, a period, an apostrophe, a space, and the dash.';
	}
	
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
		}
	elseif (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
	} else {
		$errors[] = 'Last names can contain only letters, a period, an apostrophe, a space, and the dash.';
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
		}
	elseif (preg_match ('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/', $trimmed['email'])) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		$errors[] = 'The email address you entered is not valid.';
	}
			// Make sure the email address is not already in use:
			$q = "SELECT user_id FROM users WHERE email='$e'";		
			$r = @mysqli_query ($dbc, $q); 
				$row_cnt = mysqli_num_rows($r);
				if ($row_cnt > 0) {
				$errors[] = 'The email address you entered is not unique.';	
				}
	
	
	// Check for a password and match against the confirmed password:
	if (empty($_POST['pass1'])) {
		$errors[] = 'You forgot to enter your password.';
		}
		elseif ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		}
		elseif (preg_match ('/^\w{4,20}$/', $trimmed['pass1']) ) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['pass1']);
	} else {
			$errors[] = 'The password must be between 4 and 20 characters long and contain only letters, numbers, and the underscore.';
		}

	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW())";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass1']);
					
			// Set the session data:.
			session_start();
			$_SESSION['user_id'] = $data['user_id'];
			$_SESSION['first_name'] = $data['first_name'];

			// Store the HTTP_USER_AGENT:
			$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				
			// Redirect:
			$url = absolute_url ('musicians.php');
			header("Location: $url");
			exit(); 
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer_login.php'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p class="try_again">Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<p><label>First Name:</label><input type="text" name="first_name" class="register_form" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
	<p><label>Last Name:</label><input type="text" name="last_name" class="register_form" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p><label>Email Address:</label><input type="text" name="email" class="register_form" size="20" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	<p><label>Password:</label><input type="password" name="pass1" class="register_form" size="10" maxlength="20" /></p>
	<p><label>Confirm Password:</label><input type="password" name="pass2" class="register_form" size="10" maxlength="20" /></p>
	<input class="buton" type="submit" name="submit" value="Register" /><br />
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
include ('includes/footer_login.php');
?>

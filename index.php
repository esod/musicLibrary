<?php 

// This page checks the dbc, posted email, posted password.
// This page sets the cookies.

if (isset($_POST['submitted'])) {

	require_once ('../musiclibrary_connect.php');
	require_once ('includes/login_functions.inc.php');
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);
	
	if ($check) { // OK!
			
		// Set the session data:.
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];

		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				
		// Redirect:
		$url = absolute_url ('musicians.php');
		header("Location: $url");
		exit(); 
			
	} else { // Unsuccessful!
		$errors = $data;
	}
		
	mysqli_close($dbc);

} // End of the main submit conditional.

include ('includes/login_page.inc.php');
?>

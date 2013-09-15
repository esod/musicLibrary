<?php 

// Redirect visitors to /portfolio/index.php
// .htacces should be able to do this. Please revisit
function requireLogin() {

	if (!isset($_SESSION['password'])) {

		$_SESSION = array(); // Clear the variables.
		session_destroy(); // Destroy the session itself.
		setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

		$url = 'http://themightybyte.com/portfolio';
		header("Location: $url");
		exit(); // Quit the script.
	}
}
	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

?>
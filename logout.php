<?php // This page lets the user logout.

// If no session value is present, redirect the user:

session_start(); // Accessing the existing session.

if (!isset($_SESSION['user_id'])) {

	// Need the functions to create an absolute URL:
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit(); // Quit the script.
	
} else { // Cancel the session.

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}

// Set the page title and include the PHP header:
$page_title = 'Logged Out!';
include ('includes/header.php');

// Print a customized message:
echo "<h1>Logged Out!</h1>
<form><p><label>You are now logged out!</label></p></form>";

include ('includes/footer_login.php');
?>

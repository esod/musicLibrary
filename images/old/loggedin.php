<?php 

// The user is redirected here from login.php.

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();	
}
// Set the page title and include the HTML header:
$page_title = 'Logged In!';
include ('includes/header.html');

// Print a customized message:
echo "<h1>Logged In!</h1>
<p>Welcome {$_SESSION['first_name']}, you are now logged in!</p>
<p><a href=\"logout.php\">Logout</a></p>";

	require_once ('../mysqli_connect.php');
include ('includes/footer_login.html');
?>

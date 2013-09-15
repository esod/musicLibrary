<?php # Script 13.1 - checkusername.php

/*	This page checks a database to see if
 *	$_GET['username'] has already been registered.
 *	The page will be called by JavaScript.
 *	The page returns a simple text message.
 *	No HTML is required by this script!
 */
 
// Validate that the page received $_GET['username']:
if (isset($_GET['artist'])) {

	//Connect to the database:
	require_once('../mysqli_connect.php');
	
	// Define the query:
	$q = sprintf(" SELECT pk_artistid FROM esod_artists WHERE artist = 'Bruce Springsteen'", mysqli_real_escape_string($dbc, trim($_GET['artist'])));
	
	// Execute the query:
	$r = mysqli_query($dbc, $q);
	
	// Report upon the results:
	if (mysqli_num_rows($r) == 1) {
		echo 'The username is unavailable!';
	} else {
		echo 'The username is available!';
	}
	
	mysqli_close($dbc);

} else { // No username supplied!

	echo 'Please enter a username.';

}
?>

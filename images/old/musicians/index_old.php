<?php 

// MUSICIANS INDEX. This script retrieves all the MUSICIANS from esod_artists table.
// This file goes into /musicians/

	//Connect to the database:
	require_once('../../mysqli_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

// Set variable for user based on session id
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];

$page_title = $first_name . '\'s musicLibrary';

// Determine the sort...
// Default is by artist.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'artist';

// Determine the sorting order:
switch ($sort) {
	case 'a':
		$order_by = 'artist ASC';
		break;
	default:
		$order_by = 'artist ASC';
		$sort = 'artist';
		break;
}

// Make the query:
$q = "SELECT artist, pk_artistid
FROM esod_artists
WHERE kf_artists_userid = $user_id
ORDER BY $order_by
";		
$r = @mysqli_query ($dbc, $q); // Run the query.
	
include ('../includes/header.php');

require_once("index_view.php");

include ('../includes/footer_login.php');
?>

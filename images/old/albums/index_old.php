<?php 

// ALBUMS INDEX. This script retrieves all the ALBUMS from esod_albums table.
// This file goes into /albums/

//Connect to the database:
require_once('../../mysqli_connect.php');

// If no session value is present, redirect the user:
require_once('../includes/login_functions.inc.php');

session_start(); // Accessing the existing session.

//require the user to be logged in
requireLogin();

$page_title = 'Albums';

// Determine the sort...
// Default is by album.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'album';

// Determine the sorting order:
switch ($sort) {
	case 'a':
		$order_by = 'album ASC';
		break;
	case 'y':
		$order_by = 'year ASC';
		break;
	default:
		$order_by = 'album ASC';
		$sort = 'album';
		break;
}
	
// Make the query:
$q = "SELECT cover, album, year, pk_albumid FROM esod_albums ORDER BY $order_by";		
$r = @mysqli_query ($dbc, $q); // Run the query.

include ('../includes/header.html');

require_once("index_view.php");

include ('../includes/footer_login.html');
?>

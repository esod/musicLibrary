<?php 

// SONGS INDEX. This script retrieves all the SONGS from esod_songs table.
// This file goes into /musicians/

//Connect to the database:
require_once('../../mysqli_connect.php');

// If no session value is present, redirect the user:
require_once('../includes/login_functions.inc.php');

session_start(); // Accessing the existing session.

//require the user to be logged in
requireLogin();

$page_title = 'Songs';

// Determine the sort...
// Default is by song.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'song';

// Determine the sorting order:
switch ($sort) {
	case 'tr':
		$order_by = 'track ASC';
		break;	
	case 's':
		$order_by = 'song ASC';
		break;	
	case 'ti':
		$order_by = 'time ASC';
		break;
	default:
		$order_by = 'song ASC';
		$sort = 'song';
		break;
}
	
// Make the query:
$q ="SELECT pk_songid, kf_artistid, pk_albumid, kf_albumid, track, song, time, album
FROM esod_songs
INNER JOIN esod_albums ON esod_songs.kf_albumid = esod_albums.pk_albumid
ORDER BY $order_by
";
$r = @mysqli_query ($dbc, $q); // Run the query.	

include ('../includes/header.html');

require_once("index_view.php");

include ('../includes/footer_login.html');
?>

<?php 

// SONGS INDEX. This script retrieves all the SONGS from esod_songs table.
// This file goes into /musicians/

// If no session value is present, redirect the user:

session_start(); // Accessing the existing session.

if (!isset($_SESSION['user_id'])) {

	// Need the functions to create an absolute URL:
	//require_once ('../includes/login_functions.inc.php');
	//$url = absolute_url();
	$url = 'http://onepotcooking.com/ericsod/final_project/';
	header("Location: $url");
	exit(); // Quit the script.
}

$page_title = 'Songs';
include ('../includes/header.html');

echo '<h1>Songs</h1>';

//Connect to the database:
require_once('../../mysqli_connect.php');

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
FROM esod_albums
INNER JOIN esod_songs ON esod_albums.pk_albumid = esod_songs.kf_albumid
ORDER BY esod_albums.album ASC
";

//"SELECT track, song, time, pk_songid, album FROM esod_songs ORDER BY $order_by";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if (mysqli_num_rows($r) > 0) { // Begin main conditional. "If" there are songs . . .

	//songs div. Begin float left
	echo '<div id="songs">';

	// Table header:
		echo '<table align="center" cellspacing="0" cellpadding="5" width="65%">
		<tr>
			<td align="left"><strong><a href="index.php?sort=tr">Track</strong></td>
			<td align="left"><strong><a href="index.php?sort=s">Song</strong></td>
			<td align="left"><strong><a href="index.php?sort=ti">Time</strong></td>
		</tr>
		';

	// Fetch and print all the records....
	$bg = '#eeeeee'; // variable for the ternary operator
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator
		echo '<tr bgcolor="' . $bg . '">
			<td align="left">' . $row['track'] . '</td>
			<td align="left">
			<a href="" onclick="playMusic("' . $row['album'] . '", "' . $row['song'] . '"); return false;">' . $row['song'] . '</td>		
			<td align="left">' . $row['time'] . '</td>
		</tr>
		';
		
	} // End of WHILE loop.
			echo '<div id="flashplayer"></div>';


		// end of musicians div and wn div
		echo '</table>';

		// end of songs div
		echo '</div>';
		
	// songs. float left
		echo '<div id="songs">';
		
 
		echo '</div>'; // end of songs div
		echo "\n";
		echo '<div class="clearfloat"></div>';
		
	} else { // End of main conditional. "If" there are no songs . . .
	echo '<p class="error">There are no songs, and the world is a smaller place.</p>';
	}	
	include ('../includes/footer_login.html');
?>

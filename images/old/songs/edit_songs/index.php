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

require_once ('../../mysqli_connect.php');

// Number of records to show per page:
$display = 30;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(pk_songid) FROM esod_songs";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

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
$q = "SELECT track,song, time, pk_songid FROM esod_songs ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if (mysqli_num_rows($r) > 0) { // There are users.

// Table header:
echo '<table align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
	<td align="left"><strong>Edit</strong></td>
	<td align="left"><strong>Delete</strong></td>
	<td align="left"><strong><a href="index.php?sort=tr">Track</strong></td>
	<td align="left"><strong><a href="index.php?sort=s">Song</strong></td>
	<td align="left"><strong><a href="index.php?sort=ti">Time</strong></td>

</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_songs/edit_song.php?id=' . $row['pk_songid'] . '">Edit</a></td>
		<td align="left"><a href="edit_songs/delete_song.php?id=' . $row['pk_songid'] . '">Delete</a></td>
		<td align="left">' . $row['track'] . '</td>
		<td align="left">' . $row['song'] . '</td>
		<td align="left">' . $row['time'] . '</td>
	</tr>
	';
} // End of WHILE loop.

echo '</table>';

//echo Pages('esod_artists','20','view_artists.php'); //Please revisit 11.17.2009

// This script is for page numbers.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="song.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="song.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="song.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.

} else { // There are no users.
echo '<p class="error">There are no songs, and the world is a smaller place.</p>';
}	
include ('../includes/footer.html');
?>

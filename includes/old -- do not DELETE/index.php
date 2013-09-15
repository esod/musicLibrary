<?php 

// MUSICIANS INDEX. This script retrieves all the MUSICIANS from esod_artists table.
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

$page_title = 'Musicians';
include ('../includes/header.html');

echo '<h1>Musicians</h1>';

//Connect to the database:
require_once('../../mysqli_connect.php');

// Number of records to show per page:
$display = 30;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(pk_artistid) FROM esod_artists";
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
$q = "SELECT artist, pk_artistid FROM esod_artists ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if (mysqli_num_rows($r) > 0) { // There are users.

//Musicians div. Begin float left
echo '<div id="musicians">';

// Table header:
echo '<table align="center" cellspacing="0" cellpadding="5" width="100%">
<tr>
	<td align="left"><strong><a href="index.php?sort=a">Artist</strong></strong></td>

</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href onclick="showAlbums(' . $row['pk_artistid'] . ')">' . $row['artist'] . '</a></td>
	</tr>
	';
} // End of WHILE loop.

?>
</table>
</div><!-- end of Musicians div -->

<!-- Artists. float left -->
<div id="artists">
<?php 
	//AJAX to view artist's albums (see files selectartist.php, getartist.php, select.js)
	include ('selectartist.php');
?>
</div><!-- end of Artists div -->

<!-- Albums. float left -->
<div id="albums">
<?php 
	//AJAX to view album's songs (see files selectalbum.php, getalbum.php, select.js)
	include ('selectalbum.php');

	//AJAX to play songs
	include ('swfobject_example.html');
	

?>
</div><!-- end of Artists div -->
<div class="clearfloat"></div>

<?php 

// This script is for page numbers.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="index.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="index.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="index.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.

} else { // There are no users.
echo '<p class="error">There are no artists, and the world is a smaller place.</p>';
}	

include ('../includes/footer_login.html');
?>

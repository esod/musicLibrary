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
include ('../includes/header.php');

				$first_name = $_SESSION['first_name'];
				if (isset($_SESSION['user_id'])) {
				echo "<h1>$first_name's musicLibrary!</h1>";				
				}
?>
	<!-- // albums. float left -->
	<div id="musicians_title">
		<strong>Musicians</strong>
	<div id="musicians">
		<!-- //AJAX to view artist's albums (see files getartist.php, select.js) -->
		<div id="MusiciansHint"></div>  <!-- // for AJAX. see select.js.function.albumChanged -->		
		</div>  <!-- // end of musicians div -->
		</div>  <!-- // end of musicians_title div -->

	<!-- // albums. float left -->
	<div id="albums_title">
		<strong>Albums</strong>
	<div id="albums">
		<!-- //AJAX to view artist's albums (see files getartist.php, select.js) -->
		<div id="AlbumHint"></div>  <!-- // for AJAX. see select.js.function.albumChanged -->		
		</div>  <!-- // end of albums div -->
		</div>  <!-- // end of albums_title div -->

	<!-- // songs. float left -->
	<div id="songs_title">
	<strong>Songs</strong>
	<div id="songs">
		<!-- //AJAX to view album's songs (see files getalbum.php, select.js) -->
			<div id="SongHint"></div>  <!-- // for AJAX. see select.js.function.songChanged -->
		</div>  <!-- // end of songs div -->
		</div>  <!-- // end of songs_title div -->

		<div class="clearfloat"></div>

	

	
<?php include ('../includes/footer_login.php'); ?>
	

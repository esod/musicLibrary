<?php 

/* 
 *	This is the search content module.
 *	This page is included by index.php.
 *	This page expects to receive $_GET['terms'].
 */

	//Connect to the database:
	require_once('../../musiclibrary_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

	// Set variable for user based on session id
	$user_id = $_SESSION['user_id'];	
	$terms = $_GET['terms'];
	
	$page_title = 'Search Results';
	include ('header.php');

				$first_name = $_SESSION['first_name'];
				if (isset($_SESSION['user_id'])) {
				echo "<h1>$first_name's musicLibrary!</h1>";				
				}


// Display the search results if the form
// has been submitted.
if (isset($_GET['terms']) )  : ?>

	<div id="musicians_title_ie"> <!-- accommodation for IE8 -->
		Musicians</div>
			<div id="musicians_title">
				<div id="musicians">

<?php

// Make the query:
$sql = "SELECT artist, pk_artistid, kf_artists_userid
FROM artists
WHERE MATCH (
artist, pk_artistid
)
AGAINST (
'+\"{$terms}\"'
IN BOOLEAN
MODE
) && kf_artists_userid = $user_id
ORDER BY creation_date DESC
";

	// Execute the query:
	$r = @mysqli_query ($dbc, $sql);

	if (mysqli_num_rows($r) > 0) : ?> <!-- // Begin main conditional. "If" there are musicians -->

		<!-- // Table header: -->
		<table width="100%">

		<!-- // Fetch and print all the records.... -->
		<?php $bg = '#ffffff'; // variable for the ternary operator ?>
		<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
			<?php $bg = ($bg=='#ffffff' ? '#eeeeee' : '#ffffff'); // the ternary operator ?>
			<tr bgcolor="<?php echo $bg ?>">
				<td>
					<a href="../includes/getalbums.php?q=<?php echo $row['pk_artistid'] ?>" 
						onclick="showAlbums(<?php echo $row['pk_artistid'] ?>); return false;"
					>
						<?php echo $row['artist'] ?>
					</a>
				</td>
			</tr>
		<?php endwhile // End of WHILE loop. ?>

		</table>
			
			<?php else : // End of main conditional. "If" there are no artists ?>
		<form><p class="error"><br />There are no musicians by that name in your musicLibrary.</p></form>
	<?php endif ?>	
	
		</div>  <!-- // end of musicians div -->
		</div>  <!-- // end of musicians_title div -->
		

	<!-- // albums. float left -->
	<div id="albums_title">
		Albums
			<div id="albums">
				<!-- //AJAX to view artist's albums (see files getartist.php, select.js) -->
				<div id="AlbumHint"></div>  <!-- // for AJAX. see select.js.function.albumChanged -->		
				</div>  <!-- // end of albums div -->
			</div>  <!-- // end of albums_title div -->

	<!-- // songs. float left -->
	<div id="songs_title">
		Songs
			<div id="songs">
				<!-- //AJAX to view album's songs (see files getalbum.php, select.js) -->
				<div id="SongHint"></div>  <!-- // for AJAX. see select.js.function.songChanged -->
				</div>  <!-- // end of songs div -->
			</div>  <!-- // end of songs_title div -->

		<div class="clearfloat"></div>
		

<?php endif ?>		

<?php include ('footer_login.php'); ?>

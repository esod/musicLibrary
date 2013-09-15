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

	if (mysqli_num_rows($r) > 0) : ?>
	<!-- // Begin main conditional. "If" there are artists -->

	<!-- //musicians div. Begin float left -->
	<div id="musicians_title">
	<strong>Musicians</strong>
	
	<div id="musicians">
		<!-- // Table header: -->
		<table width="100%">

		<!-- // Fetch and print all the records.... -->
		<?php $bg = '#eeeeee'; // variable for the ternary operator ?>
		<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
			<?php $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator ?>
			<tr bgcolor="<?php echo $bg ?>">
				<td>
					<a href="/ericsod/final_project/includes/getalbums.php?q=<?php echo $row['pk_artistid'] ?>" 
						onclick="showAlbums(<?php echo $row['pk_artistid'] ?>); return false;"
					>
						<?php echo $row['artist'] ?>
					</a>
				</td>
			</tr>
		<?php endwhile // End of WHILE loop. ?>

		</table>

	</div><!-- // end of musicians div -->
	</div><!-- // end of musicians_title div -->

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

	
	<?php else : // End of main conditional. "If" there are no artists ?>
		<form><p class="error"><br />Please contact the musicLibrary staff for your tunes.</p></form>
	<?php endif ?>
	
<?php include ('../includes/footer_login.php'); ?>
	

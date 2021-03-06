<?php 

// MUSICIANS INDEX. This script retrieves all the MUSICIANS from artists table.

	//Connect to the database:
	require_once('../musiclibrary_connect.php');
	require_once('includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

// Set variable for user based on session id
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];

// Validate what page to show:
if (isset($_GET['p'])) {
	$p = $_GET['p'];
} elseif (isset($_POST['p'])) { // Forms
	$p = $_POST['p'];
} else {
	$p = NULL;
}

// Determine what page to display:
switch ($p) {
	
	case 'search':
		$page = 'search.inc.php';
		break;
	
	// Default is to include the main page.
	default:
		$page = 'musicians.php';
		break;
		
} // End of main switch.

// Make sure the file exists:
if (!file_exists('./includes/' . $page)) {
	$page = 'musicians.php';
}

$page_title = $first_name . '\'s musicLibrary';
include ('includes/header.php');

				$first_name = $_SESSION['first_name'];
				if (isset($_SESSION['user_id'])) {
				echo "<h1>$first_name's musicLibrary!</h1>";				
				}
?>
	<div id="musicians_title_ie"> <!-- accommodation for IE8 -->
		Musicians</div>
			<div id="musicians_title">
				<div id="musicians">

<?php // Determine the sorting order:
$sort = '';
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
$q = "SELECT artist, pk_artistid, artist_loaded
FROM artists
WHERE kf_artists_userid = $user_id
ORDER BY $order_by
";		

	// Execute the query:
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) > 0) : ?> <!-- // Begin main conditional. "If" there are musicians -->

		<!-- // Table header: -->
		<table width="100%">

		<!-- // Fetch and print all the records.... -->
		<?php $bg = '#ffffff'; // variable for the ternary operator ?>
		<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
			<?php $bg = ($bg=='#ffffff' ? '#eeeeee' : '#ffffff'); // the ternary operator ?>
			<tr bgcolor="<?php echo $bg ?>">
				<td>
					<div class="highlight<?php if ($row['artist_loaded'] == 1) : ?>_bold<?php endif ?>">
					<a href="../includes/getalbums.php?q=<?php echo $row['pk_artistid'] ?>" 
						onclick="showAlbums(<?php echo $row['pk_artistid'] ?>); return false;"
					>
						<?php echo $row['artist'] ?>
					</a></div>
				</td>
			</tr>
		<?php endwhile // End of WHILE loop. ?>

		</table>
	
	<?php else : // End of main conditional. "If" there are no artists ?>
		<form><p class="error"><br />Please contact the musicLibrary staff for your tunes.</p></form>
	<?php endif ?>
	
<?php 
mysqli_close($dbc);
?>				
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

<?php include ('includes/footer_login.php'); ?>

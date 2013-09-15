<?php 
$q=$_GET["q"];

	//Connect to the database:
	require_once('../../musiclibrary_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();
	
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
		$order_by = 'year DESC';
		$sort = 'year';
		break;
}	

// Set variable for user based on session id
$user_id = $_SESSION['user_id'];

	// Define the query:
	$sql="SELECT cover, CONCAT( album, ' (', year, ') ' ) AS album, pk_albumid, album_loaded 
FROM artists
INNER JOIN albums ON artists.pk_artistid = albums.kf_artistid
WHERE artists.pk_artistid = ".$q." && artists.kf_artists_userid = $user_id
ORDER BY $order_by
";
	
	// Execute the query:
	$r = mysqli_query($dbc, $sql);
	
if (mysqli_num_rows($r) >0) : // Begin main conditional. "If" there are albums . . . ?>

	<!-- // Table header: -->
	<table>

	<!-- // Fetch and print all the records.... -->
	<?php $bg = '#ffffff'; // variable for the ternary operator ?>
	<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
		<?php $bg = ($bg=='#ffffff' ? '#eeeeee' : '#ffffff'); // the ternary operator ?>
		<tr bgcolor="<?php echo $bg ?>">
			<td>
			<img src="<?php echo $row['cover'] ?>"></td>
			<td width="153">
			<div class="highlight<?php if ($row['album_loaded'] == 1) : ?>_bold<?php endif ?>">
			<a href="../includes/getsongs.php?q=<?php echo $row['pk_albumid'] ?>" onclick="showSongs(<?php echo $row['pk_albumid'] ?>); return false;">
			<?php echo $row['album'] ?>
			</a></td></div>
		</tr>
		<?php endwhile // End of WHILE loop. ?>
		</table>
		
	<?php else : // End of main conditional. "If" there are no songs . . . ?>
	<p class="error">There are no songs, and the world is a smaller place.</p>
	<?php endif ?>

<?php 
mysqli_close($dbc);
?> 

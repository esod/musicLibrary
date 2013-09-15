<?php 
$q=$_GET["q"];

	//Connect to the database:
	require_once('../../mysqli_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

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

	// Execute the query:
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) > 0) : ?> <!-- // Begin main conditional. "If" there are musicians -->

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
	
	<?php else : // End of main conditional. "If" there are no artists ?>
		<form><p class="error"><br />Please contact the musicLibrary staff for your tunes.</p></form>
	<?php endif ?>
	
<?php 
mysqli_close($dbc);
?>	
<?php 
$q=$_GET["q"];

	//Connect to the database:
	require_once('../../musiclibrary_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();
	
	// Set variable for user based on session id
	$user_id = $_SESSION['user_id'];


	
	
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
		$page_title = 'Search Results';
		break;
	
	// Default is to include the main page.
	default:
		$page = 'musicians.php';
		break;
		
} // End of main switch.

// Make sure the file exists:
if (!file_exists('./includes/' . $page)) {
	$page = 'musicians.php';
	$page_title = 'Site Home Page';
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
		<form><p class="error"><br />Please contact the musicLibrary staff for your tunes.</p></form>
	<?php endif ?>
	
<?php 
mysqli_close($dbc);
?>	
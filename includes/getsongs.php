<?php 
$q=$_GET["q"];

	//Connect to the database:
	require_once('../../musiclibrary_connect.php');
	require_once('../includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	session_start(); // Accessing the existing session.

	//require the user to be logged in
	requireLogin();

	// Set variable for user, first name and last name based on session id
	$user_id = $_SESSION['user_id'];
	$first_name = $_SESSION['first_name'];
	$last_name = $_SESSION['last_name'];
	
	// Define the query:
	$sql="SELECT pk_artistid, pk_albumid, pk_songid, cover, artist, album, track, song, LEFT( time, 5 ) AS time, album_loaded
FROM artists
INNER JOIN albums ON artists.pk_artistid = albums.kf_artistid
INNER JOIN songs ON albums.pk_albumid = songs.kf_albumid
WHERE albums.pk_albumid = '".$q."' && albums.kf_albums_userid = '".$user_id."'
ORDER BY track ASC
LIMIT 0 , 1 
";

	
	// Execute the query:
	$r = mysqli_query($dbc, $sql);	

if (mysqli_num_rows($r) >0) : // Begin main conditional. "If" there are songs . . . ?>

	<!-- // Prepare for the pop-up window: -->

	<!-- // Table header: -->
	<table class="extralead">



	<?php // Report the results of the query:
	while($row = mysqli_fetch_array($r)) : ?>

	<?php // Make the variable for flashvars
	$userfolder = strtolower( $first_name.'_'.$last_name.'_'.$user_id );
	$userfolder = $userfolder . '/' . $row['pk_artistid']. '/' . $row['pk_albumid']; ?>
		
		<tr>
			<td width="100"><img src="<?php echo $row['cover']?>">
			<td width="180"><?php echo $row['artist'] ?><br />
			<div class="highlight<?php if ($row['album_loaded'] == 1) : ?>_bold<?php endif ?>">
		<a href="../includes/getsongs.php?q=<?php echo $row['pk_albumid'] ?>" onclick="playMusic('<?php echo $userfolder ?>', '<?php echo $row['pk_songid'] . '.mp3' ?>'); return false;">
			<?php echo $row['album'] ?></a></td></div>
		</tr>
		<?php endwhile // End of WHILE loop. ?>
	</table>
	
<?php	// Define the query:
	$sql="SELECT pk_artistid, pk_albumid, pk_songid, cover, artist, album, track, song, LEFT( time, 5 ) AS time
FROM artists
INNER JOIN albums ON artists.pk_artistid = albums.kf_artistid
INNER JOIN songs ON albums.pk_albumid = songs.kf_albumid
WHERE albums.pk_albumid = '".$q."' && albums.kf_albums_userid = '".$user_id."'
ORDER BY track ASC
";
	
	// Execute the query:
	$r = mysqli_query($dbc, $sql);	
?>
	<!-- // Table header: -->
	<table>
	<tr>
		<th>Track&ensp;</th>
		<th>Song</th>
		<th>Time&ensp;</th>
	</tr>

	<?php // Report the results of the query: 
	$bg = '#ffffff'; // variable for the ternary operator ?>
	<?php while($row = mysqli_fetch_array($r)) : ?>
	<?php $bg = ($bg=='#ffffff' ? '#eeeeee' : '#ffffff'); // the ternary operator ?>
		<div class="blue"><tr bgcolor="<?php echo $bg ?>">
		<td width="25" class="vertical_align" align="center"><?php echo $row['track'] ?></td>
		<td width="215">
		<a href="../includes/getsongs.php?q=<?php echo $row['pk_albumid'] ?>" onclick="playMusic('<?php echo $userfolder ?>', '<?php echo $row['pk_songid'] . '.mp3' ?>'); return false;"><?php echo $row['song'] ?></a></td>
		<td width="37"><?php echo $row['time'] ?></td>
		</tr></div>
		<?php endwhile // End of WHILE loop. ?>
		
		<!-- //End of Table. End of button div	-->
		</table>
						<div id="flashplayer"></div>

		
	<?php else : // End of main conditional. "If" there are no songs . . . ?>
	<p class="error">There are no songs, and the world is a smaller place.</p>
	<?php endif ?>
<h1>Songs</h1>

<?php if (mysqli_num_rows($r) > 0) : ?>
	<!-- // Begin main conditional. "If" there are songs . . . -->

	<!-- //songs div. Begin float left -->
	<div id="songs">

	<! -- // Prepare for the pop-up window: -- >
	<div id="button">

	<!-- // Table header: -->
		<table align="center" class="extralead" border=0 width="100%">
	<tr>
		<th>Track&ensp;</th>
		<th>Song</th>
		<th>Time</th>
	</tr>
		
		<!-- // Fetch and print all the records.... -->
	<?php $bg = '#eeeeee'; // variable for the ternary operator ?>
	<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
		<?php $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator ?>
		<tr bgcolor="<?php echo $bg ?>">
			<td align="left"><?php echo $row['track'] ?></td>
			<td align="left">
			<a href="#" onclick="playMusic(<?php echo $row['pk_albumid'] ?>, <?php echo $row['pk_songid'] . '.mp3' ?>)"><?php echo $row['song'] ?></a></td>		
			<td align="left"><?php echo $row['time'] ?></td>
		</tr>
		
		<?php endwhile // End of WHILE loop. ?>

			<!-- //End of Table. End of button div -->
		</table></div>


	<!-- // songs. float left -->
		<div id="songs">
		
	<?php else : // End of main conditional. "If" there are no songs . . . ?>
	<p class="error">There are no songs, and the world is a smaller place.</p>
	<?php endif ?>

<!-- 	
// THE POP-UP WINDOW
-->

<?php $q=$_GET["q"];

	// Define the query:
	$sql="SELECT cover
FROM esod_albums
INNER JOIN esod_songs ON esod_albums.pk_albumid = esod_songs.kf_albumid
WHERE esod_albums.pk_albumid = '".$q."'
ORDER BY track ASC
LIMIT 0, 1
"; 

	// Execute the query:
	$r = mysqli_query($dbc, $sql);	
?>
	
	<!-- // Initiate the popup divs -->
	<div id="popupContact">
		<a id="popupContactClose">x</a>


<?php if (mysqli_num_rows($r) >0) : ?> 
	<!-- // Begin main conditional. "If" there are songs . . . -->
		
	<!-- // Table header: -->
	<table align="center" class="extralead" border=0 width="100%">
	<tr>
		<th>Cover</th>
	</tr>

	<!-- // Report the results of the query: -->
	<?php while($row = mysqli_fetch_array($r)) : ?>
		<tr><td><img src="<?php echo $row['cover']?>"
		</tr>
		<?php endwhile // End of WHILE loop. ?>
		
	</table>
	
<?php	// Define the query:
	$sql="SELECT track, song, time, pk_albumid, pk_songid
FROM esod_albums
INNER JOIN esod_songs ON esod_albums.pk_albumid = esod_songs.kf_albumid
WHERE esod_albums.pk_albumid = '".$q."'
ORDER BY track ASC
";
	// Execute the query:
	$r = mysqli_query($dbc, $sql);
?>	
	
	<!-- // Table header: -->
	<table align="center" class="extralead" border=0 width="100%">
	<tr>
		<th>Track&ensp;</th>
		<th>Song</th>
		<th>Time</th>
	</tr>

	<!-- // Report the results of the query: -->
	<?php $bg = '#eeeeee'; // variable for the ternary operator ?>
	<?php while($row = mysqli_fetch_array($r)) : ?>
	<?php $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator ?>
		<tr bgcolor="<?php echo $bg ?>">
		<td><?php echo $row['track'] ?></td>
		<td align="left">
		<a href="/ericsod/final_project/includes/getsongs.php?q=<?php echo $row['pk_albumid'] ?>" onclick="playMusic(<?php echo $row['pk_albumid'] ?>, <?php echo $row['pk_songid'] . '.mp3' ?>)"; return false;"><?php echo $row['song'] ?></a></td>
		<td><?php echo $row['time'] ?></td>
		</tr>
		<?php endwhile // End of WHILE loop. ?>
		
	</table>	
			<div id="flashplayer"></div>
		
	<?php else : // End of main conditional. "If" there are no albums . . . ?>
	<p class="error">There are no songs, and the world is a smaller place.</p>
	<?php endif ?>
	
	</div>
	<div id="backgroundPopup"></div>
	
		<div class="clearfloat"></div>
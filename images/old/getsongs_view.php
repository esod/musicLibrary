<?php if (mysqli_num_rows($r) >0) : ?> <!-- // Begin main conditional. "If" there are songs . . . -->

	<!-- // Prepare for the pop-up window: -->
	<div id="button">	

	<!-- // Table header: -->
	<table align="center" class="extralead" border=0 width="100%">

	<!-- // Report the results of the query: -->
	<?php while($row = mysqli_fetch_array($r)) : ?>
		<tr>
		<img src="<?php echo $row['cover'] ?>" width="100" height="94"></td>
		<td><?php echo $row['artist'] ?><br />
		<?php $row['album'] ?></td>
		</tr>

		<?php endwhile // End of WHILE loop. ?>
		
	</table>
	
		<!-- // Table header: -->
	<table align="center" class="extralead" border=0 width="100%">
	<tr>
		<th>Track</th>
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
<a href="/ericsod/final_project/includes/getsongs.php?q='<?php echo $row['pk_albumid'] ?>" onclick="playMusic(<?php echo $row['pk_albumid'] ?>, <?php echo $row['pk_songid'] . '.mp3' ?>); return false;"><?php echo $row['song'] ?></a></td>
		<td><?php echo $row['time'] ?></td>
		</tr>

		<?php endwhile // End of WHILE loop. ?>
		
		<!-- //End of Table. End of button div -->
		</table></div>
		
	<?php else : // End of main conditional. "If" there are no albums . . . ?>
	<p class="error">There are no albums, and the world is a smaller place.</p>
	<?php endif ?>

	<!-- THE POP-UP WINDOW -->
	
	<!-- // Initiate the popup divs -->
	<div id="popupContact"><a id="popupContactClose">x</a>



<?php if (mysqli_num_rows($r) >0) : ?>
	<!-- // Begin main conditional. "If" there are songs . . . -->
		
	<!-- // Table header: -->
	<table align="left" width="100%">
	<tr>
	</tr>

	<!-- // Report the results of the query: -->
	<?php while($row = mysqli_fetch_array($r)) : ?>
		<tr>
		<td><img src="<?php echo $row['cover'] ?>" width="100" height="94"></td>
		<td align="left"><?php echo $row['artist'] ?><br />
		<?php echo $row['album'] ?></td>
		</tr>
		
		<?php endwhile // End of WHILE loop. ?>
		
	</table>
	


	<!-- // Table header: -->
	<table align="center" width="100%">
	<tr>
		<th>Track;</th>
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
	<p class="error">There are no albums, and the world is a smaller place.</p>
	<?php endif ?>

	<!-- // End of the popup divs -->
	</div>
	<div id="backgroundPopup"></div>

<h1>Albums</h1>

<?php if (mysqli_num_rows($r) > 0) : ?>
	<!-- //Begin main conditional. "If" there are albums . . . -->

	<!-- //albums div. Begin float left -->
	<div id="albums">

	<!-- // Table header: -->
		<table align="center" cellspacing="0" cellpadding="5" width="75%">
		<tr>
			<td align="left"><strong>Covers</strong></td>
			<td align="left"><strong><a href="index.php?sort=a">Album</strong></td>
			<td align="left"><strong><a href="index.php?sort=y">Year</strong></td>
		</tr>

	<!-- // Fetch and print all the records.... -->
	<?php $bg = '#eeeeee'; // variable for the ternary operator ?>
	<?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) : ?>
		<?php $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator ?>
		<tr bgcolor="<?php echo $bg ?>">
			<td align="left">
			<img src="<?php echo $row['cover'] ?>" width="100" height="94"></td>
			<td align="left">
			<a href="/ericsod/final_project/includes/getsongs.php?q=<?php echo $row['pk_albumid'] ?>" onclick="showSongs(<?php echo $row['pk_albumid'] ?>); return false;">
			<?php echo $row['album'] ?>
			</a></td>
			<td align="left"><?php echo $row['year'] ?></td>
		</tr>
		<?php endwhile // End of WHILE loop. ?>
		</table>

	</div><!-- // end of albums div -->


	<!-- // songs. float left -->
		<div id="songs">
		
		<!-- // Prepare for the pop-up window: -->
		<div id="button">
			<a id="popupContactClose">x</a>		
		
		<!-- // for AJAX. see select.js.function.albumChanged -->	
			<div id="txtHin"></div>
		
		<!-- //End of button div -->
		<div id="backgroundPopup"></div></div>

		</div>
		</div> <!-- // end of songs div -->
		<div class="clearfloat"></div>

	<?php else : // End of main conditional. "If" there are no albums . . . ?>
	<p class="error">There are no albums, and the world is a smaller place.</p>
	<?php endif ?>

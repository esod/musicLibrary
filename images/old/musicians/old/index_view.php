		<?php 
				$first_name = $_SESSION['first_name'];
				if (isset($_SESSION['user_id'])) {
				echo "<h1>$first_name's musicLibrary!</h1>";				
				}
			?>
			
	<?php if (mysqli_num_rows($r) > 0) : ?>
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


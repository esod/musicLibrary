<head>
	<title>Aack!!</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="/ericsod/final_project/images/music_note.ico" type="image/x-icon" />	
	<link rel="stylesheet" type="text/css" href="/ericsod/final_project/includes/style.css" media="screen" />
	<script type="text/javascript" src="/ericsod/final_project/includes/select.js"></script>
	<script type="text/javascript" src="/ericsod/final_project/includes/swfobject.js"></script>
	<script src="/ericsod/final_project/includes/scrollbars/dw_event.js" type="text/javascript"></script>
	<script src="/ericsod/final_project/includes/scrollbars/dw_scroll.js" type="text/javascript"></script>
	<script src="/ericsod/final_project/includes/scrollbars/scroll_controls.js" type="text/javascript"></script>
<script type="text/javascript">

function init_dw_Scroll() {
    var wndo = new dw_scrollObj('wn', 'lyr1');
    wndo.setUpScrollControls('scrollLinks');
}

// if code supported, link in the style sheet and call the init function onload
if ( dw_scrollObj.isSupported() ) {
    //dw_writeStyleSheet('css/scroll.css');
    dw_Event.add( window, 'load', init_dw_Scroll);
}

</script>
	
</head>

<?php 
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

$q=$_GET["q"];

	//Connect to the database:
	require_once('../../mysqli_connect.php');
	
	// Define the query:
	$sql="SELECT cover, album, year
FROM esod_artists
INNER JOIN esod_albums ON esod_artists.pk_artistid = esod_albums.kf_artistid
WHERE esod_artists.pk_artistid = ".$q."
ORDER BY $order_by
";
	
	// Execute the query:
	$r = mysqli_query($dbc, $sql);
	
if (mysqli_num_rows($r) > 0) { // Begin main conditional. "If" there are albums . . . 

	//Begin albums_ajax, wn div, lyr1 div
	echo '<div id="albums_ajax">
		<div id="wn">
		<div id="lyr1">
		';
		
	// Table header:
	echo '<table align="center" class="extralead" border=0 width="100%">
	<tr>
		<td align="left"><strong>Covers</strong></th>
		<td align="left"><strong><a href="/ericsod/final_project/includes/getalbums.php?q='.$q.'&sort=a">Album</strong></th>
		<td align="left"><strong><a href="/ericsod/final_project/includes/getalbums.php?q='.$q.'&sort=y">Year</strong></th>
	</tr>';

	// Report the results of the query:
	$bg = '#eeeeee'; // variable for the ternary operator
	while($row = mysqli_fetch_array($r)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // the ternary operator
		echo '<tr bgcolor="' . $bg . '">
				<td><img src="' . $row['cover'] . '"></td>
				<td>' . $row['album'] . '</td>
				<td>' . $row['year'] . '</td>
		</tr>
		';
		} // End of WHILE loop
		
		// end of wn div, end of lyr1 div
		echo "</table>";
		echo '</div>
		</div>
		'; 
	
			// If more than 4 albums, show the triangular scroll buttons
			if (mysqli_num_rows($r) > 4) { 
			echo '<div id="scrollLinks">
				<a class="mouseover_up" href="#"><img src="/ericsod/final_project/includes/scrollbars/tri-up.gif" alt="" border="0" /></a>
				<a class="mouseover_down" href="#"><img src="/ericsod/final_project/includes/scrollbars/tri-dn.gif" alt="" border="0" /></a>
			</div>
			</div>
			'; // end of scrollLinks div; // end of albums_ajax div	
			}

	} else { // End of main conditional. "If" there are no albums . . . 
	echo '<p class="error">There are no albums, and the world is a smaller place.</p>';
	}

mysqli_close($dbc);
?> 

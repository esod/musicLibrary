<?php
// Make the query for the ARTISTS:
$q = "SELECT artist, pk_artistid FROM esod_artists ORDER BY artist ASC";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if (mysqli_num_rows($r) > 0) { // There are artists.
	// Fetch the artists....
	$artists = array();
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$artists[] = $row;
	} // End of WHILE loop.
}

?>

<form>
	<strong>Select an Album:</strong>
</form>
<div id="txtHint"></div>

<?php

// This page contains the connection routine for the
// database as well as getting the ID of the cart, etc

$dbServer = "mysql.onepotcooking.com";
$dbUser = "scps";
$dbPass = "webdev2009!";
$dbName = "classdb";

//function to connect to a database
function ConnectToDb($server, $user, $pass, $database)
{
	// Connect to the database and return
	// true/false depending on whether or
	// not a connection could be made.

	$s = @mysql_connect($server, $user, $pass);
	$d = @mysql_select_db($database, $s);

	if(!$s || !$d)
		return false;
	else
		return true;
}


//function to disconnect to a database
function DisconnectFromDb($server, $user, $pass, $database)
{
	// Disconnect from the database and return
	// true/false depending on whether or
	// not a disconnection could be made.

	$s = @mysql_disconnect($server, $user, $pass);

	if(!$s)
		return false;
	else
		return true;
}


?>

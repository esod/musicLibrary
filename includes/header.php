<?php 

// This page begins the HTML header for the site.

// Check for a $page_title value:
if (!isset($page_title)) $page_title = 'musicLibrary';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $page_title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../images/music_note.ico" type="image/x-icon" />	
	<link rel="stylesheet" href="../includes/general.css" type="text/css" media="screen" />
	<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="../includes/select.js"></script>
	<script type="text/javascript" src="../includes/swfobject.js"></script>
	<script src="../includes/popup.js" type="text/javascript"></script>

  <script type="text/javascript">
$(function() {
	var searchText = "Search . . . ";

var focusSearch = function(){
	if ($(this).val()== searchText){
		$(this).val("");
	}
};

var blurSearch = function(){
	if (!$(this).val()){
		$(this).val(searchText);
	}
	else {
		$(this)
			.unbind('focus', focusSearch)
			.unbind('blur', blurSearch);
		}
};

$('.search')
	.val(searchText)
	.focus(focusSearch)
	.blur(blurSearch);
});
  </script>

</head>
<body>
	<!-- start of main container div> -->
	<div class="centeredContainer">
	<div id="header">
	<a href="../musicians.php"><img src="../images/logov2.gif">
	</div>
	<div id="navigation">
		<li><?php // Create a login/logout link.
				if ( (isset($_SESSION['user_id'])) && (!strpos($_SERVER['PHP_SELF'], 'logout.php')) ) : ?>
				<a href="../logout.php" class="button">Logout</a>
				<?php else : ?>
				<a href="../index.php" class="button">Login</a>
		<?php endif ?>
			</li>
		<li><?php // Create a Register/Change Password link.
				if ( (isset($_SESSION['user_id'])) && (!strpos($_SERVER['PHP_SELF'], 'logout.php')) ) : ?>
				<a href="../password.php" class="button">Change Password</a>
				<?php else : ?>
				<a href="../register.php" class="button">Register</a>
		<?php endif ?>
			</li>
		<li><a href="../musicians.php" class="button">My Music</a></li>
		<li><form name="form1" id="form1" method="get" action="../includes/search.inc.php">
				<input type="text" class="search" name="terms" value="Search..." />&ensp;
				<input type="hidden" name="p" value="search" />
				<input class="buton" type="submit" name="Submit" value="GO" />
		</form></li>
	</div>

	<div class="clearfloat"></div>

<div id="content"><!-- Start of the page-specific content. -->

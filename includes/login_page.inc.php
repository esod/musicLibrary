<?php 

// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include ('includes/header.php');

// Print any error messages, if they exist:
if (!empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p class="try_again">Please try again.</p>';
}

// Display the form:
?>
<h1>Login</h1>
<form action="index.php" method="post">
	<p><label>Email Address:</label><input type="text" name="email" class="index_form" size="20" maxlength="80"  value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /> </p>
	<p><label>Password:</label><input type="password" name="pass" class="index_form" size="20" maxlength="20" /></p>
	<input class="buton" type="submit" name="submit" value="Login" /><br />
	<input type="hidden" name="submitted" value="TRUE" />
	<div class="instructions_for_use"><br />Visitors, please login in as:</div>
	<div class="instructions_for_use">Email Address: <strong>esod124@gmail.com</strong><br />
	Password: <strong>Guest123</strong></div>
	
	<div class="instructions_for_use">You can listen to music. There are 4 albums loaded on the server:</div>

	<div class="instructions_for_use">Alicia Keys, "As I Am"<br />
	Arctic Monkeys, "Whatever People Say I Am, That is What I Am Not"<br />
	Bruce Springsteen, "Working On A Dream"<br />
	Elvis Presley, "Elvis 30 #1 Hits"</div>
	<div class="instructions_for_use">Enjoy!</div>
	</form>

<?php // Include the footer:
include ('includes/footer_login.php');
?>

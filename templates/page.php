<?php
	session_start();
	
	//if we visit a protected page and we're not logged int
	if($page['protected'] && !$_SESSION['email']){
		header("Location: /");
		exit;
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<?php
		require_once('headers.php');
	?>
</head>
<body>
<div id='overlay' onclick='overlay()'></div>
<div id='overlay-box'>
	<?php echo file_get_contents('images/cross.svg'); ?>
	<?php if(!$_SESSION['email']): ?>
	<div id='sign-up'>
		<h1>Sign Up</h1>
		<form method='post' action='templates/create-account.php'>
			<input type='hidden' name='identity' value='student'>
			<input name='email' type='email' placeholder='Email Address' maxlength='100' required>
			<input name='password' type='password' placeholder='Create password' maxlength='100' required>
			<input name='password_confirm' type='password' placeholder='Confirm password' maxlength='100' required>
			<input type='submit' value='Create Account'>
		</form>
	</div>
	<div id='become-an-instructor'>
		<h1>Become an Instructor</h1>
		<form method='post' action='templates/create-account.php'>
			<input type='hidden' name='identity' value='instructor'>
			<input name='email' type='email' placeholder='Email Address' maxlength='100' required>
			<input name='password' type='password' placeholder='Create password' maxlength='100' required>
			<input name='password_confirm' type='password' placeholder='Confirm password' maxlength='100' required>
			<input type='submit' value='Create Account'>
		</form>
	</div>
	<div id='sign-in'>
		<h1>Sign In</h1>
		<form method='post' action='templates/auth.php'>
			<input name='email' type='email' placeholder='Email Address'>
			<input name='password' type='password' placeholder='Password'>
			<input type='submit' value='Login'>
		</form>
	</div>
	<?php endif; ?>
</div>
<div id='header-wrap'>
	<div class='center-80'>
		<div id='logo'><a href='/'><img src='images/logo.png'> Skill Swap</a></div>
		<div id='mobile-menu'></div>
		<div id='mobile-button' onclick='menu()'><i id='bars' class="fa fa-bars" aria-hidden="true"></i><i id='times' class="fa fa-times" aria-hidden="true"></i></i></div>
		<div id='menu'>
			<div id='search-bar'>
				<i class='fa fa-search'></i>
				<input type='text' placeholder='Search for a subject...'>
			</div>
			<?php if($_SESSION['email']): ?>
			<a href='account.php'>My Account</a>
			<a href='templates/auth.php'>Logout</a>
			<?php else: ?>
			<a href='javascript:overlay("sign-in");'>Sign In</a>
			<a href='javascript:overlay("sign-up");'>Sign Up</a>
			<a href='javascript:overlay("become-an-instructor");'>Become an Instructor</a>
			<?php endif; ?>
			<a href='javascript:;'><i class='fa fa-facebook'></i></a>
			<a href='javascript:;'><i class='fa fa-reddit'></i></a>		
			<a href='javascript:;'><i class='fa fa-youtube'></i></a>
		</div>
	</div>
</div>
<?php
	echo "<div class='body-" . $page['body'] . "'>";
	require_once('templates/body/body-' . $page['body'] . '.php');
	echo "</div>";
?>
<div id='footer1-wrap'>
	<div class='center-80'>
		&copy; 2018 Evroca Media LLC
	</div>
</div>
<div id='footer2-wrap'>
	<div class='center-80'>
		Site by <a href='https://evrocamedia.com'>Evroca Media LLC</a>
	</div>
</div>
</body>
</html>
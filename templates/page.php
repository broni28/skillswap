<?php
/*
	The Idea
		Webcam and screen share tutoring
	What makes it different?
		WebRTC
		All categories
		Faster approval process
		Competitors
			Udemy (prerecorded lessons)
			Learnbycam.com (recommends skype to get in touch)
			webcamtutors.com (dogshit website)
			www.chegg.com/tutors/how-it-works/ (school specific)
	Talk Money
		Average Instructor >$25/hr (source: https://www.superprof.us/)
		Uber Takes 20% cut
		5 active instructor * (40hr/week)/(active instructor) * $25/hr * 0.2 = $1000 per week income
		$1000/week * 52 = $52,000 per year ($10,400 per instructor)
	Selling points
		One stop shop for all categories of learning
		It's the Uber of tutoring
		Easily become an instructor
		quickly make money from the comfort of your own home
		rating based system
		webcam and screen share tutoring
		personalized 1 on 1
	Becoming an instructor
		1) Basic user information (name, email address, etc.)
		2) Fill out bio about themselves (this will show up on their profile page)
		3) Upload profile picture (also on profile page)
		4) Screening process (picture of diploma/certificate, drivers license, etc.. Emphasize how quick it is for us to approve them)
	Becoming a user
		1) User creates an account with an email address (goes through some sort of screening process)
		2) User adds money to their account (some % plus the credit)
		3) User signs up with an instructor, provided an available time the instructor has given
		4) Receives an email reminder
	Room
	Page Layout
		Home Page
			Header (logged out)
				Logo
				Search Bar
				Sign In Link
				Sign Up Link
				Become an Instructor Link
				Social Media
			Header (logged in)
			Section 1
				Summary Header
				Summary Text
			Section 2
				Selling Points
			Section 3
				Detailed info, more marketing fluff
			Section 4
				List of instructors
				Sorting (Netflix style)
		Admin Page
			Payout confirmation
			Monitoring system
	To do
		Finish home page content
		Figure out what to put initially because there are will be no instructors
		Decide how to scale, should we focus in one area like music?
*/ 
?>
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
		<a href='room.php'>Join Room</a>
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
	require_once('templates/body/body-' . $page['body'] . '.php');
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
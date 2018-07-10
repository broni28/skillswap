<?php if($_SERVER['PHP_SELF'] == '/' . $page['body'] . ".php" && $_SESSION['email']): ?>
	<?php if('student' == 'student'): ?>
		<div id='section5-wrap'>
			<h1 class='text-center'>My Account</h1>
		</div>
		<div id='section6-wrap'>
			<div class='center-40'>
				<div class='text-center' style='padding:15px 0;margin:15px 0;background:#000;color:#fff;'>You have a meeting in 5 minutes <a href='room.php?id=1'>Join Room</a></div>
				<h2>Membership & Billing</h2>
				<div style='overflow:auto;'>
					<div style='float:right;width:80%;'>
						<div class='text-right' style='margin-bottom:5px;'><a href='javascript:;'>(Show billing history)</a></div>
						<div class='overflow'>
							<div style='float:right;width:80%;border-top:1px solid #ccc;padding:10px 0 5px 0;'>
								<div>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></div>
							</div>
						</div>
						<div class='text-right' style='margin-bottom:5px;'><a href='javascript:;'>Add credit</a></div>
					</div>
				</div>
				<h2>My Profile</h2>
				<div style='overflow:auto;'>
					<div style='float:right;width:80%;'>
						<div>(Profile Picture)</div>
						<div class='text-right' style='margin-bottom:5px;'><a href='javascript:;'>Update email</a></div>
						<div class='text-right' style='margin-bottom:5px;'><a href='javascript:;'>Change password</a></div>
					</div>
				</div>
				<h2>Settings</h2>
				<div style='overflow:auto;'>
					<div style='float:right;width:80%;'>
						<div class='text-right' style='margin-bottom:5px;'><a href='javascript:;'>Contact us</a></div>
					</div>
				</div>
				<h2>Gifts & Offers</h2>
				<div>
					<input type='text' placeholder='Enter code...'>
					<input type='submit' value='Redeem'>
				</div>
			</div>
		</div>
	<?php elseif($user_info['role'] == 'instructor'): ?>
		You are an instructor
	<?php endif; ?>
<?php endif; ?>
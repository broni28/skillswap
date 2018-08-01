<?php if($_SERVER['PHP_SELF'] == '/' . $page['body'] . ".php" && $_SESSION['email']): ?>
	<?php if($user_info['role'] == 'instructor'): ?>
		<div id='section6-wrap'>
			<div class='center-40'>
				<div class='text-center' style='padding:15px 0;margin:15px 0;background:#000;color:#fff;'>You have a meeting in 5 minutes <a href='room.php?id=1'>Join Room</a></div>
				<h2>Set your availability:</h2>
				<h3>March</h3>
				<div>July 1 - 7</div>
				
				<table>
					<tr>
						<th>Time</th>
						<th>Sunday</th>
						<th>Monday</th>
						<th>Tuesday</th>
						<th>Wednesday</th>
						<th>Thursday</th>
						<th>Friday</th>
						<th>Saturday</th>
					</tr>
					<?php 
						$time_arr = array('12 AM','1 AM','2 AM','3 AM','4 AM','5 AM','6 AM','7 AM','8 AM','9 AM','10 AM','11 AM','12 PM','1 PM','2 PM','3 PM','4 PM','5 PM','6 PM','7 PM','8 PM','9 PM','10 PM','11 PM');
						while($time_arr){
							echo "<tr>";
							echo "<td>" . array_shift($time_arr) . "</td>";
							for($i = 0; $i < 7; $i++){
								if(rand(1,2) == 1){
									$color = '00b388';
								}
								else{
									$color = "123456";
								}
								echo "<td style='background:#" . $color . ";width:40px;'></td>";
							}
							echo "</tr>";
						}
					?>
				</table>
				
				<div></div>
			</div>
		</div>
	<?php elseif($user_info['role'] == 'student'): ?>
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
	<?php endif; ?>
<?php endif; ?>
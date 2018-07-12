<?php if($_SERVER['PHP_SELF'] == '/' . $page['body'] . ".php"): ?>
<div id='section1-wrap' class='effect1'>
	<div style='padding:30px 0;background:rgba(0,0,0,0.8)'>
		<div class='center-40'>
			<div class='flex'>
				<div>
					<h1>Webcam tutoring made simple</h1>
					<p>Finding a qualified tutor shouldn't be difficult. Learn from the best in the comfort of your own home.</p>
					<a class='button' href='javascript:;'>Get Started</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id='section2-wrap'>
	<div class='center-80'>
		<div class='flex'>
			<div class='wide-33'>
				<div class='flex'>
					<div class='flex-center' style='width:20%;'><div>
						<i class='fa fa-car' style='font-size:44px;'></i>
					</div></div>
					<div style='width:80%;'>
						<h3>Sign up and go</h3>
						<p>Simply create an account, add credit, and you're ready to go. Begin live tutoring in minutes.</p>
					</div>
				</div>
			</div>
			<div class='wide-33'>
				<div class='flex'>
					<div class='flex-center' style='width:20%;'><div>
						<i class='fa fa-address-book' style='font-size:44px;'></i>
					</div></div>
					<div style='width:80%;'>
						<h3>Personalized one-on-one experience</h3>
						<p>Receive help from a diverse set of professionals in all fields, from math and science to music and culture.</p>
					</div>
				</div>
			</div>
			<div class='wide-33'>
				<div class='flex'>
					<div class='flex-center' style='width:20%;'><div>
						<i class='fa fa-star' style='font-size:44px;'></i>
					</div></div>
					<div style='width:80%;'>
						<h3>Rate your tutors</h3>
						<p>Tutors are reviewed by the people they teach, so you know you're getting the best in the business.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id='section3-wrap' class='text-shadow'>
	<div class='center-80'>
		<h1 class='text-center'>Our online tutoring is simple and easy</h1>
		<div class='flex'>
			<?php
				$selling_point_arr = array(
					array(
						'title' => 'Includes a number of learning tools',
						'points' => array(
							'Webcam based and screen sharing capabilies',
							'Friendly learning environment',
							'Intuitive scheduling tool to find available times',
						),
					),
					array(
						'title' => 'Learn at your own pace',
						'points' => array(
							'Thousands of certified tutors',
							'Learn when you want, where you want',
						),
					),
					array(
						'title' => 'Or become a tutor',
						'points' => array(
							'Provide background and certification and get accepted right away',
							'Quick approval process',
						),
					),
				);
				foreach($selling_point_arr as $selling_point){
					echo "
					<div class='wide-33' style='width:27%;padding:22px 1.5%;margin:0 1.5%;background:rgba(0,0,0,0.2);border-radius:15px;margin-top:15px;'>
					<h2>" . htmlspecialchars($selling_point['title']) . "</h2>
					";
					foreach($selling_point['points'] as $point){
						echo "<p><i class='fa fa-check'></i> " . htmlspecialchars($point) . "</p>";
					}
					echo "</div>";
				}
			?>
		</div>
	</div>
</div>
<div id='section4-wrap'>
	<div class='center-80'>
		<?php
			$i = 0;
			$title_arr = array(
				"Popular Instructors",
				"Instructors Currently Online",
				"Free Instructors",
			);
			shuffle($title_arr);
			while($i < 10){
				if($i % 4 == 0){
					if($i){
						echo "</div>";
					}
					echo "<h1 class='text-shadow'>" . array_shift($title_arr) . "</h1><div class='flex'>";
				}
				echo "
				<div class='instructor-box'>
					<img src='images/instructor.jpg' style='width:100%;'>
					<div style='padding:15px;'>
						<div style='font-size:22px;'>Guitar Lessons: Learn Basic Chords and Simple Melodies</div>
						<div style='color:#777;'>Instructor: Brandon Lalonde</div>
						<div style='margin:10px 0;'>
							<i class='fa fa-star' style='color:#ff8300'></i>
							<i class='fa fa-star' style='color:#ff8300'></i>
							<i class='fa fa-star' style='color:#ff8300'></i>
							<i class='fa fa-star' style='color:#ff8300'></i>
							<i class='fa fa-star' style='color:#ddd'></i>
							4.0 (2,422 ratings)
						</div>
						<div style='text-align:center;background:rgba(0,255,31,0.16);color:#20b370;border-top:2px solid #9dbfb0;border-bottom:2px solid #9dbfb0;padding:5px 0;font-size:19px;margin:5px 0;'>$15 per hour</div>
						<div>Lorem ipsum dolor sit amet, in duo quaeque omittantur, audire tincidunt eu vis. Dolor labitur no mea. Eam id...</div>
						<div style='text-align:center;margin-top:10px;'>
							<a href='availability.php' class='check-avail-button'>Check Availability</a>
						</div>
					</div>
				</div>
				";
				$i++;
			}
			echo "</div>";
		?>
		<div class='flex' style='padding:20px 0;color:#fff;margin-top:50px;'>
			<?php
				$i = 0;
				while($i < 3){
					$i++;
					echo "
					<div class='wide-33 flex-center' style='padding:15px 0;'>
						<div class='text-center'>
							<div style='margin:10px;padding:30px;background:rgba(0, 0, 0, 0.5)'>
								<h1>Become an Instructor</h1>
								<p style='padding:20px 0'>Teach now Teach now Teach now Teach now Teach now Teach now Teach now Teach now Teach now Teach now Teach now Teach now</p>
								<div><a href='javascript:;' class='button'>Become an instructor</a></div>
							</div>
						</div>
					</div>
					";
				}
			?>
		</div>
	</div>
</div>
<?php endif; ?>
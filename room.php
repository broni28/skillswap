<?php
	/*
		This is going to be the URL that a user will visit to join a room with the instructor they have chosen.
	*/
	session_start();
	require_once("/home/ecarlson10/settings.php");
	
	class Room{
		
		//instructor or student
		private $role;
		
		public function __construct(){
			
			//checks to make sure user is allowed in the room
			$this->validate_user();
		}
		//returns the sender_id and acceptor_id as an array
		public function fetch_ids(){
			
			global $mysqli;

			$stmt = $mysqli->prepare("SELECT * FROM webcam_rooms WHERE id=? LIMIT 1");
			$stmt->bind_param("s", $_GET['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()){
				
				//if we're the instructor
				if($this->role == 'instructor'){
					return array(
						'sender_id' => $row['instructor_id'],
						'acceptor_id' => $row['student_id'],
						'room_id' => $row['id'],
					);
				}
				elseif($this->role == 'student'){
					return array(
						'sender_id' => $row['student_id'],
						'acceptor_id' => $row['instructor_id'],
						'room_id' => $row['id'],
					);
				}
			}
		}
		private function validate_user(){
			global $mysqli;
			
			//if logged in
			if($_SESSION['email']){
				$stmt = $mysqli->prepare("SELECT * FROM webcam_users WHERE email=? LIMIT 1");
				$stmt->bind_param("s", $_SESSION['email']);
				$stmt->execute();
				$result = $stmt->get_result();
				if($row = $result->fetch_assoc()){
					
					//if we're allowed to be in the room
					if(is_numeric($_GET['id']) && $row['valid_rooms'][$_GET['id']]){
						$this->role = $row['role'];
					}
					else{
						$this->go_home();
					}
				}
			}
			else{
				$this->go_home();
			}
		}
		private function go_home(){
			header("Location: /");
			exit;
		}
	}
	$room = new Room;
	$ids = $room->fetch_ids();
?>
<!DOCTYPE HTML?>
<html>
<head>
	<?php
		require_once('templates/headers.php')
	?>
</head>
<body id='body-room'>
<div id='room-buttons'>
	<div class='transition-toggle' id='toggle' onclick='toggle_connect()'>
		<div class='transition-toggle' id='toggle-inner'></div>
	</div>
	<?php echo file_get_contents('images/video.svg'); ?>
	<?php echo file_get_contents('images/full-screen.svg'); ?>
</div>
<input type='hidden' id='sender_id' value='<?php echo $ids['sender_id']; ?>'>
<input type='hidden' id='acceptor_id' value='<?php echo $ids['acceptor_id']; ?>'>
<input type='hidden' id='room_id' value='<?php echo $ids['room_id']; ?>'>
<div id='logo' style='position:absolute;z-index:1;top:15px;'><a href='/' style='color:#fff;'><img src='images/logo.png'> Skill Swap</a></div>
<div id='remote-video-standin'>
	<!-- 
	<div class='text-center'>
		<div>Waiting for other user...</div>
		<img src='images/loading.gif'>
	</div>
	-->
</div>
<video id="local-video" autoplay muted></video>
<video id="remote-video" class='effect-video' autoplay></video>
<div id='chatroom'>
	<div id='chatroom-box' class='inset-box'></div>
	<textarea id='chat-textarea' style='margin-top:15px;' placeholder='Send message' onkeypress='return get_key(event)'></textarea>
</div>
<script src="js/room.js"></script>
</body>
</html>
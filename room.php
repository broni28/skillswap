<?php
	/*
		This is going to be the URL that a user will visit to join a room with the instructor they have chosen.
	*/
	session_start();
	require_once("/home/ecarlson10/settings.php");
	require_once("templates/classes.php");
	
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
	<div id='loading-message-success' class='text-center' style='display:none;'>Connecting...</div>
	<div id='loading-message'>
		<div class='text-center'>
			<div>Waiting for other user...</div>
			<img src='images/loading.gif'>
		</div>
	</div>
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
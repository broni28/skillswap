<?php
	/*
		This is going to be the URL that a user will visit to join a room with the instructor they have chosen.
	*/
?>
<!DOCTYPE HTML?>
<html>
<head>
	<?php
		require_once('templates/headers.php')
	?>
	<link rel='stylesheet' href='css/room.css'>
</head>
<body>
<video id="local-video" autoplay="" muted></video>
<video id="remote-video" autoplay=""></video>
<div id='chatroom'>
	<h1>Welcome to the chatroom</h1>
	<input type='text' placeholder='Send message...'>
	<input type='submit' value='Send'>
</div>
<div style='position:absolute;top:15px;left:15px;z-index:1;'>Creating offer: <span id='offer'></span></div>
<script src="js/room.js"></script>
</body>
</html>
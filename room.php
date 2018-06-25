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
</head>
<body>
<div id='logo' style='position:absolute;z-index:1;top:15px;'><a href='/'><img src='images/logo.png'> Skill Swap</a></div>
<video id="local-video" autoplay muted></video>
<video id="remote-video" autoplay></video>
<div id='chatroom'>
	<div style='float:right;'>Time elapsed: 13 minutes</div>
	<h2>Chatroom</h2>
	<div class='inset-box' style='background:#fff;padding:10px;'>
		<div style='width:92%;margin-left:auto;margin-bottom:15px;'>
			<div style='text-align:right;'>
				<div style='display:inline-block;color:#ccc;'>3:36 PM</div>
				<div style='display:inline-block;'>Evan Carlson</div>
			</div>
			<div style='padding:8px;border-radius:8px;background:#deebf7;'>This is what a chat text box will look like. This is what a chat text box will look like. This is what a chat text box will look like. This is what a chat text box will look like. This is what a chat text box will look like. This is what a chat text box will look like. </div>
		</div>
		<div style='width:92%;margin-right:auto;margin-bottom:15px;'>
			<div style='text-align:right;'>
				<div style='display:inline-block;color:#ccc;'>3:36 PM</div>
				<div style='display:inline-block;'>Brandon Lalonde</div>
			</div>
			<div style='padding:8px;border-radius:8px;background:#f5dede;'>I think that is very interesting.</div>
		</div>
	</div>
	<textarea style='margin-top:15px;' class='inset-box' placeholder='Send message...'></textarea>
</div>
<div style='position:absolute;top:50px;left:15px;z-index:1;'>Creating offer: <span id='offer'></span></div>
<script src="js/room.js"></script>
</body>
</html>
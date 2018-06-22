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
<div>Creating offer: <span id='offer'></span></div>
<h1 style='text-align:center;border-top:1px solid #ccc;border-bottom:1px solid #ccc;margin-top:50px;'>Webcam Test</h1>
<div style='display:inline-block;'>
	<video id="local-video" autoplay="" muted></video>
	<div>Local Video</div>
</div>
<div style='display:inline-block;'>
	<video id="remote-video" autoplay=""></video>
	<div>Remote Video</div>
</div>
<script src="js/room.js"></script>
</body>
</html>
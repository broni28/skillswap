<?php if($_SERVER['PHP_SELF'] == '/' . $page['body'] . ".php" && $_SESSION['email']): ?>
<div id='section5-wrap'>
	<div class='text-center'>You have a meeting in 5 minutes <a href='room.php'>Join Room</a></div>
</div>
<?php endif; ?>
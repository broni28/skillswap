<?php if($_SERVER['PHP_SELF'] == '/' . $page['body'] . ".php" && $_SESSION['email']): ?>
<div id='section5-wrap'>
	<div class='text-center'>
		<div><?php echo htmlspecialchars($_SESSION['email']); ?></div>
		<div>You have a meeting in 5 minutes <a href='room.php?id=1'>Join Room</a></div>
	</div>
</div>
<?php endif; ?>
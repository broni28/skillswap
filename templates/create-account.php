<?php
	/*
		This page creates their account. It will validate that there username and password are both less than 100 characters, and then enter there credentials into the database
	*/
	
	
	require_once("/home/ecarlson10/settings.php");
	
	if(
		$_POST['email'] &&
		$_POST['password'] &&
		$_POST['password_confirm'] &&
		$_POST['password'] == $_POST['password_confirm'] &&
		strlen($_POST['email']) < 100 &&
		strlen($_POST['password']) < 100 &&
		strlen($_POST['password_confirm']) < 100 &&
		($_POST['identity'] == 'student' || $_POST['identity'] == 'instructor')
	){
		$stmt = $mysqli->prepare("INSERT INTO webcam_users SET email=?, password=?, role=?");
		$stmt->bind_param("sss", $_POST['email'], $password, $_POST['identity']);
		$password = hash('sha256', $_POST['password']);
		$stmt->execute();
		if($stmt->error){
			echo $stmt->error;
			exit;
		}
		$stmt->close();
	}

	header("Location: /");
	exit;
?>
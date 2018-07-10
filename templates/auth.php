<?php
	/*
		This page checks if the username and password they entered in the sign in form is in the database.
		If it isn't, their IP address will be inserted into a database. If they have more than x number
		of failed attempts, that IP is banned for some duration of time.
	*/
	session_start();
	
	require_once('/home/ecarlson10/settings.php');
	
	if($_POST){
		
		//if they dont have too many failed login attempts
		if(!check_failed_login("webcam")){
			$stmt = $mysqli->prepare("SELECT * FROM webcam_users WHERE email=? AND password=? LIMIT 1");
			$stmt->bind_param("ss", $_POST['email'], $password);
			$password = hash('sha256', $_POST['password']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()){
				$_SESSION['email'] = $row['email'];
			}
			else{
				failed_login("webcam");
			}
		}
	}
	else{
		
		//logout
		unset($_SESSION['email']);
	}
	
	
	header("Location: /account.php");
	exit;
?>
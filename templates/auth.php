<?php
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
		unset($_SESSION['email']);
	}
	
	
	header("Location: /");
	exit;
?>
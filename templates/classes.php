<?php
	class Init{
		public function get_user_info(){
			global $mysqli;
			
			if($_SESSION['email']){				
				$stmt = $mysqli->prepare("SELECT * FROM webcam_users WHERE email=? LIMIT 1");
				$stmt->bind_param("s", $_SESSION['email']);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result){				
					return $result->fetch_assoc();
				}
			}
		}
		private function go_home(){
			header("Location: /");
			exit;
		}
	}

	/*----------------WEBPAGE----------------*/
	class Webpage extends Init{
		public function __construct(){
			
			//checks to make sure they can be on this page
			$this->redirect_protected_page();
		}
		private function redirect_protected_page(){
			global $page;
			
			//if we visit a protected page and we're not logged in
			if($page['protected'] && !$_SESSION['email']){
				$this->go_home();
			}
		}
	}
	
	
	/*----------------ROOM----------------*/
	class Room extends Init{
		public function __construct(){
			
			//checks to make sure user is allowed in the room
			$this->validate_user();
		}
		
		//returns the sender_id and acceptor_id as an array
		public function fetch_ids(){
			
			global $mysqli;
			$role = $this->get_user_info()['role'];

			$stmt = $mysqli->prepare("SELECT * FROM webcam_rooms WHERE id=? LIMIT 1");
			$stmt->bind_param("s", $_GET['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()){
				
				//if we're the instructor
				if($role == 'instructor'){
					return array(
						'sender_id' => $row['instructor_id'],
						'acceptor_id' => $row['student_id'],
						'room_id' => $row['id'],
					);
				}
				elseif($role == 'student'){
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
				$user_info = $this->get_user_info();
				if($user_info){
					
					//if we're allowed to be in the room
					if(is_numeric($_GET['id']) && $user_info['valid_rooms'][$_GET['id']]){
						$this->role = $user_info['role'];
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
	}
?>
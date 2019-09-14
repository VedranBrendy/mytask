<?php 

	class User {

		public function __construct() {
		
		}
		
		
	// Logout & Destroy Session
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_pass']);
      session_destroy();
      header('Location:../index.php');
    }
	}//end class User



 ?>
<?php 
	//Redirect To Page
	function redirect($page = FALSE, $message_title = NULL, $message = NULL, $message_type = NULL){

		if (is_string ($page)) {

			header("Location:". $page);
			
		}

		//Check For Message
		if($message != NULL){
			//Set Message
			$_SESSION['message'] = $message;
		}

		if ($message_title != NULL) {
			//Set message title
			$_SESSION['message_title'] = $message_title;
		}

		//Check For Type
		if($message_type != NULL){

			//Set Message Type
			$_SESSION['message_type'] = $message_type;

			if ($message_type == 'success') {

				$_SESSION['toastr'] = [
					'type'		=> 'success',
					'message'	=> $message,
					'title'   => $message_title
				];

			}	elseif ($message_type == 'danger') {
				$_SESSION['toastr'] = [
					'type'    => 'error', 
					'message' =>  $message,
					'title'  	=> $message_title
				];
			} elseif ($message_type == 'warning') {

				$_SESSION['toastr'] = [
					'type'    => 'warning', 
					'message' =>  $message,
					'title'  	=> $message_title
				];

			} elseif ($message_type == 'info') {

				$_SESSION['toastr'] = [
					'type'    => 'info', 
					'message' =>  $message,
					'title'  	=> $message_title
				];

			}
		}

	}


?>
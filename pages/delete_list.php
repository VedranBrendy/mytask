<?php 

require_once('../functions/init.php');

	$list_id = $_GET['id'];

	$database->query('DELETE FROM lists WHERE id = :id');
	$database->bind(':id',$list_id);
	//Execute
	$database->execute();

	if($database->rowCount() > 0){
			//Show success message -> function redirect(redirect to page, message title, message, message type);
			redirect('home.php','', 'List Deleted', 'success');

		} else {
			//Show error message
		redirect('home.php','', 'Something went wrong', 'danger');

	}


 ?>
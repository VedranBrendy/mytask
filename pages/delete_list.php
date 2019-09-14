<?php 

	require_once('../config/config.php');
  require_once('../classes/Database.php');

	$list_id = $_GET['id'];

	//Instantiate Database object
	$database = new Database;

	$database->query('DELETE FROM lists WHERE id = :id');
	$database->bind(':id',$list_id);
	//Execute
	$database->execute();

	if($database->rowCount() > 0){
			//Show success message -> function redirect(redirect to page, message title, message, message type);
			$database->redirect('home.php','', 'List Deleted', 'success');

		} else {
			//Show error message
			$database->redirect('home.php','', 'Something went wrong', 'danger');

	}


 ?>
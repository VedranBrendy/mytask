<?php 
require_once('../functions/init.php');

	$user = new User($database);
	$user->logout();

 ?>
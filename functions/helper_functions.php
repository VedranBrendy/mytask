<?php 

	//Helper function for date format
	 function dateShow($date){		
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		return $day.".".$month.".".$year;

	}

?>
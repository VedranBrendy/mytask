<?php
	/* 
   *  PDO DATABASE CLASS
   *  Connects Database Using PDO
	 *  Creates Prepeared Statements
	 * 	Binds params to values
	 *  Returns rows and results
   */
   
   	
class Database {
	
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	private $dbh;
	private $error;
	private $stmt;
	
	public function __construct() {
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);

		// Create a new PDO instanace
		try {
			$this->dbh = new PDO ($dsn, $this->user, $this->pass, $options);
		}		// Catch any errors
		catch ( PDOException $e ) {
			$this->error = $e->getMessage();
		}
	}
	
	// Prepare statement with query
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	// Bind values
	public function bind($param, $value, $type = null) {
		if (is_null ($type)) {
			switch (true) {
				case is_int ($value) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool ($value) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null ($value) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	
	// Execute the prepared statement
	public function execute(){
		return $this->stmt->execute();
	}
	
	// Get result set as array of objects
	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	// Get single record as object
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	// Get record row count
	public function rowCount(){
		return $this->stmt->rowCount();
	}
	
	// Returns the last inserted ID
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}
	public function closeDB($dbh) {
	
    	$db = null; 

	}


	//Redirect To Page
	function redirect($page = FALSE, $message_title = NULL, $message = NULL, $message_type = NULL){


		if (is_string ($page)) {
			$location = $page;
		} else {
			$location = $_SERVER ['SCRIPT_NAME'];
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
		//Redirect
		header ('Location: '.$location);
		exit; 
	}
//Helper function for date format
	public function dateShow($date){		
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		return $day.".".$month.".".$year;

	}

}
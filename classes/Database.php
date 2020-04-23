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

	// GET INFO FROM DB FOR COUNT LISTS
	public function countOfLists($user_id){

		$this->user_id = $user_id;
	
		$this->query("SELECT * FROM lists WHERE list_user = $user_id");
		//Execute
		$this->execute();
		$rows = $this->resultset();
		$countOfLists = $this->rowCount();
		return $countOfLists;
	}

	// GET INFO FROM DB FOR ROW COUNT
	public function countOfListRows(){
	
		$this->query("SELECT * FROM lists");
		//Execute
		$this->execute();
		$rows = $this->resultset();
		return $rows;
	}

	//Number task in list
	public function tasksInList($id){

		$this->id = $id;

		$this->query("SELECT * FROM lists 
				INNER JOIN tasks 
				ON tasks.list_id = lists.id 
				WHERE list_user = $id");
		//Execute
		$this->execute();
		return $lines = $this->resultset();
	}

	// GET INFO FROM DB FOR COUNT OF ACTIV TASKS
	public function countOfActivTasks($id){

		$this->id = $id;
		
		$this->query("SELECT * FROM lists 
				INNER JOIN tasks 
				ON tasks.list_id = lists.id 
				WHERE list_user = $id AND is_complete = 0");
		//Execute
		$this->execute();
		return $countOfActivTasks = $this->rowCount();
	}

	//Count of completed tasks
	public function countOfCompletedTasks($id){

		$this->id = $id;
		$this->query("SELECT * FROM lists 
				INNER JOIN tasks 
				ON tasks.list_id = lists.id 
				WHERE list_user = $id AND is_complete = 1");
		//Execute
		$this->execute();
		return $countOfCompletedTasks = $this->rowCount();

	}

	// GET COUNT OF TASKS
	public function tasksCount($rowID){

		$this->id = $rowID;

		$this->query("SELECT COUNT(*) AS count FROM tasks WHERE list_id = $rowID");
		//Execute
		$this->execute();
		return $tasksCount = $this->resultset();

	}

	//Select list id for inserting in tasks list
	public function listIdToDB($id){

		$this->id = $id;

		//Query
		$this->query('SELECT * FROM lists WHERE id = :id');
		$this->bind(':id', $id);
		$this->execute();
		return $row = $this->single();

	}


}
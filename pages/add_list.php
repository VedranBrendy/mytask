<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>

<?php 


if (isset($_POST['add_list'])) {

	// Check if POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    // Sanitize POST
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		$data = [
			'list_name' => trim($_POST['list_name']),
			'list_body' => trim($_POST['list_body']),
			'list_name_error' => '',
			'list_body_error' => ''
		];

		if (empty($data['list_name'])) {
			$data['list_name_error'] = 'Insert Task List Name!';
		}

		if (empty($data['list_body'])) {
			$data['list_body_error'] = 'Insert List Description!';
		}

	} else {

		$data = [
			'list_name' => '',
			'list_body' => '',
			'list_name_error' => '',
			'list_body_error' => ''
		];

	}

    //Make sure errors are empty
	if (empty($data['list_name_error']) && empty($data['list_body_error'])) {
      //Validate
		$list_name = $data['list_name'];
		$list_body = $data['list_body'];
		$list_user = $_SESSION['user_id'];

		    //Query
		$database->query('INSERT INTO lists (list_name, list_body, list_user) VALUES(:list_name, :list_body, :list_user)');
		$database->bind(':list_name', $list_name);
		$database->bind(':list_body', $list_body);
		$database->bind(':list_user', $list_user);
				
		    //Execute
		$database->execute(); 

	  //If row was inserted
		if ($database->lastInsertId()) {
			//Show success message -> function redirect(redirect to page, message title, message, message type);
			redirect('home.php','', 'List Added', 'success');

		} else {
			//Show error message
			redirect('home.php','', 'Something went wrong', 'danger');

		}

	}

}

?>


<div class="container">
	<div class="row">
		<div class="col"></div>
		<div class="col-md-6 mt-4">
			<!-- Card -->
			<div class="card">

			  <!-- Card content -->
			  <div class="card-body">
			  	 <h4 class="card-title">Add Task List</h4>
    			<hr class="hr-dark">

			  	<form action="add_list.php" method="POST">
            <!-- Small input -->
		        <div class="form-group">
		    			<input type="text" name="list_name" class="form-control <?php echo (!empty($data['list_name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['list_name']) ? $_POST['list_name'] : '' ?>" placeholder="Input Task List Name">
		          <span class="invalid-feedback"><?php echo $data['list_name_error']; ?></span>
		    		</div>

    				<div class="form-group">						    
    				  <input type="text" name="list_body" class="form-control <?php echo (!empty($data['list_body_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['list_body']) ? $_POST['list_body'] : '' ?>" placeholder="Input Task List Description">
              <span class="invalid-feedback"><?php echo $data['list_body_error']; ?></span>
    				</div> 
    				<hr class="hr-dark">           
    						                
              <button class="btn btn-sm btn-teal float-right" type="submit" name="add_list">Add List</button>
            	
          </form>

			  </div>

			</div>
			<!-- Card -->
		</div>
		<div class="col"></div>
	</div>
</div>

<?php include_once('../assets/footer.php'); ?>
 


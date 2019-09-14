<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>

<?php 

require_once('../config/config.php');
require_once('../classes/Database.php');


if (isset($_POST['add_task'])) {

  //die('BUTTON ADD TASK PRESSED');

//Testing inputs
 /*  echo $_POST['task_name'] . '<br>';
  echo $_POST['task_body'] . '<br>';
  echo $_POST['list_name'] . '<br>';
  echo $_POST['due_date'] . '<br>';
  die(); */

  // Check if POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $database = new Database;
    // Sanitize POST
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'task_name' => trim($_POST['task_name']),
      'list_name' => $_POST['list_name'],
      'task_body' => trim($_POST['task_body']),
      'task_name_error' => '',
      'task_body_error' => ''
    ];

    if (empty($data['task_name'])) {
      $data['task_name_error'] = 'Insert Task Name!';
    }

    if (empty($data['task_body'])) {
      $data['task_body_error'] = 'Insert Task Description!';
    }

  } else {

    $data = [
      'task_name' => '',
      'task_body' => '',
      'task_name_error' => '',
      'task_body_error' => ''
    ];

  }

  //Make sure errors are empty
  if (empty($data['task_name_error']) && empty($data['task_body_error'])) {
      //Validate
    $task_name = $data['task_name'];
    $task_body = $data['task_body'];
    $list_id = $_POST['list_id'];
    $due_date = $_POST['due_date'];

      //Query
    $database->query('INSERT INTO tasks (task_name, task_body, list_id, due_date) VALUES(:task_name,:task_body, :list_id, :due_date)');
    $database->bind(':task_name', $task_name);
    $database->bind(':task_body', $task_body);
    $database->bind(':list_id', $list_id);
    $database->bind(':due_date', $due_date);

        
    //Execute
    $database->execute(); 

    //If row was inserted
		if ($database->lastInsertId()) {
			//Show success message -> function redirect(redirect to page, message title, message, message type);
			$database->redirect('home.php','', 'Task Added', 'success');

		} else {
			//Show error message
			$database->redirect('home.php','', 'Something went wrong', 'danger');

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
           <h4 class="card-title">Add Task in List</h4>
          <hr class="hr-dark">

        <form action="add_task.php" method="POST">
                <!-- Small input -->

            <div class="form-group">
              <input type="text" name="task_name" class="form-control <?php echo (!empty($data['task_name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['task_name']) ? $_POST['task_name'] : '' ?>" placeholder="Input Task Name">
                  <span class="invalid-feedback"><?php echo $data['task_name_error']; ?></span>
            </div>

            <div class="form-group">                
                <input type="text" name="task_body" class="form-control <?php echo (!empty($data['task_body_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['task_body']) ? $_POST['task_body'] : '' ?>" placeholder="Input Task Description">
                    <span class="invalid-feedback"><?php echo $data['task_body_error']; ?></span>
            </div> 

            <?php 

            $user_id = $_SESSION['user_id'];
            $database->query("SELECT id, list_name FROM lists WHERE list_user = $user_id");
            
            //Execute
            $database->execute();
            $rows = $database->resultset();

            //Testing dropdown
            /* if ($database->rowCount() > 0) {
              foreach ($rows as $row) {
                echo $row['id'];
                echo $row['list_name'];
              }
            } */
            ?>

            <div class="form-group">
              <select class="custom-select" name="list_id">
                <option value="0">--Choose Task list--</option>
                  <?php foreach ($rows as $row) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['list_name']; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <input name="due_date" type="date" class="form-control datepicker">    
            </div>

            <hr class="hr-dark">           
                                
            <button class="btn btn-sm btn-primary float-right" type="submit" name="add_task">Add Task</button>
              
        </form>

        </div>

      </div>
      <!-- Card -->
    </div>
    <div class="col"></div>
  </div>
</div>
<?php include_once('../assets/footer.php'); ?>
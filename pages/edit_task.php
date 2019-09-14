<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>

<?php 

require_once('../config/config.php');
require_once('../classes/Database.php');

$id = (int)$_GET['id'];


if (isset($_POST['edit_task']) && isset($_POST['id'])) {

  // Check if POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $database = new Database;
        // Sanitize POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'task_name' => trim($_POST['task_name']),
            'task_body' => trim($_POST['task_body']),
            'list_id' => $_POST['list_id'],
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

        if (isset($_POST['checkbox'])) {

            $is_complete = '1';

        } else {

            $is_complete = '0'; 

        }

        

        //Query
        $database->query("UPDATE tasks SET task_name = :task_name, task_body = :task_body, list_id = :list_id, due_date = :due_date, is_complete = :is_complete WHERE id = :id");

        $database->bind(':task_name', $task_name);
        $database->bind(':task_body', $task_body);
        $database->bind(':list_id', $list_id);
        $database->bind(':id', $id);
        $database->bind(':due_date', $due_date);
        $database->bind(':is_complete', $is_complete);

        
    //Execute
    $database->execute();

    if ($database->rowCount()) {
      //Show success message -> function redirect(redirect to page, message title, message, message type);

      if (isset($_POST['checkbox']) == '1') {

          $database->redirect('home.php','', 'Task Completed', 'info');


        }elseif (isset($_POST['checkbox']) == '0') {

          $database->redirect('home.php','', 'Task Activated', 'danger');

        }

			$database->redirect('home.php','', 'Task Updated', 'warning');

		} else {
			//Show error message
			$database->redirect('home.php','', 'Something went wrong', 'danger');

		}

  }

}

//Query
$database->query('SELECT * FROM tasks WHERE id = :id');
$database->bind(':id', $id);
$row = $database->single();
//Execute
$database->execute();

?>

<div class="container">
  <div class="row">
    <div class="col"></div>
    <div class="col-md-6 mt-4">
      <!-- Card -->
      <div class="card">

        <!-- Card content -->
        <div class="card-body">
           <h4 class="card-title">Edit Task in List</h4>
          <hr class="hr-dark">

        <form action="edit_task.php?id=<?php echo $id; ?>" method="POST">
                <!-- Small input -->
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" class="form-control"/> 
               
            <div class="form-group">
              <input type="text" name="task_name" class="form-control <?php echo (!empty($data['task_name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $row['task_name']; ?>" placeholder="Task Name">
                  <span class="invalid-feedback"><?php echo $data['task_name_error']; ?></span>
            </div>

            <div class="form-group">                
                <input type="text" name="task_body" class="form-control <?php echo (!empty($data['task_body_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $row['task_body']; ?>"  placeholder="Task Description">
                    <span class="invalid-feedback"><?php echo $data['task_body_error']; ?></span>
            </div> 
            <?php 

            $user_id = $_SESSION['user_id'];
            $database->query("SELECT id, list_name FROM lists WHERE list_user = $user_id");
                        
            //Execute
            $database->execute();
            $lines = $database->resultset();

            ?>

            <div class="form-group">
              <select class="custom-select" name="list_id">
                <option value="0">--Choose Task list--</option>
                  <?php foreach ($lines as $line) : ?>
                  
                  <?php if ($line['id'] == $row['list_id']) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    ?>
                    <option value="<?php echo $line['id']; ?>"<?php echo $selected; ?> ><?php echo $line['list_name']; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
           
                <div class ="form-group" >
                    <input name="due_date" type="date" class="form-control datepicker" value="<?php echo $row['due_date']; ?>">
                </div>

                 <div class ="form-group" >

                <div class="custom-control custom-checkbox">
                    <?php 
                    if ($row['is_complete'] == 1 ): ?>

                        <!-- Default checked -->                
                        <input type="checkbox" name="checkbox" class="custom-control-input" id="defaultUnchecked" checked>
                        <label class="custom-control-label" for="defaultUnchecked">Task Completed</label>
                    
                        <?php else : ?>

                        <input type="checkbox" name="checkbox" class="custom-control-input" id="defaultUnchecked">
                        <label class="custom-control-label" for="defaultUnchecked">Task Completed</label>
                        
                    <?php endif; ?>
    
                    </div><!-- //custom-checkbox -->
                </div><!-- //form-froup -->


                <hr class="hr-dark">
                <button class="btn btn-sm btn-primary float-right" type="submit" name="edit_task">Edit Task</button>
        </form>
        </div>
        </div>
        <!--Card -->
    </div>
        <div class="col"></div>
    </div>
</div>
<?php include_once('../assets/footer.php'); ?>


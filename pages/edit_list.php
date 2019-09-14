<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>

<?php 

require_once('../config/config.php');
require_once('../classes/Database.php');

$id = (int)$_GET['id'];

if (isset($_POST['edit_list']) && isset($_POST['id'])) {

      // Check if POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $database = new Database;

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
    $id = $_POST['id'];

        //Query
    $database->query('UPDATE lists SET list_name = :list_name, list_body = :list_body, list_user = :list_user WHERE id = :id');

    $database->bind(':id', $id);
    $database->bind(':list_name', $list_name);
    $database->bind(':list_body', $list_body);
    $database->bind(':list_user', $list_user);   
        
        //Execute
    $database->execute();

    if ($database->rowCount()) {
     	//Show success message -> function redirect(redirect to page, message title, message, message type);
			$database->redirect('home.php','', 'List updated', 'warning');

		} else {
			//Show error message
			$database->redirect('home.php','', 'Something went wrong', 'danger');

		}

  }

}

//Query
$database->query('SELECT * FROM lists WHERE id = :id');
$database->bind(':id', $id);
$row = $database->single();

?>

<div class="container">
  <div class="row">
    <div class="col"></div>
    <div class="col-md-6 mt-4">
      <!-- Card -->
      <div class="card">

        <!-- Card content -->
        <div class="card-body">
          <h4 class="card-title">Edit Task List</h4>
          <hr class="hr-dark">

         <form action="edit_list.php?id=<php echo $id; ?>" method="POST">
            <!-- Small input -->
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" class="form-control"/>     
            <div class="form-group">
              <input type="text" name="list_name" class="form-control <?php echo (!empty($data['list_name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $row['list_name']; ?>">
              <span class="invalid-feedback"><?php echo $data['list_name_error']; ?></span>
            </div>

            <div class="form-group">                
                <input type="text" name="list_body" class="form-control <?php echo (!empty($data['list_body_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $row['list_body']; ?>">
                <span class="invalid-feedback"><?php echo $data['list_body_error']; ?></span>
            </div>
              <hr class="hr-dark">
                            
                <button class="btn btn-sm orange lighten-2 float-right mt-3" type="submit" name="edit_list">Edit List</button>
       
          </form>
        </div>

      </div>
      <!-- Card -->
    </div>
    <div class="col"></div>
  </div>
</div>
<?php include_once('../assets/footer.php'); ?>
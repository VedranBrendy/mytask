<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>


<?php 

$user_id = $_SESSION['user_id'];
$database = new Database;

$countOfLists = $database->countOfLists($user_id);
$countOfActivTasks = $database->countOfActivTasks($user_id);
$countOfCompletedTasks =  $database->countOfCompletedTasks($user_id);

//LINES == TASKS TABLE 
//ROWS 	== LISTS TABLE
?>

<div class="container mt-3">

	<div class="row">
		<h3 class="mb-3 ml-3">Your Task list</h3>

		<small><p class="text-uppercase ml-5 pt-1"><strong>Tasks Lists</strong></p></small>
		<h5 class="pl-2"><span class="badge badge-success float-right p-1"><?php echo $countOfLists; ?></span></h5>

		<small><p class="text-uppercase ml-3 pt-1"><strong>Active tasks</strong></p></small>
		<h5 class="pl-2"><span class="badge badge-danger float-right p-1"><?php echo $countOfActivTasks; ?></span></h5>

		<small><p class="text-uppercase ml-3 pt-1"><strong>Completed Tasks</strong></p></small>
		<h5 class="pl-2"><span class="badge badge-info float-right p-1"><?php echo $countOfCompletedTasks; ?></span></h5>

	</div>


<?php

if ($countOfLists > 0) { 

	$rows = $database->countOfListRows();

	foreach ($rows as $row) {

			?>
		
			<div id="accordion">
				<div class="card mb-3 bordered">
				<div class="card-header" id="<?php echo $row['list_name']; ?>headingOne">				
					
					<div class="row align-items-center">
					<div class="col-md-4">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $row['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
							<?php 
							// GET COUNT OF TASKS
							$records = $database->tasksCount($row['id']);

							foreach ($records as $record) {
							
							?>	
					
							<h6><strong><?php echo $row['list_name']; ?></strong></h6>

						</button>
					</div>
	
					<div class="col-md-4">
					<!-- BADGE FOR NUMBER OF TASKS IN LIST -->
						<h4><span class="badge mt-1 stylish-color float-right">
							<?php echo $taskCount = floatval($record['count']);?>
						</span></h4>
						<small class="pr-2 float-right text-uppercase">Tasks In List</small>
					</div>

					<div class="col-md-4">
					
						<a href="edit_list.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" name="edit_list" role="button">Edit</a>

			
						<?php 
							if (!$countOfActivTasks == 0) {
								?>
								<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Finish All Your Tasks In List, Then Delete It">Delete</button>
								<?php
							} else {
								?>

								<a class="btn btn-sm btn-danger" href="delete_list.php?id=<?php echo $row['id']; ?>"  data-toggle="tooltip" data-placement="top" title="Delete Task">Delete</a>

								<?php
								
							}
						?>
	
					</div>	
					</div><!-- /ROW -->

					

					</div><!-- /card-header -->
					<div id="collapse<?php echo $row['id']; ?>" class="collapse" aria-labelledby="<?php echo $row['list_name']; ?>headingOne" data-parent="#accordion">
					<div class="card-body">

						<small><p class="ml-5 text-uppercase">
							<?php echo '<strong>Task description: </strong>'. $row['list_body']; ?></p></small>
						
					<?php if ($database->rowCount() > 0) { ?>	
					<div class="row">
						
						<div class="col-md-6">
						<p class="text-uppercase ml-5 text-danger"><strong>Active tasks</strong></p>
						<?php

						$lines = $database->tasksInList($user_id);

							foreach ($lines as $line) {

								if ($line['list_id'] == $row['id'] && $line['is_complete'] == 0) {

						?>
						
					<div class="ml-5 mb-2 text-uppercase">
						<p><a href="edit_task.php?id=<?php echo $line['id']; ?>" name="edit_task" class="active-task-link">
						<?php echo $line['task_name']; ?></a>
							<small class="ml-2 font-weight-bold"><?php echo dateShow($line['due_date']); ?></small>
						</p>										
					</div>

				<?php

				}
				
			}
									
						?>	

						</div>

						<div class="col-md-6">
						<p class="text-uppercase ml-5 text-info"><strong>completed tasks</strong></p>
						<?php
							foreach ($lines as $line) {

								if ($line['list_id'] == $row['id'] && $line['is_complete'] == 1) {


								?>
						
					<div class="ml-5 mb-2 text-uppercase">
						<p><a href="edit_task.php?id=<?php echo $line['id']; ?>" name="edit_task" class="completed-task-link">
						<?php echo $line['task_name']; ?></a>
							<small class="ml-2 font-weight-bold">Duo date: <?php echo $line['due_date']; ?></small>
						</p>										
					</div>

				<?php

				}
			}
							
						
						?>						
						
						</div>

					</div>	
						
						<?php		

						}
					}

					?>

					      </div>
					    </div>
					  </div>					
					</div><!--accordion end-->
				<?php
				
			
		}//end foreach

		$database->closeDB($database);
	} else {

		?>
   		<h5 class="mt-5">No records! Create your Tasks List</h5>

   	<?php

	}

	?>    	
 
</div>


<?php 
if (isset($_GET['id']) && !empty($_GET['id']) && (int)$_GET['id'] > 0) {

		$list_id = (int)$_GET['id'];

		$database->listIdToDB($list_id);

}

?>

<?php include_once('../assets/footer.php'); ?>



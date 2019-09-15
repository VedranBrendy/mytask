<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>myTasks | Register</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<?php if (isset($_POST['registerBtn'])) {


    require_once('../config/config.php');
    require_once('../classes/Database.php'); 

      //Instantiate Database object
      $database = new Database;

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $data = [

            'regfname' => trim($_POST['regfname']),
            'reglname' => trim($_POST['reglname']),
            'regusername' => trim($_POST['regusername']),
            'regemail' => trim($_POST['regemail']),
            'regpass' => trim($_POST['regpass']),
            'confregpass' => trim($_POST['confregpass']),
            'regfname_error' => '',
            'reglname_error' => '',
            'regusername_error' => '',
            'regemail_error' => '',
            'regpass_error' => '',
            'confregpass_error' => ''

            ];

          if (empty($data['regfname'])) {
              $data['regfname_error'] = 'Insert Your First Name!';
          }

          if (empty($data['reglname'])) {
              $data['reglname_error'] = 'Insert Your Last Name!';
          }

           if (empty($data['regusername'])) {
              $data['regusername_error'] = 'Insert Your User Name!';
          }

          /* Check to see if username has been used */
          //Query
          $database->query('SELECT username FROM users WHERE username = :username');
          $database->bind(':username', $data['regusername']);  
          //Execute
          $database->execute();
          if($database->rowCount() > 0){
            $data['regusername_error'] = "Sorry, that username is taken";
          }

          if (empty($data['regemail'])) {
              $data['regemail_error'] = 'Insert Your Email!';
          }

          /* Check to see if email has been used */
          //Query
          $database->query('SELECT email FROM users WHERE email = :email');
          $database->bind(':email', $data['regemail']);  
          //Execute
          $database->execute();
          if($database->rowCount() > 0){
            $data['regemail_error'] = "Sorry, that email is taken";
          }

           if (empty($data['regpass'])) {
              $data['regpass_error'] = 'Insert Your Password!';
          } elseif (strlen($data['regpass']) < 6) {
             $data['regpass_error'] = 'Password must have atleast 6 characters';
          }

          if (empty($data['confregpass'])) {
              $data['confregpass_error'] = 'Confirm Inserted Password!';
          } elseif ($data['confregpass'] != $data['regpass']) {
             $data['confregpass_error'] = 'Password do not match.';
          }

      }
 
      //Make sure errors are empty
      if (empty($data['regfname_error']) && empty($data['reglname_error']) && empty($data['regusername_error']) && empty($data['regemail_error']) && empty($data['regpass_error']) && empty($data['confregpass_error'])) {
        //Validate
          //Encrypt Password
          $enc_password = password_hash($data['regpass'], PASSWORD_BCRYPT);

          //Query
          $database->query('INSERT INTO users (first_name, last_name, email, username, password)
                        VALUES(:first_name, :last_name, :email, :username, :password)');
          //Bind Values
          $database->bind(':first_name', $data['regfname']);  
          $database->bind(':last_name', $data['reglname']);   
          $database->bind(':email', $data['regemail']);  
          $database->bind(':username', $data['regusername']);  
          $database->bind(':password', $enc_password);  

          //Execute
          $database->execute(); 

      }//Make sure errors are empty if statement 

      //If row was inserted
      if($database->lastInsertId()){

        header("Location: ../index.php");
		
      }
    
  }//first if statement
   
?>
<!--REGISTER FORM--> 
<div class="container">
  <div class="row">
    <div class="col-3">
    </div>
    <div class="col-6 mt-5 login-divcard">

      <!--Card-->
      <div class="card mt-5">

          <!--Card content-->
          <div class="card-body">
              <!--Title-->
              <h4 class="card-title text-center">MyTasks register form</h4>
              <!--Text-->

              <!-- Default form register -->

                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <!-- Default input name -->
                    <label for="regfname">Your first name</label>
                    <input type="text" name="regfname" class="form-control form-control-sm <?php echo (!empty($data['regfname_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo isset($_POST['regfname']) ? $_POST['regfname'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['regfname_error']; ?></span>
                    
                    <br>
                    <!-- Default input name -->
                    <label for="reglname">Your last name</label>
                    <input type="text" name="reglname" class="form-control form-control-sm <?php echo (!empty($data['reglname_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo isset($_POST['reglname']) ? $_POST['reglname'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['reglname_error']; ?></span>
                    
                    <br>
                    <!-- Default input name -->
                    <label for="regusername">Your user name</label>
                    <input type="text" name="regusername" class="form-control form-control-sm <?php echo (!empty($data['regusername_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['regusername']) ? $_POST['regusername'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['regusername_error']; ?></span>
                    
                    <br>
                    
                    <!-- Default input email -->
                    <label for="defaultFormEmailModalEx">Your email</label>
                    <input type="email" name="regemail" class="form-control form-control-sm <?php echo (!empty($data['regemail_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo isset($_POST['regemail']) ? $_POST['regemail'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['regemail_error']; ?></span>
                    
                    <br>

                     <!-- Default input email -->
                    <label for="defaultFormEmailModalEx">Password</label>
                    <input type="password" name="regpass" class="form-control form-control-sm <?php echo (!empty($data['regpass_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo isset($_POST['regpass']) ? $_POST['regpass'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['regpass_error']; ?></span>
                    
                    <br>
                     <!-- Default input email -->
                    <label for="defaultFormEmailModalEx">Comfirm password</label>
                    <input type="password" name="confregpass" class="form-control form-control-sm <?php echo (!empty($data['confregpass_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo isset($_POST['confregpass']) ? $_POST['confregpass'] : '' ?>">
                    <span class="invalid-feedback"><?php echo $data['confregpass_error']; ?></span>
                    
                    <br>

                    <div class="text-center mt-4">
                        <button class="btn btn-default btn-block" name="registerBtn" type="submit">Register</button>
                    </div>
                    
                  </form>
          </div>
      </div>
      <!--/.Card-->
     
      <!-- Material form login -->
    </div>
    <div class="col-3"></div>

    </div>
</div>    
<!--REGISTER FORM--> 
              

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="../js/mdb.min.js"></script>

        <script type="text/javascript">
    $(document).ready(function(){
     
        <?php
        // toastr output & session reset
         if(isset($_SESSION['toastr'])){
            echo 'toastr.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['message'].'", "'.$_SESSION['toastr']['title'].'")';
            unset($_SESSION['toastr']);
        } 
        ?>          
    });
</script> 
</body>

</html>
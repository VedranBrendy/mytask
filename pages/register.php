<?php if (isset($_POST['registerBtn'])) {

  require_once('../function/init.php');

  $user = new User($database);

  // Check if POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    /*           $database->query('SELECT username FROM users WHERE username = :username');
          $database->bind(':username', $data['regusername']);  
         
          $database->execute(); */

    if ($database->rowCount() > 0) {
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
    if ($database->rowCount() > 0) {
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
  } //Make sure errors are empty if statement 

  //If row was inserted
  if ($database->lastInsertId()) {

    header("Location: login.php");
  }
} //first if statement

?>
<?php include_once('../assets/header.php'); ?>
<?php include_once('../assets/navbar.php'); ?>
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
            <input type="text" name="regfname" class="form-control form-control-sm <?php echo (!empty($data['regfname_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['regfname']) ? $_POST['regfname'] : '' ?>">
            <span class="invalid-feedback"><?php echo $data['regfname_error']; ?></span>

            <br>
            <!-- Default input name -->
            <label for="reglname">Your last name</label>
            <input type="text" name="reglname" class="form-control form-control-sm <?php echo (!empty($data['reglname_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['reglname']) ? $_POST['reglname'] : '' ?>">
            <span class="invalid-feedback"><?php echo $data['reglname_error']; ?></span>

            <br>
            <!-- Default input name -->
            <label for="regusername">Your user name</label>
            <input type="text" name="regusername" class="form-control form-control-sm <?php echo (!empty($data['regusername_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['regusername']) ? $_POST['regusername'] : '' ?>">
            <span class="invalid-feedback"><?php echo $data['regusername_error']; ?></span>

            <br>

            <!-- Default input email -->
            <label for="defaultFormEmailModalEx">Your email</label>
            <input type="email" name="regemail" class="form-control form-control-sm <?php echo (!empty($data['regemail_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['regemail']) ? $_POST['regemail'] : '' ?>">
            <span class="invalid-feedback"><?php echo $data['regemail_error']; ?></span>

            <br>

            <!-- Default input email -->
            <label for="defaultFormEmailModalEx">Password</label>
            <input type="password" name="regpass" class="form-control form-control-sm <?php echo (!empty($data['regpass_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['regpass']) ? $_POST['regpass'] : '' ?>">
            <span class="invalid-feedback"><?php echo $data['regpass_error']; ?></span>

            <br>
            <!-- Default input email -->
            <label for="defaultFormEmailModalEx">Comfirm password</label>
            <input type="password" name="confregpass" class="form-control form-control-sm <?php echo (!empty($data['confregpass_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['confregpass']) ? $_POST['confregpass'] : '' ?>">
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


<?php include_once('../assets/footer.php'); ?>
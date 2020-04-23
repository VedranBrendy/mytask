<?php

class User
{

  private $db;
  public $username;


  public function __construct($db)
  {

    $this->db = new Database;
  }

  public function getUser()
  {

    $query = "SELECT * FROM users WHERE username = :username";
    $this->db->bind(':username', $this->username);

    //Execute
    $this->db->execute();
    $row = $this->db->single();
  }


  /* Check to see if username has been used */
  public function checkUsernameIfInDB($username)
  {
    $this->username = $username;
    //Query
    $query = 'SELECT username FROM users WHERE username = :username';
    // Prepare statement
    $this->db->query($query);
    // Bind
    $this->db->bind(':username', $username, PDO::PARAM_STR);
    //Execute
    $this->db->execute();

    if ($username == true) {
      return true;
      die("Našao ime u bazi");
    } else {
      return false;
      die("nema imena u bazi");
    }
  }



  // Logout & Destroy Session
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_pass']);
    session_destroy();
    header('Location:../index.php');
  }
}//end class User

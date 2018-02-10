<?php
session_start();

  //login
  function beginUserSession(){
    $_SESSION['username'] = $_POST['username'];
    $username = $_SESSION['username'];
  }

  //logout
  if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
  }

?>

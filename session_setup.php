<?php
//session_setup.php

session_start();

  if(!isset($_SESSION['username'])) {
    $_SESSION['username'] = "";
    $_SESSION['logged_in'] = false;
  }
  if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = "";
  }
  if(!isset($_SESSION['user_rgba'])) {
    $_SESSION['user_rgba'] = "";
  }
  if(!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
  }

?>

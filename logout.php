<?php
session_start();

  //logout
  $_SESSION['logged_in'] = false;
  unset($_SESSION);
  session_destroy();
  header("Location: index.php");
  exit;

?>

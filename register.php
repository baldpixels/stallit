<?php
require 'database.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }

  $stmt->bind_param('ss', $username, $password);

  $stmt->execute();

  $stmt->close();

?>

<?php
//databse.php

	$server = 'localhost';
	$username   = 'stallman';
	$password   = 'stallman';
	$database   = 'stallit';

	$mysqli = new mysqli($server, $username, $password, $database);

	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
?>

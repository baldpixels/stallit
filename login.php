<?php
require 'database.php';

  $validUser = false;

  $stmt = $mysqli->prepare("select username from users where password='" . $password . "'");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }

  $stmt->execute();

  $stmt->bind_result($usernameQ);

  echo "<ul>\n";
  while($stmt->fetch()){
  	printf("\t<li>%s %s</li>\n",
  		htmlspecialchars($usernameQ));
  }
  echo "</ul>\n";

  $stmt->close();

  if ($validUser) {
    beginUserSession();
  }

?>

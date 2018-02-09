<?php
session_start();

  function beginUserSession(){
    $_SESSION['username'] = $_POST['username'];
    $username = $_SESSION['username'];
    $user_picture = scandir(sprintf("public_user_pics/%s", htmlentities($username)), 1);
    $_SESSION['userPic'] = $user_picture[0];
  }

  if(isset($_POST['logout'])){
    echo '<div id="logBox">';
    echo "you've been logged out.";
    echo '</div>';
    session_unset();
    session_destroy();
  }

?>

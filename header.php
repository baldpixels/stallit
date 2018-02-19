<!DOCTYPE html>
<html>
  <head>
    <title>stall'it</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Vlad Pixels">
    <meta name="description" content="a social network for toilet users">
    <meta name="keywords" content="">
    <!-- style -->
    <link rel="stylesheet" href="css/restroom.css">
    <link rel="stylesheet" href="css/user_bar.css">
    <style>
    .user {color: rgba(<?php echo $_SESSION['user_rgba'] ?>);}
    </style>
  </head>

  <body>
    <div id="wrapper">
      <div id="header">
        <div id="logo">
          <img src="img/stalin_wide.png" alt="" />
          <a href="index.php"><h1>stall'it</h1></a>
        </div>

        <div id="user_bar">

          <?php
            //if logged in
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
              //user controls
              include 'user_controls.php';

              //user message
              echo '<div id="user_msg">
                      good to see you, <span class="user" style="color: rgba(' . $_SESSION['user_rgba'] . ');">' . $_SESSION['username'] . '</span>
                    </div>';

              //logout box
              echo '<div id="logout_box">
                      <form method="post" action="logout.php">
                        <input type="submit" value="logout" />
                      </form>
                    </div>';
            }
            //if not logged in
            else {
              //welcome message
              if(!isset($_SESSION['log'])) {
                $_SESSION['log'] = "<h4>welcome to stall'it</h4>
                        <p>have a look around, try the toilet paper, make an account (or login)</p>";
              }

              //login to account
              echo '<div id="login_box">
                      <form method="post" action="login.php" >
                        <input name="username" required="required" type="text" maxlength="18" size="18" placeholder="username" />
                        <input name="password" required="required" type="password" placeholder="password" />
                        <input type="submit" value="login" />
                      </form>
                    </div>';

              //or register for account
              echo '<div id="register_box">
                      <form method="post" action="register.php">
                      <input name="username" required="required" type="text" maxlength="18" size="18" placeholder="username" />
                      <input name="password" required="required" type="password" placeholder="password" />
                      <input name="password_check" required="required" type="password" placeholder="password again" />
                      <input type="submit" value="or register" />
                      </form>
                    </div>';

              }
          ?>

        </div> <!-- end user_wrapper -->

      </div> <!-- end userBar -->

<!DOCTYPE html>
<html>
<head>
  <title>News Site</title>
  <link rel="stylesheet" href="css/">
  <?php include 'sessionSetup.php'?>
</head>
<body>
  <h1>Welcome to Stall'it</h1>

  <img id="bg_img" src="img/stall_doors.jpg" alt="stall_doors" />

<!-- if logged in-->
  <!-- view stories and comments -->
  <!-- submit story commentary -->
  <!-- comment on story -->
  <!-- edit/delete user's stories -->

<!-- if not logged in -->
  <!-- login to account -->
  <div id="login_box">
    <h2>Login</h2>
    <form action="" >
      <input id="username" name="username" required="required" type="text" placeholder="username" />
      <input id="password" name="password" required="required" type="password" placeholder="" />
      <input type="submit" value="login" />
    </form>
  </div>

  <!-- or register for account -->
  <div id="register_box">
    <h2>or Register</h2>
    <form action="">
      <input type="submit" value="sign me up" />
    </form>
  </div>



</body>
</html>

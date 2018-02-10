<!DOCTYPE html>
<html>
<head>
  <title>Stall'it</title>
  <link rel="stylesheet" href="css/">
  <?php include 'session_setup.php'?>
</head>
<body>
  <h1>This is Stall'it</h1>

  <img id="bg_img" src="img/stall_doors.jpg" alt="stall_doors" />

<!-- if logged in-->
  <!-- view stories and comments -->
  <!-- submit story commentary -->
  <!-- comment on story -->
  <!-- edit/delete user's stories -->

<!-- if not logged in -->
  <!-- login to account -->
  <div id="login_box">
    <h2>login</h2>
    <form action="login.php" >
      <input id="username" name="username" required="required" type="text" placeholder="username" />
      <input id="password" name="password" required="required" type="password" placeholder="" />
      <input type="submit" value="login" />
    </form>
  </div>

  <!-- or register for account -->
  <div id="register_box">
    <h2>or register</h2>
    <form action="register.php">
      <input type="submit" value="register" />
    </form>
  </div>



</body>
</html>

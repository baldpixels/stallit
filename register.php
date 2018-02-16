<?php
//register.php
  include 'database.php';
  include 'session_setup.php';

/*** main script ***/
  $registerOK = false;

  //username check
  if(isset($_POST['username']))
  {
    //a username was entered
    if(!ctype_alnum($_POST['username']))
    {
      $_SESSION['log'] = "<h4>sorry, username can only contain letters and digits.</h4>";
      header("Location: index.php");
    }
    if(strlen($_POST['username']) > 50)
    {
      $_SESSION['log'] = "<h4>sorry, username cannot be longer than 50 characters.</h4>";
      header("Location: index.php");
    }
  }
  else
  {
    $_SESSION['log'] = "<h4>username cannot be empty</h4>
            <p>you should know better.</p>";
    header("Location: index.php");
  }

  //password check
  if(isset($_POST['password']))
  {
    if($_POST['password'] !== $_POST['password_check'])
    {
      //passwords do not match
      $_SESSION['log'] = "<h4>your two passwords did not match.</h4>";
      header("Location: index.php");
    }
    else {
      //passwords match
      $registerOK = true;
    }
  }
  else
  {
    $_SESSION['log'] = "<h4>password cannot be empty.</h4>
            <p>that's just dumb...</p>";
    header("Location: index.php");
  }

  if($registerOK) {
    //random rgb color
    $assignedRed = mt_rand(0, 255);
    $assignedGreen = mt_rand(0, 255);
    $assignedBlue = mt_rand(0, 255);
    $assignedAlpha = mt_rand(50, 100)/100;
    $assignedRGBA = "" . $assignedRed . "," . $assignedGreen . "," . $assignedBlue . "," . $assignedAlpha . "";

    //submit form to users database
    $stmt = $mysqli->prepare("INSERT INTO
                users(username, password, red, green, blue, alpha)
            VALUES(?, ?, ?, ?, ?, ?)");
    if(!$stmt) {
      $_SESSION['log'] = "<h4>query error...</h4>
              <p>maybe try again later.</p>";
      $stmt->close();
      header("Location: index.php");
    }

    $stmt->bind_param('ssiiid', mysql_real_escape_string($_POST['username']), password_hash($_POST['password'], PASSWORD_DEFAULT), $assignedRed, $assignedGreen, $assignedBlue, $assignedAlpha);

    if($stmt->execute()){
      $_SESSION['log'] = "<h4>nice, you are all set.</h4>
              <p>welcome to stall'it <span class='user'>" . htmlspecialchars($_POST['username']) . "</span>.
              your color is <span style='color: rgba(" . $assignedRGBA . ");' id='user_color'>" . $assignedRGBA . "</span>.<br /><br />
              now try logging in!</p>";
      $stmt->close();
      header("Location: index.php");

    }
    else {
      $_SESSION['log'] = "<h4>sorry, something went wrong...</h4>
              <p>maybe try again later.</p>";
      $stmt->close();
      header("Location: index.php");
    }
  }

?>

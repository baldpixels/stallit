<?php
//register.php
  include 'database.php';
  include 'session_setup.php';

/*** main script ***/
  $publishOK = true;

  //any checks we should run?
  if($publishOK) {

    //submit form to stalls database
    $stmt = $mysqli->prepare("INSERT INTO
                stalls(created_by, name, description)
            VALUES(?, ?, ?)");
    if(!$stmt) {
      $_SESSION['log'] = "<h4>query error...</h4>
              <p>maybe try again later.</p>";
      $stmt->close();
      header("Location: index.php");
    }

    $stmt->bind_param('iss', $_SESSION['user_id'], $_POST['stall_name'], $_POST['stall_description']);

    if($stmt->execute()) {
      $_SESSION['log'] = "<h4>nice, your stall is live.</h4>
              <p>stall name: <span class='user'>" . htmlspecialchars($_POST['stall_name']) . "</span></p>";
      $stmt->close();
      header("Location: index.php");
    }
    else {
      $_SESSION['log'] = "<h4>sorry, something went wrong...</h4>
              <p>maybe try again later, " . $_SESSION['user_id'] . $_POST['stall_name'] . "</p>";
      $stmt->close();
      header("Location: index.php");
    }
  }

?>

<?php
//login.php
  include 'database.php';
  include 'session_setup.php';

/*** main script ***/
  //login function
  function beginUserSession($username, $user_id, $user_rgba){
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_rgba'] = $user_rgba;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); // generate a 32-byte random string
    $_SESSION['logged_in'] = true;
  }

  //submit form to users database
  $stmt = $mysqli->prepare("SELECT id, username, password, red, green, blue, alpha
              FROM
                users
              WHERE
                username = ?");
  if(!$stmt){
    $_SESSION['log'] = "<h4>query error...</h4>
            <p>maybe try again later.</p>";
    header("Location: index.php");
  }
  else {
    $stmt->bind_param('s', mysql_real_escape_string($_POST['username']));

    if($stmt->execute()){
      $stmt->store_result();

      if($stmt->num_rows == 0) {
        $_SESSION['log'] = "<h4>username not found</h4>
                <p>you sure you entered the right username? why not try again.</p>";
        //free result
        $stmt->free_result();
        $stmt->close();
        header("Location: index.php");
      }
      else {
        $stmt->bind_result($returned_id, $returned_username, $returned_password, $returned_red, $returned_green, $returned_blue, $returned_alpha);

        $stmt->fetch();
        //password verified --> login successful!
        if(password_verify(mysql_real_escape_string($_POST['password']), $returned_password)) {
          //store user's rgba
          $returned_rgba = "" . $returned_red . "," . $returned_green . "," . $returned_blue . "," . $returned_alpha . "";

          beginUserSession($returned_username, $returned_id, $returned_rgba);

          $_SESSION['log'] = "<h4>you're logged in!</h4><p>" .
                  $returned_username . "<br />"
                  . "your color is <span style='color: rgba(" . $returned_rgba . ");' id='user_color'>" . $returned_rgba . "</span>
                  </p>";
          //free result
          $stmt->free_result();
          $stmt->close();
          header("Location: index.php");
        }
        else {
          $_SESSION['log'] = "<h4>incorrect password</h4>
                  <p>you sure you entered the right password? why not try again.</p>";
          //free result
          $stmt->free_result();
          $stmt->close();
          header("Location: index.php");
        }
      }
    }
    //stmt fails to execute
    else {
      $_SESSION['log'] = "<h4>sorry, something went wrong...</h4>
              <p>maybe try again later.</p>";
      $stmt->close();
      header("Location: index.php");
    }
  }

?>

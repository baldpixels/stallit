<?php
//create_stall.php
  include 'database.php';
  include 'session_setup.php';

  $stall_id = $_GET['id'];

  //set up database
  $server = 'localhost';
  $username   = 'stallman';
  $password   = 'stallman';
  $database   = 'stallit';

  $mysqli = new mysqli($server, $username, $password, $database);

  if($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
  }

  //first, let's pull all the stall info
  $stmt = $mysqli->prepare("SELECT date_created, created_by, name, description, activity_points
              FROM
                stalls
              WHERE
                id = ?");
  if(!$stmt){

  }
  else {
    $stmt->bind_param('i', $stall_id);

    if($stmt->execute()) {
      $stmt->store_result();

      $stmt->bind_result($returned_date, $returned_creator, $returned_name, $returned_description, $returned_points);

      $stmt->fetch();

      //store user's username and rgba
      $stall_creator_id = $returned_creator;
      $stall_name = $returned_name;
      $stall_description = $returned_description;

      //free result
      $stmt->free_result();
      $stmt->close();
    }
  }

  //then, let's grab user_color via foreign key join
  $stmt = $mysqli->prepare("SELECT username, red, green, blue, alpha
              FROM
                users
              WHERE
                id = ?");
  if(!$stmt){

  }
  else {
    $stmt->bind_param('i', $stall_creator_id);

    if($stmt->execute()) {
      $stmt->store_result();

      $stmt->bind_result($returned_username, $returned_red, $returned_green, $returned_blue, $returned_alpha);

      $stmt->fetch();

      //store user's username and rgba
      $stall_creator_username = $returned_username;
      $creator_rgba = "" . $returned_red . "," . $returned_green . "," . $returned_blue . "," . $returned_alpha . "";

      //free result
      $stmt->free_result();
      $stmt->close();
    }
  }

?>

<!-- markup -->
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $stall_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Vlad Pixels">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="css/stall.css">
    <?php
    //load stall_color from database
    $stall_color;

    echo"<style>
      #color_overlay {background-color: rgba(" . $creator_rgba . ");}
      #stall_floor_wrapper {background-color: rgba(" . $creator_rgba . ");}
      #stall_name {background-color: rgba(" . $creator_rgba . ");}
      #centerpiece {border-color: rgba(" . $creator_rgba . ");}
      </style>";
    ?>
  </head>

  <body>
    <div id="wrapper">
      <h1 id="stall_name"><?php echo $stall_name ?></h1>

      <!-- stall door -->
      <div id="stall_door">
        <a href="index.php"><img src="img/stalin_sticker.png" id="stalin_sticker" alt="" /></a>

        <div id="draw_controls">
          <form id="draw_tool" method="post" action="">
            <select id="tool_options" name="tool_options">
              <option value="pen">pen</option>
              <option value="marker">marker</option>
            </select>
            <input id="tool_submit" name="tool_submit" type="submit" value="switch" />
          </form>
        </div>

        <div id="centerpiece">

        </div>
      </div>

      <!-- stall floor -->
      <div id="stall_floor_wrapper">
        <div id="stories">
          <h2 class="stall_floor_header">stories</h2>

          <div class="story">

          </div>

          <div id="comments">
            <div class="comment">

            </div>
          </div> <!-- end comments -->
        </div> <!-- end stories -->

      </div> <!-- end stall_floor_wrapper -->

    </div> <!-- end wrapper -->
  </body>

</html>

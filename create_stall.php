<?php
//create_stall.php
  include 'database.php';
  include 'session_setup.php';

  /*** main script ***/
  if(isset($_POST['new_stall_name'])) {
    $stall_name = htmlentities($_POST['new_stall_name']);
    $stall_color = $_SESSION['user_rgba'];
  }

?>


<!-- BEGIN MARKUP -->
<!DOCTYPE html>
<html>
  <head>
    <title>stall'it/<?php echo $stall_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Vlad Pixels">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="css/stall.css">
    <?php
    echo"<style>
      #tp_wrapper {background-color: rgba(" . $stall_color . ");}
      #stall_name {background-color: rgba(" . $stall_color . ");}
      #centerpiece {border-color: rgba(" . $stall_color . ");}
      </style>";
    ?>
  </head>

  <body>
    <div id="wrapper">
      <h1 id="stall_name"><?php echo $stall_name ?></h1>

      <a href="index.php"><img src="img/stalin_sticker.png" id="stalin_sticker" alt="" /></a>

      <!-- STALL DOOR
      <div id="stall_door">

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
      END STALL DOOR-->

      <!-- add stall's first story -->

      <!-- stall rules -->

      <!-- tp -->
      <div id="tp_wrapper">
        <img id="tp_roll" src="img/tp_roll.png" alt="" />

        <h2 id="tp_header">stall settings</h2>

        <div id="tp_scroller"> <!-- allows content to be scrolled in tp -->
          <div id="stall_settings">
            <form method="post" action="index.php">
              <input type="submit" value="cancel">
            </form>

            <form id="submit_form" method="post" action="publish_stall.php">
              <!-- stall name -->
              <input type="hidden" name="stall_name" value="<?php echo $stall_name ?>" />
              <!-- private access -->
              <label for="private">private stall -> </label>
              <input type="radio" name="stall_access" value="private" required="required" />
              <br />
              <p class="setting_tip">(only you can post stories to this stall)</p>
              <br /><br />
              <!-- public access -->
              <label for="public">public stall -> </label>
              <input type="radio" name="stall_access" value="public" required="required" />
              <br />
              <p class="setting_tip">(anyone can post stories to this stall)</p>
              <br /><br />
              <!-- description -->
              <input id="description_input" type="text" name="stall_description" maxlength="80" required="required" placeholder="describe your stall (in 80 chars)" />
              <br /><br />
              <!-- publish stall -->
              <input type="submit" value="publish stall">
            </form>
          </div> <!-- end stall_settings -->
        </div> <!-- end tp_scroller -->
      </div> <!-- end tp_wrapper -->

    </div> <!-- end wrapper -->
  </body>

</html>

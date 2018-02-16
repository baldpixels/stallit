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
    <?php echo"<style>
      #color_overlay {background-color: rgba(" . $_SESSION['user_rgba'] . ");}
      #stall_floor_wrapper {background-color: rgba(" . $_SESSION['user_rgba'] . ");}
      #stall_name {background-color: rgba(" . $_SESSION['user_rgba'] . ");}
      #centerpiece {border-color: rgba(" . $_SESSION['user_rgba'] . ");}
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

      <!-- add stall's first story -->

      <!-- stall rules -->

      <!-- stall floor -->
      <div id="stall_floor_wrapper">

        <div id="stall_settings">
          <form method="post" action="index.php">
            <input type="submit" value="cancel">
          </form>

          <h2 class="stall_floor_header">stall settings</h2>

          <form id="submit_form" method="post" action="publish_stall.php">
            <!-- stall name -->
            <input type="hidden" name="stall_name" value="<?php echo $stall_name ?>" />
            <!-- private access -->
            <label for="private">private stall -> </label>
            <input type="radio" name="access" value="private" />
            <br />
            <p class="setting_tip">(only you can post stories to this stall)</p>
            <br /><br />
            <!-- public access -->
            <label for="public">public stall -> </label>
            <input type="radio" name="access" value="public" />
            <br />
            <p class="setting_tip">(anyone can post stories to this stall)</p>
            <br /><br />
            <!-- description -->
            <input type="text" name="stall_description" size="80" maxlength="80" required="required" placeholder="describe your stall (in 80 chars)" />
            <br /><br />
            <!-- publish stall -->
            <input type="submit" value="publish stall">
          </form>
        </div> <!-- end stall_settings -->

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

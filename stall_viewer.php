<?php
//stall_viewer.php
  /*** THIS FILE IS THE POWER HORSE FOR LOADING/DISPLAYING ALL STALL CONTENT ***/

  include 'database.php';
  include 'session_setup.php';

  $stall_id = $_GET['id'];

  //first, let's pull all the stall info
  $stmt = $mysqli->prepare("SELECT date_created, created_by, name, description, access, activity_points
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

      $stmt->bind_result($returned_date, $returned_creator, $returned_name, $returned_description, $returned_access, $returned_points);

      $stmt->fetch();

      //store user's id and other relevant stuff
      $stall_creator_id = $returned_creator;
      $stall_name = $returned_name;
      $stall_description = $returned_description;
      $stall_access = $returned_access;
      $stall_points = $returned_points;

      //free result
      $stmt->free_result();
      $stmt->close();
    }
  }

  //then, let's grab the stall's user_color via foreign key join
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

/*** functions for story and comment loading ***/
  //loads stories associated with this stall
  function loadStories($stall_id) {
    include 'database.php';

    //pull stories from database
    $stmt = $mysqli->prepare("SELECT id, date_posted, posted_by, title, content, link, points
                FROM
                  stories
                WHERE
                  stall_id = ?");
    if(!$stmt){

    }
    else {
      $stmt->bind_param('i', $stall_id);

      if($stmt->execute()) {

        $stmt->store_result();

        $stmt->bind_result($returned_id, $returned_date, $returned_poster, $returned_title, $returned_content, $returned_link, $returned_points);

        while($stmt->fetch()) {
          //store story info
          $story_id = $returned_id;
          $story_date = $returned_date;
          $story_poster_id = $returned_poster;
          $story_title = $returned_title;
          $story_content = $returned_content;
          $story_link = $returned_link;
          $story_points = $returned_points;

          //pull poster info from users
          $stmt2 = $mysqli->prepare("SELECT username, red, green, blue, alpha
                      FROM
                        users
                      WHERE
                        id = ?");

          $stmt2->bind_param('i', $story_poster_id);

          if($stmt2->execute()) {

            $stmt2->store_result();

            $stmt2->bind_result($returned_username, $returned_red, $returned_green, $returned_blue, $returned_alpha);

            $stmt2->fetch();

            //save user info
            $poster_username = $returned_username;
            $poster_rgba = "" . $returned_red . "," . $returned_green . "," . $returned_blue . "," . $returned_alpha . "";

            $stmt2->free_result();
            $stmt2->close();
          }

          //now echo the story
          echo '<div class="story">
            <h3 class="story_title">&ldquo;' . $story_title . '&rdquo;</h3>';

          //edit/delete story option
          if($_SESSION['username'] === $poster_username) {
            echo '<form name="delete_story" method="post" action="delete_story.php">
                <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                <input type="hidden" name="story_id" value="' . $story_id . '" />
                <input class="delete_story_button" type="submit" value="delete story" />
              </form>';
            echo '<form name="edit_story" method="post" action="edit_story.php">
                <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                <input type="hidden" name="story_id" value="' . $story_id . '" />
                <input class="edit_story_button" type="submit" value="edit story" />
              </form>';
          }

          echo '<p class="story_points">
              points: <span class="points">' . $story_points . '</span>
            </p>
            <p class="story_poster">
              posted by <span class="poster" style="color: rgba(' . $poster_rgba . ');"><a href="" style="color: rgba(' . $poster_rgba . ');">' . $poster_username . '</a></span>
            </p>
            <p class="story_content">
            [~<span class="link"><a href="' . $story_link . '" target="_blank">' . $story_link . '</a></span>]<br /><br />
            ' . $story_content . '
            </p>';

          loadComments($stall_id, $story_id);

          echo '</div>'; //to close stories div
        }

        //free result
        $stmt->free_result();
        $stmt->close();
      }
    }
  }

  //loads comments associated with particular story
  function loadComments($stall_id, $story_id) {
    include 'database.php';

    //pull stories from database
    $stmt = $mysqli->prepare("SELECT id, date_written, written_by, content, points
                FROM
                  comments
                WHERE
                  story = ?");
    if(!$stmt){

    }
    else {
      $stmt->bind_param('i', $story_id);

      if($stmt->execute()) {

        $stmt->store_result();

        $stmt->bind_result($returned_id, $returned_date, $returned_writer, $returned_content, $returned_points);

        echo '<div class="comments">';

        echo '<button class="comments_toggle" onclick="toggleComments()">hide</button>';

        echo '<h4 class="comments_header">comments...</h4>';

        while($stmt->fetch()) {
          //store comment info
          $comment_id = $returned_id;
          $comment_date = $returned_date;
          $comment_writer_id = $returned_writer;
          $comment_content = $returned_content;
          $comment_points = $returned_points;

          //pull writer info from users
          $stmt3 = $mysqli->prepare("SELECT username, red, green, blue, alpha
                      FROM
                        users
                      WHERE
                        id = ?");

          $stmt3->bind_param('i', $comment_writer_id);

          if($stmt3->execute()) {

            $stmt3->store_result();

            $stmt3->bind_result($returned_username, $returned_red, $returned_green, $returned_blue, $returned_alpha);

            $stmt3->fetch();

            //save user info
            $writer_username = $returned_username;
            $writer_rgba = "" . $returned_red . "," . $returned_green . "," . $returned_blue . "," . $returned_alpha . "";

            $stmt3->free_result();
            $stmt3->close();
          }

          echo '<div class="comment">
              <p class="comment_content">
                ' . $comment_content . '
              </p>
              <p class="comment_writer">
                written by <span class="writer" style="color: rgba(' . $writer_rgba . ');"><a href="" style="color: rgba(' . $writer_rgba . ');">' . $writer_username . '</a></span>
              </p>';

          //edit/delete comment option
          if($_SESSION['username'] === $writer_username) {
            echo '<form name="delete_comment" method="post" action="delete_comment.php">
                <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                <input type="hidden" name="comment_id" value="' . $comment_id . '" />
                <input class="delete_comment_button" type="submit" value="delete" />
              </form>';
            echo '<form name="edit_comment" method="post" action="edit_comment.php">
                <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                <input type="hidden" name="comment_id" value="' . $comment_id . '" />
                <input class="edit_comment_button" type="submit" value="edit" />
              </form>';
          }

          echo '</div>';
        }
        //free result
        $stmt->free_result();
        $stmt->close();

        commentForm($stall_id, $story_id);

        echo '</div>';
      }
    }
  }

  function commentForm($stall_id, $story_id) {
    if($_SESSION['logged_in']) {
      echo '<form name="new_comment" method="post" action="write_comment.php">
        <input type="hidden" name="stall_id" value="' . $stall_id . '" />
        <input type="hidden" name="story_id" value="' . $story_id . '" />
        <textarea class="new_comment_textarea" name="new_comment_content" required="required" placeholder="write a comment" ></textarea>
        <input type="submit" value="submit" />
      </form>';
    }
    else {
      //we need to work out the positioning bug here
    }
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
      #tp_wrapper {background-color: rgba(" . $creator_rgba . ");}
      #stall_name {background-color: rgba(" . $creator_rgba . ");}
      #centerpiece {border-color: rgba(" . $creator_rgba . ");}
      </style>";
    ?>
  </head>

  <body>
    <div id="wrapper">
      <h1 id="stall_name"><?php echo $stall_name ?></h1>

      <a href="index.php"><img src="img/stalin_sticker.png" id="stalin_sticker" alt="" /></a>

      <!-- STALL DOOR (personal drawing project)
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
      END STALL DOOR -->

      <!-- tp -->
      <div id="tp_wrapper">
        <div id="description">
          <p>
            (<?php echo $stall_description ?>)
          </p>
        </div>
        <img id="tp_roll" src="img/tp_roll.png" alt="" />

        <h2 id="tp_header">stories</h2>

        <div id="tp_scroller"> <!-- allows content to be scrolled in tp -->
          <div id="stories">

            <?php loadStories($stall_id) ?>

            <!-- if public, echo new story form -->
            <?php
              if($stall_access === "public") {
                if($_SESSION['logged_in']) {
                  //submit new story form
                  echo '<form name="new_story" method="post" action="post_story.php">
                    <h3>post a new story to ' . $stall_name . '...</h3>
                    <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                    <input type="text" name="new_story_title" required="required" maxlength="48" placeholder="story title" />
                    <br />
                    <input type="text" name="new_story_link" placeholder="link (optional)" />
                    <br />
                    <textarea id="new_story_textarea" name="new_story_content" required="required" placeholder="story content" ></textarea>
                    <br />
                    <input type="submit" value="post!" />
                  </form>';
                }
                else { //new story form is hidden
                  echo '<div class="tp_msg">
                      <p>
                      login or register to post a story.
                      </p>
                    </div>';
                }
              }
              else { //private stall
                if($_SESSION['username'] === $stall_creator_username) {
                  //submit new story form is open for the user who created the stall
                  echo '<form name="new_story" method="post" action="post_story.php">
                    <h3>post a new story to ' . $stall_name . '...</h3>
                    <input type="hidden" name="stall_id" value="' . $stall_id . '" />
                    <input type="text" name="new_story_title" required="required" maxlength="48" placeholder="story title" />
                    <br />
                    <input type="text" name="new_story_link" placeholder="link (optional)" />
                    <br />
                    <textarea id="new_story_textarea" name="new_story_content" required="required" placeholder="story content" ></textarea>
                    <br />
                    <input type="submit" value="post!" />
                  </form>';
                }
                else {
                  echo '<div class="tp_msg">
                      <p>
                      sorry, this stall is private (you cannot submit a story)
                      </p>
                    </div>';
                }
              }
            ?>
          </div> <!-- end stories -->
        </div> <!-- end tp_scroller -->
      </div> <!-- end tp_wrapper -->

    </div> <!-- end wrapper -->
  </body>

</html>

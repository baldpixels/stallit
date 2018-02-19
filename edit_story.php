<?php
//edit_story.php

  include 'database.php';
  include 'session_setup.php';

  $stall_id = $_POST['stall_id'];
  $story_id = $_POST['story_id'];

  //first, pull old story info from database
  $stmt = $mysqli->prepare("SELECT title, content, link
              FROM
                stories
              WHERE
                id = ?");

  $stmt->bind_param('i', $story_id);

  $stmt->execute();

  $stmt->store_result();

  $stmt->bind_result($returned_title, $returned_content, $returned_link);

  $stmt->fetch();

  $old_title = $returned_title;
  $old_content = $returned_content;
  $old_link = $returned_link;

  $stmt->free_result();
  $stmt->close();

//if user saves edits
  if(isset($_POST['content_edited']) || isset($_POST['link_edited']) || isset($_POST['title_edited'])) {
    $stmt2 = $mysqli->prepare("UPDATE stories
            SET
              content = ?, title = ?
            WHERE
              id = ?");

    $stmt2->bind_param('ssi', $_POST['content_edited'], $_POST['title_edited'], $story_id);

    $stmt2->execute();

    $stmt2->close();
    header("Location: stall_viewer.php?id=" . $stall_id);
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>edit story</title>
    <link rel="stylesheet" href="css/restroom.css">
  </head>

  <body>
    <div id="wrapper">
      <form name="edit_story" method="post" action="">
        <h3>edit your story...</h3>
        <input type="hidden" name="stall_id" value="<?php echo $stall_id ?>" />
        <input type="hidden" name="story_id" value="<?php echo $story_id ?>" />
        <input type="text" name="title_edited" required="required" maxlength="48" value="<?php echo $old_title ?>" placeholder="title" />
        <br />
        <input type="text" name="link_edited" value="<?php echo $old_link ?>" placeholder="link" />
        <br />
        <textarea id="new_story_textarea" rows="6" cols="60" name="content_edited" required="required" value="<?php echo $old_content ?>" placeholder="edited story" ></textarea>
        <br />
        <input type="submit" name="save" value="save" />
      </form>
      <!-- cancel option -->
      <form method="post" action="stall_viewer.php?id=<?php echo $stall_id ?>">
        <input type="submit" value="cancel" />
      </form>
    </div> <!-- end wrapper -->
  </body>
</html>

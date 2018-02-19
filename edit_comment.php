<?php
//edit_comment.php

  include 'database.php';
  include 'session_setup.php';

  $stall_id = $_POST['stall_id'];
  $comment_id = $_POST['comment_id'];

  //first, pull old story info from database
  $stmt = $mysqli->prepare("SELECT content
              FROM
                comments
              WHERE
                id = ?");

  $stmt->bind_param('i', $comment_id);

  $stmt->execute();

  $stmt->store_result();

  $stmt->bind_result($returned_content);

  $stmt->fetch();

  $old_content = $returned_content;

  $stmt->free_result();
  $stmt->close();

//if user saves edits
  if(isset($_POST['content_edited'])) {
    $stmt2 = $mysqli->prepare("UPDATE comments
            SET
              content = ?
            WHERE
              id = ?");

    $stmt2->bind_param('si', $_POST['content_edited'], $comment_id);

    $stmt2->execute();

    $stmt2->close();
    header("Location: stall_viewer.php?id=" . $stall_id);
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>edit comment</title>
    <link rel="stylesheet" href="css/restroom.css">
  </head>

  <body>
    <div id="wrapper">
      <form name="edit_story" method="post" action="">
        <h3>edit your comment...</h3>
        <input type="hidden" name="stall_id" value="<?php echo $stall_id ?>" />
        <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>" />
        <textarea id="new_comment_textarea" rows="3" cols="30" name="content_edited" required="required" value="<?php echo $old_content ?>" placeholder="edited comment" ></textarea>
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

<?php
//write_comment.php

  include 'database.php';
  include 'session_setup.php';

  $stmt = $mysqli->prepare("INSERT INTO
              comments (content, written_by, story)
          VALUES(?, ?, ?)");
  if(!$stmt){
    $stmt->close();
    header("Location: stall_viewer.php?id=" . $_POST['stall_id']);
  }
  else {
    $stmt->bind_param('sii', $_POST['new_comment_content'], $_SESSION['user_id'], $_POST['story_id']);

    if($stmt->execute()) {
      //increase story's points by 1
      $stmt2 = $mysqli->prepare("UPDATE stories
                  SET
                    points = points+1
                  WHERE
                    id = ?");

      $stmt2->bind_param('i', $_POST['story_id']);

      $stmt2->execute();

      $stmt2->close();

      $stmt->close();
      header("Location: stall_viewer.php?id=" . $_POST['stall_id']);
    }
  }

?>

<?php
//post_story.php

  include 'database.php';
  include 'session_setup.php';

  $stmt = $mysqli->prepare("INSERT INTO
              stories (title, content, posted_by, link, stall_id)
          VALUES(?, ?, ?, ?, ?)");
  if(!$stmt){
    $stmt->close();
    header("Location: stall_viewer.php?id=" . $_POST['stall_id']);
  }
  else {
    $stmt->bind_param('ssisi', $_POST['new_story_title'], $_POST['new_story_content'], $_SESSION['user_id'], $_POST['new_story_link'], $_POST['stall_id']);

    if($stmt->execute()) {
      //increase stall's points by 1
      $stmt2 = $mysqli->prepare("UPDATE stalls
                  set activity_points=activity_points+1
              WHERE id=?");

      $stmt2->bind_param('i', $_POST['stall_id']);

      $stmt2->execute();

      $stmt2->close();

      $stmt->close();
      header("Location: stall_viewer.php?id=" . $_POST['stall_id']);
    }
  }

?>

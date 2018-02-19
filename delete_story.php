<?php
//delete_story.php

  include 'database.php';
  include 'session_setup.php';

  $stmt = $mysqli->prepare("DELETE from stories
          WHERE id=?");

  $stmt->bind_param('i', $_POST['story_id']);

  $stmt->execute();

  $stmt->close();

  $stmt->close();
  header("Location: stall_viewer.php?id=" . $_POST['stall_id']);

?>

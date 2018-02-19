<?php
//user_controls.php

  echo '<div id="user_controls">';

  //sort posts by...
  echo '<form id="sort_by" method="post" action="">
      <select id="sort_options" name="sort_options">
        <option value="" selected disabled hidden>sort by...</option>
        <option value="popular">most popular</option>
        <option value="newest">newest</option>
      </select>
      <input id="sort_submit" name="sort_submit" type="submit" value="sort stalls" />
    </form>';


  //search bar
  echo '<form id="search" method="post" action="search_stalls.php">
      <input id="search_text" name="search_text" type="search" name="search" value="" placeholder="search all stalls...">
      <input id="search_submit" name="search_submit" type="submit" value="search" />
    </form>';

  //create new stall
  echo '<form id="create_new" method="post" action="create_stall.php">
      <input id="new_stall_name" name="new_stall_name" type="text" maxlength="24" size="24" required="required" placeholder="name your stall" />
      <input id="new_stall_submit" name="new_stall_submit" type="submit" value="create new stall" style="background-color: rgba(' . $_SESSION['user_rgba'] . ');" />
    </form>';

  //view my stalls
  echo '<form id="view_my_stalls" method="post" action="my_stalls.php">
      <input id="my_stalls_submit" name="my_stalls_submit" type="submit" value="view your stalls" style="background-color: rgba(' . $_SESSION['user_rgba'] . ');" />
    </form>';

  echo '</div>';

?>

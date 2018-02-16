<?php
//stalls_loader.php
  //displays stalls, ordered by selected sort option (default is popularity)

  //this function loads and displays the sorted stalls
  function displayStall($stall_array) {
    //indices: 0->id, 1->date, 2->created_by (id), 3->name, 4->points
    $stall_id = $stall_array[0];
    date_default_timezone_set('America/Los_Angeles');
    $stall_date = date('m-d-Y', strtotime($stall_array[1]));
    $stall_creator_id = $stall_array[2];
    $stall_name = $stall_array[3];
    $stall_points = $stall_array[4];

    //database connect
    $server = 'localhost';
  	$username   = 'stallman';
  	$password   = 'stallman';
  	$database   = 'stallit';

  	$mysqli = new mysqli($server, $username, $password, $database);

  	if($mysqli->connect_errno) {
  		printf("Connection Failed: %s\n", $mysqli->connect_error);
  		exit;
  	}

    //grab username and user rgba
    $stmt = $mysqli->prepare("SELECT username, red, green, blue, alpha
                FROM
                  users
                WHERE
                  id = ?");

    $stmt->bind_param('i', $stall_creator_id);

    $stmt->execute();

    $stmt->store_result();

    $stmt->bind_result($returned_username, $returned_red, $returned_green, $returned_blue, $returned_alpha);

    $stmt->fetch();

    //store user's username and rgba
    $stall_creator_username = $returned_username;
    $returned_rgba = "" . $returned_red . "," . $returned_green . "," . $returned_blue . "," . $returned_alpha . "";

    //free result
    $stmt->free_result();
    $stmt->close();

    //echo stall div
    echo '<div class="stall">
        <h4 class="stall_title" style="background-color: rgba(' . $returned_rgba . ');"><a href="stall_viewer.php?id=' . $stall_id . '">' . $stall_name . '</a></h4>
        <div class="stall_stats" style="background-color: rgba(' . $returned_rgba . ');">
          <p class="stall_stat">
            points:<span class="stat"> ' . $stall_points . '</span>
          </p>
          <p class="stall_stat">
            created by <span class="stall_creator"><a href="">' . $stall_creator_username . '</a></span>
          </p>
          <p class="stall_stat">
            on <span class="stat">' . $stall_date . '</span>
          </p>
        </div>
      </div>';
  } //end displayStall()

/***** determine how stalls should be sorted *****/
  if(isset($_POST['sort_options'])) {
    //sort by **newest** case
    if($_POST['sort_options'] === 'newest') {
      //retrieve sorted stalls table
      $stmt = $mysqli->prepare("SELECT id, date_created, created_by, name, activity_points
                  FROM
                    stalls
                  order by
                    date_created desc");

      $stmt->execute();

      $stmt->store_result();

      $stmt->bind_result($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);

      while($stmt->fetch()) {
        $current_stall = array($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);
        displayStall($current_stall);
      }

      $stmt->free_result();
      $stmt->close();
    }
    //default, **logged-in** case (sort by most popular)
    else {
      //retrieve sorted stalls table
      $stmt = $mysqli->prepare("SELECT id, date_created, created_by, name, activity_points
                  FROM
                    stalls
                  order by
                    activity_points desc");

        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);

        while($stmt->fetch()) {
          $current_stall = array($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);
          displayStall($current_stall);
        }

        $stmt->free_result();
        $stmt->close();
    } //end default case
  }
  //default, **not logged-in** case (sort by most popular)
  else {
    //retrieve sorted stalls table
    $stmt = $mysqli->prepare("SELECT id, date_created, created_by, name, activity_points
                FROM
                  stalls
                order by
                  activity_points desc");

      $stmt->execute();

      $stmt->store_result();

      $stmt->bind_result($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);

      while($stmt->fetch()) {
        $current_stall = array($returned_id, $returned_date, $returned_creator, $returned_name, $returned_points);
        displayStall($current_stall);
      }

      $stmt->free_result();
      $stmt->close();
  } //end default case

?>

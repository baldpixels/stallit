<?php include 'database.php' ?>
<?php include 'session_setup.php' ?>
<?php include 'header.php' ?>

  <div id="stalls">
    <!-- stalls are added here -->
    <?php include 'stalls_loader.php' ?>
  </div>

  <!-- log messages -->
  <?php if(isset($_SESSION['log'])){} echo "<div id='user_log'>" . $_SESSION['log'] . "</div>"?>

  <!-- SESSION TOKEN
  <input type="hidden" name="token" value="[php]echo $_SESSION['token'];" />
  and
  [php] if(!hash_equals($_SESSION['token'], $_POST['token'])){
	 die("Request forgery detected");
  }
  -->

<?php include 'footer.php' ?>

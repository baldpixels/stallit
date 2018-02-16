<?php

  //array of footers
  $footers = array('<a href="wtf.php">wtf is stall&#39;it?</a>',
    'a social network for people who don&#39;t give a sh*t',
    'this website is political');
  //random index
  $index = mt_rand(0, count($footers)-1);

?>

    </div> <!-- end wrapper -->
    <footer>
      <p>
        <?php echo $footers[$index] ?>
      </p>
    </footer>
  </body>
</html>

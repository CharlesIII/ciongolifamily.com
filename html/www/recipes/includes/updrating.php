<?php

       require_once('rdb.php');

       $rating = $_POST['rating'];
       $id = $_POST['recid'];

       require_once('calc_rating.php');

       echo $current_rating."|Rating Recorded|".$total_ratings;
?>
<?php
   require_once('rdb.php');

   $id = $_POST['recid'];

   $sql = "$call query_recipe_ratings(:id,:uid)";
   $rsr = $rdb->prepare($sql);
   $rsr->bindValue(':id', $id);
   $rsr->bindValue(':uid', $uid);
   $rsr->execute();
   $err=$rdb->errorInfo();
   $rrows = $rsr->rowCount();
   $rsr->closeCursor();

   if ($rrows>0) {
	  $sql = "$call query_del_rating(:id,:uid)";
      $rsdelr = $rdb->prepare($sql);
      $rsdelr->bindValue(':id', $id);
      $rsdelr->bindValue(':uid', $uid);
      $rsdelr->execute();
      $err=$rdb->errorInfo();
      $rsdelr->closeCursor();
   }

   $sql="$call query_rating(:id)";
   $rsrts = $rdb->prepare($sql);
   $rsrts->bindValue(':id', $id);
   $rsrts->execute();
   $err=$rdb->errorInfo();
   $rtrows=$rsrts->rowCount();
   $rsrt = $rsrts->fetch(PDO::FETCH_BOTH);
   $rsrts->closeCursor();

   if($rtrows>0) {
       $total_ratings = $rsrt[1];
       $total_rating = $rsrt[0];
       $current_rating = round($total_rating/$total_ratings);
       
       $sql = "$call query_add_rating_to_recipe(:current_rating, :total_ratings, :id)";
       $rsaddrt = $rdb->prepare($sql);
       $rsaddrt->bindValue(':current_rating', $current_rating);
       $rsaddrt->bindValue(':total_ratings', $total_ratings);
       $rsaddrt->bindValue(':id', $id);
       $rsaddrt->execute();
    $err=$rdb->errorInfo();
        $rsaddrt->closeCursor();

       echo $current_rating."|Rating Cancelled|".$total_ratings;
    } else {
       echo "0|Rating Cancelled|0"; 
    }
?>
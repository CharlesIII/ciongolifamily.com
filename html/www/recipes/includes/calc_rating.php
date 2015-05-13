<?php
   $sql =  "$call query_recipe_ratings(:id,:uid)";
   $rsr = $rdb->prepare($sql);
   $rsr->bindValue(':id', $id);
   $rsr->bindValue(':uid', $uid);
   $rsr->execute();
   $err=$rdb->errorInfo();
   $rrows = $rsr->rowCount();
   $rsr->closeCursor();

   if ($rrows>0) {
       $sql = "$call query_upd_rating(:rating,:uid,:id)";
       $rsr = $rdb->prepare($sql);
       $rsr->bindValue(':rating', $rating);
       $rsr->bindValue(':uid', $uid);
       $rsr->bindValue(':id', $id);
       $rsr->execute();
       $err=$rdb->errorInfo();
   } else {
       $sql = "$call query_add_rating(:id,:rating,:uid)";
       $rsr = $rdb->prepare($sql);
       $rsr->bindValue(':id', $id);
       $rsr->bindValue(':rating', $rating);
       $rsr->bindValue(':uid', $uid);
       $rsr->execute();
       $err=$rdb->errorInfo();    
   }
   $rsr->closeCursor();

   $sql="$call query_rating(:id)";
   $dbrt = $rdb->prepare($sql);
   $dbrt->bindValue(':id', $id);
   $dbrt->execute();
   $err=$rdb->errorInfo();
   $rsrt = $dbrt->fetch(PDO::FETCH_BOTH);
   $dbrt->closeCursor();

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
?>

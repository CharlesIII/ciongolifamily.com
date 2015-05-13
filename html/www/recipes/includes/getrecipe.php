<?php
  $sql = "$call query_recipe(:id)";
  $dbrecipe = $rdb->prepare($sql);
  $dbrecipe->bindValue(':id', $id);
  $dbrecipe->execute();
  $err=$rdb->errorInfo();
  $rsrecipe = $dbrecipe->fetch(PDO::FETCH_BOTH);
  $dbrecipe->closeCursor();
  
  $name = stripslashes($rsrecipe[0]);
  $directions=$rsrecipe[1];
  $note = $rsrecipe[2];
  $source = $rsrecipe[3];
  $cuisine = $rsrecipe[4];
  $rating = $rsrecipe[5];
  $updated = $rsrecipe[6];
  $yield = rtrim(trim($rsrecipe[7], '0'), '.');
  $tried = $rsrecipe[8];
  $preptime = $rsrecipe[9];
  $yield_unit = $rsrecipe[10];
  $measure = $rsrecipe[11];            
  $added = $rsrecipe[12];
  $total_ratings = $rsrecipe[13];
  if (curPageName() == 'ebook.php') {
      $pdfimage=$rsrecipe[14];
  } else {
    $pdf = $rsrecipe[14];
  }
  $addedby = $rsrecipe[15];
  $cooktime = $rsrecipe[16];
  $video = $rsrecipe[17];
  
  $sql="$call query_recipe_ings(:id)";
  $dbing = $rdb->prepare($sql);
  $dbing->bindValue(':id', $id);
  $dbing->execute();
  $err=$rdb->errorInfo();
  $irows = $dbing->rowCount();
  $rsing = $dbing->fetchAll(PDO::FETCH_BOTH);
  $dbing->closeCursor();
  
  $sql="$call query_recipe_images(:id)";
  $dbimg = $rdb->prepare($sql);
  $dbimg->bindValue(':id', $id);
  $dbimg->execute();
  $err=$rdb->errorInfo();
  $imgrows = $dbimg->rowCount();
  $rsimg = $dbimg->fetchAll(PDO::FETCH_BOTH);
  $dbimg->closeCursor();
  
  $sql="$call query_related_recipes(:id)";
  $dbrel = $rdb->prepare($sql);
  $dbrel->bindValue(':id', $id);
  $dbrel->execute();
  $err=$rdb->errorInfo();
  $rrrows = $dbrel->rowCount();
  $rsrel = $dbrel->fetchAll(PDO::FETCH_BOTH);
  $dbrel->closeCursor();
  
  if($rrrows>0) {
      $related='yes';
  }
  
  $sql="$call query_recipe_diets(:id)";
  $dbdiet = $rdb->prepare($sql);
  $dbdiet->bindValue(':id', $id);
  $dbdiet->execute();
  $err=$rdb->errorInfo();
  $drows = $dbdiet->rowCount();
  $rsdiet = $dbdiet->fetchAll(PDO::FETCH_BOTH);
  $dbdiet->closeCursor();
  
  $sql="$call query_recipe_cats(:id)";
  $dbcat = $rdb->prepare($sql);
  $dbcat->bindValue(':id', $id);
  $dbcat->execute();
  $err=$rdb->errorInfo();
  $srows = $dbcat->rowCount();
  $rscat = $dbcat->fetchAll(PDO::FETCH_BOTH);
  $dbcat->closeCursor();
?>

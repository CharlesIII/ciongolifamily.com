<?php
  $sql = "$call query_recipe_owner(:id)";
  $rsowner = $rdb->prepare($sql);
  $rsowner->bindValue(':id', $recipeid);
  $rsowner->execute();
  $err=$rdb->errorInfo();
  $rmowner=$rsowner->fetchColumn();
  $rsowner->closeCursor();
?>

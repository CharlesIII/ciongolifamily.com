<?php
  $sql = "$call query_recipe_owner(:id)";
  $rsowner = $rdb->prepare($sql);
  $rsowner->bindValue(':id', $id);
  $rsowner->execute();
  $err=$rdb->errorInfo();
  $rowner=$rsowner->fetchColumn();
  $rsowner->closeCursor();
?>

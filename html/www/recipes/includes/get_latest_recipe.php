<?php
  if($client=='wrm') {
      $sql = "$call query_latest_recipe(:oid)";  //return all recipes from db
      $dbresult = $rdb->prepare($sql);
      $dbresult->bindValue(':oid', $oid);
      $dbresult->execute();
      $err=$rdb->errorInfo();
  } else {
      $sql = "$call query_latest_recipe()";  //return all recipes from db
      $dbresult = $rdb->prepare($sql);
      $dbresult->execute();
      $err=$rdb->errorInfo();
  }
  $recrows = $dbresult->rowCount();
  $result = $dbresult->fetch(PDO::FETCH_BOTH);
  $dbresult->closeCursor();              
?>

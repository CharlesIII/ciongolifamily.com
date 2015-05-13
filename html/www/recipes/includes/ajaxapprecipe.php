<?php
  require_once('rdb.php');
  
  $id=$_POST['id'];
  
  $sql = "$call query_approve(:id)";
  $rsapprove = $rdb->prepare($sql);
  $rsapprove->bindValue(':id', $id);
  $rsapprove->execute();
  $err=$rdb->errorInfo();
  $rsapprove->closeCursor();
                    
  if($client=='wrm'){
      $oid=$_SESSION[$client.'oid'];
  }
  if($client=='wrm') {
      $sql = "$call query_latest_unapproved(:oid)";  //return all recipes from db
      $result = $rdb->prepare($sql);
      $result->bindValue(':oid', $oid);
      $result->execute();
      $err=$rdb->errorInfo();
  } else {
      $sql = "$call query_latest_unapproved()";  //return all recipes from db
      $result = $rdb->prepare($sql);
      $result->execute();
      $err=$rdb->errorInfo();
  }
  $recrows=$result->rowCount();
  $rsresult = $result->fetch(PDO::FETCH_BOTH);
  $result->closeCursor();
  
  $id=$rsresult[0];
  echo $id;
?>

<?php
  require_once('rdb.php');
  
  $id=$_POST['id'];
  
  $sql="$call query_delete_fav(:id,:uid)";
  $rsfav = $rdb->prepare($sql);
  $rsfav->bindValue(':id', $id);
  $rsfav->bindValue(':uid', $uid);
  $rsfav->execute();
  $err=$rdb->errorInfo();
  $rsfav->closeCursor();
?>

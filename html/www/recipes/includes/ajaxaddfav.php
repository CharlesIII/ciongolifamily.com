<?php
  
  require_once('rdb.php');
  
  $id=$_POST['id'];
  
  $sql = "$call query_check_if_fav(:id,:uid)";
  $rsfavchk = $rdb->prepare($sql);
  $rsfavchk->bindValue(':id', $id);
  $rsfavchk->bindValue(':uid', $uid);
  $rsfavchk->execute();
  $err=$rdb->errorInfo();
  $frows = $rsfavchk->rowCount();
  $rsfavchk->closeCursor();
  if ($frows == 0) {
          $sql="$call query_add_fav(:id,:uid)";
          $rsfav = $rdb->prepare($sql);
          $rsfav->bindValue(':id', $id);
          $rsfav->bindValue(':uid', $uid);
          $rsfav->execute();
          $err=$rdb->errorInfo();
          $rsfav->closeCursor();
  }
?>

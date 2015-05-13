<?php
  $mid=$_POST['menu'];
  if (isset($mid)) {
      require_once('rdb.php');
      $sql="$call query_delete_menu(:mid)";
      $db = $rdb->prepare($sql);
      $db->bindValue(':mid', $mid);
      $db->execute();
      $err=$rdb->errorInfo();
      $db->closeCursor();

      echo "ok";
  }
?>

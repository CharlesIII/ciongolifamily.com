<?php
   require_once('rdb.php');

   $id = $_POST['recid'];
   $delvideo = $_POST['video'];

   $sql="$call query_chk_video_used_elsewhere(:delvideo, :id)";
   $rsvideochk = $rdb->prepare($sql);
   $rsvideochk->bindValue(':delvideo', $delvideo);
   $rsvideochk->bindValue(':id', $id);
   $rsvideochk->execute();
$err=$rdb->errorInfo();
   $videoorows = $rsvideochk->rowCount();
   $rsvideochk->closeCursor();
   if ($videoorows==0) {
       unlink("../images/recipe/$delvideo");
   }

   $sql = "$call query_delete_recipe_video(:id)";
   $db = $rdb->prepare($sql);
   $db->bindValue(':id', $id);
   $db->execute();
$err=$rdb->errorInfo();
    $db->closeCursor();
?>
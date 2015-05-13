<?php
   require_once('rdb.php');
   
   $image=$_POST['image'];
   $id = $_POST['recid'];

   $sql="$call get_image_id(:image)";
   $rsimg = $rdb->prepare($sql);
   $rsimg->bindValue(':image', $image);
   $rsimg->execute();
$err=$rdb->errorInfo();
   $img = $rsimg->fetch(PDO::FETCH_BOTH);
   $rsimg->closeCursor();
   
   $iid=$img[0];

   $sql="$call query_chk_image_used_elsewhere($iid, $id)";
   $rsimagechk = $rdb->prepare($sql);
   $rsimagechk->bindValue(':iid', $iid);
   $rsimagechk->bindValue(':id', $id);
   $rsimagechk->execute();
$err=$rdb->errorInfo();
   $imageorows = $rsimagechk->rowCount();
   $rsimagechk->closeCursor();
   if ($imageorows==0) {
       unlink("../images/recipe/$image");
       $sql="$call query_delete_image(:iid)";
       $rsimagedel = $rdb->prepare($sql);
       $rsimagedel->bindValue(':iid', $iid);
       $rsimagedel->execute();
$err=$rdb->errorInfo();
        $rsimagedel->closeCursor();
   }
   $sql="$call query_delete_recipe_image(:id,:iid)";
   $rsimagedel = $rdb->prepare($sql);
   $rsimagedel->bindValue(':iid', $iid);
   $rsimagedel->bindValue(':id', $id);
   $rsimagedel->execute();
$err=$rdb->errorInfo();
    $rsimagedel->closeCursor();
?>
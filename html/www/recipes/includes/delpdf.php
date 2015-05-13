<?php
   require_once('rdb.php');

   $id = $_POST['recid'];
   $pdfjpg = $_POST['pdfjpg'];
   $delpdf = str_replace('.jpg','.pdf',$pdfjpg);
   
   $sql="$call query_chk_pdf_used_elsewhere(:delpdf, :id)";
   $rspdfchk = $rdb->prepare($sql);
   $rspdfchk->bindValue(':delpdf', $delpdf);
   $rspdfchk->bindValue(':id', $id);
   $rspdfchk->execute();
   $err=$rdb->errorInfo();
   $pdforows = $rspdfchk->rowCount();
   $rspdfchk->closeCursor(); 
   if ($pdforows==0) {
       unlink("../images/recipe/$delpdf");
       $withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/", "",$delpdf);
       $files = glob("../images/recipe/$withoutExt*.jpg");
       foreach ($files as &$value) {
           unlink("$value");
       }
   }

   $sql = "$call query_delete_recipe_pdf(:id)";
   $db = $rdb->prepare($sql);
   $db->bindValue(':id', $id);
   $db->execute();
   $err=$rdb->errorInfo();
    $db->closeCursor();
?>
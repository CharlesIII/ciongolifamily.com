<?php
  $sql="$call query_recipe_images(:oldid)";
  $rsimgs = $rdb->prepare($sql);
  $rsimgs->bindValue(':oldid', $oldid);
  $rsimgs->execute();
  $err=$rdb->errorInfo();
  $imgrows = $rsimgs->rowCount();
  $rsimg = $rsimgs->fetchAll(PDO::FETCH_BOTH);
  $rsimgs->closeCursor();
  for ($lt1 = 0; $lt1 < $imgrows; $lt1++) {
          $delimg=$rsimg[$lt1][1];
          $iid=$rsimg[$lt1][0];
          if (isset($iid)) {
                  $sql="$call query_chk_image_used_elsewhere(:iid, :oldid)";
                  $rsimgchk = $rdb->prepare($sql);
                  $rsimgchk->bindValue(':iid', $iid);
                  $rsimgchk->bindValue(':oldid', $oldid);
                  $rsimgchk->execute();
                  $err=$rdb->errorInfo();
                  $imgorows = $rsimgchk->rowCount();
                  $rsimgchk->closeCursor();
                  if ($imgorows==0) {
                      if(file_exists("../images/recipe/$delimg")) {
                          rename("../images/recipe/$delimg","imagetmp/$delimg");
                      }
                      $sql="$call query_delete_image(:iid)";
                      $rsimgdel = $rdb->prepare($sql);
                      $rsimgdel->bindValue(':iid', $iid);
                      $rsimgdel->execute();
                      $err=$rdb->errorInfo();
                      $rsimgdel->closeCursor();
                      
                      $sql="$call query_delete_recipe_image(:oldid,:iid)";
                      $rsimgdel = $rdb->prepare($sql);
                      $rsimgdel->bindValue(':iid', $iid);
                      $rsimgdel->bindValue(':oldid', $oldid);
                      $rsimgdel->execute();
                      $err=$rdb->errorInfo();
                      $rsimgdel->closeCursor();
                  }
          }
  }
  $sql="$call query_recipe_pdf(:oldid)";
  $rspdf = $rdb->prepare($sql);
  $rspdf->bindValue(':oldid', $oldid);
  $rspdf->execute();
  $err=$rdb->errorInfo();
  $pdfrows = $rspdf->rowCount();
  $pdf = $rspdf->fetch(PDO::FETCH_BOTH);
  $rspdf->closeCursor();
  if ($pdfrows>0) {
      $delpdf=$pdf[0];
      
      $sql="$call query_chk_pdf_used_elsewhere(:delimg, :oldid)";
      $rspdfchk = $rdb->prepare($sql);
      $rspdfchk->bindValue(':delimg', $delpdf);
      $rspdfchk->bindValue(':oldid', $oldid);
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
  }
  $sql="$call query_recipe_video(:oldid)";
  $rsvideo = $rdb->prepare($sql);
  $rsvideo->bindValue(':oldid', $oldid);
  $rsvideo->execute();
  $err=$rdb->errorInfo();
  $videorows = $rsvideo->rowCount();
  $video = $rsvideo->fetch(PDO::FETCH_BOTH);
  $rsvideo->closeCursor();
      
  if ($videorows>0) {
          $delvideo=$video[0];
          $sql="$call query_chk_video_used_elsewhere(:delimg, :oldid)";
          $rsvideochk = $rdb->prepare($sql);
          $rsvideochk->bindValue(':delimg', $delvideo);
          $rsvideochk->bindValue(':oldid', $oldid);
          $rsvideochk->execute();
          $err=$rdb->errorInfo();
          $videoorows = $rsvideochk->rowCount();
          $rsvideochk->closeCursor();
          if ($videoorows==0) {
                  unlink("../images/recipe/$delvideo");
          }
  }
  $sql="$call query_delete_recipe(:oldid)";
  $rsdel = $rdb->prepare($sql);
  $rsdel->bindValue(':oldid', $oldid);
  $rsdel->execute();
  $err=$rdb->errorInfo();
  $rsdel->closeCursor();
  
  $sql="$call query_clear_recipe_combos(:oldid)";
  $db = $rdb->prepare($sql);
  $db->bindValue(':oldid', $oldid);
  $db->execute();
  $err=$rdb->errorInfo();
  $db->closeCursor();
  
  $sql="$call query_delete_recipe_comments(:oldid)";
  $db = $rdb->prepare($sql);
  $db->bindValue(':oldid', $oldid);
  $db->execute();
  $err=$rdb->errorInfo();
  $db->closeCursor();
  
  
?>

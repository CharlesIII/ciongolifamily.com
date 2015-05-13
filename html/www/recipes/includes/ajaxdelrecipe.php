<?php

  require_once('rdb.php');
  
  $oldid=$_POST['id'];
  if (isset($_POST['admin'])) {
    $admin=$_POST['admin'];
  }
  if(isset($_POST['unapproved'])) {
    $unapproved=$_POST['unapproved'];
  }
  
  
  if (isset($admin)) {
      require_once('delrecipe.php');
  } else {
      $sql="$call query_hide_recipe(:oldid)";
      $rshide = $rdb->prepare($sql);
      $rshide->bindValue(':oldid', $oldid);
      $rshide->execute();
      $err=$rdb->errorInfo();
      $rshide->closeCursor();
  }
  if($client=='wrm'){
      $oid=$_SESSION[$client.'oid'];
  }
  if(!isset($unapproved)) {
      require_once('get_latest_recipe.php');
      if ($recrows>0) {
          $id=$result[0];
          require_once('get_recipe_owner.php');
      }
      echo $id.'|'.$rowner;
  } else {
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
  }
  
?>

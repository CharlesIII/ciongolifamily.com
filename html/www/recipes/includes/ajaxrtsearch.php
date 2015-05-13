<?php

    require_once('rdb.php');
      
    $rating = $_POST['rating'];
    if(isset($_POST['oid'])) {
      $oid = $_POST['oid'];
    }

    if($client=='wrm') {
        if ($rating==0) {
            $sql="SELECT id from recipe WHERE rating is null and owner in (select id from owner where dboid=$oid) and approved is true and visible is true";
        } else {
            $sql="SELECT id from recipe WHERE rating>=$rating and owner in (select id from owner where dboid=$oid) and approved is true and visible is true";
        }
    } else {
        if ($rating==0) {
            $sql="SELECT id from recipe WHERE rating is null and approved is true and visible is true";
        } else {
            $sql="SELECT id from recipe WHERE rating>=$rating and approved is true and visible is true";
        }
    }
    $get = $rdb->prepare($sql);
    $get->execute();
    $err=$rdb->errorInfo();
    $numrrecs = $get->rowCount();
    $getrecipes = $get->fetchAll(PDO::FETCH_BOTH);
    $get->closeCursor();
    
    if ($numrrecs>0) {
        for ($lt = 0; $lt < $numrrecs; $lt++) {
            $id=$getrecipes[$lt][0];
            if($lt==0) {
                $idlist="$id";
            } else {
                $idlist .= ",$id";
            }
        }
    }
    if(isset($idlist)) {
        require_once('searchmenu.php');
    }
?>

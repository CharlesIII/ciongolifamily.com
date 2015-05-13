<?php

    require_once('rdb.php');
      
    if(isset($_POST['oid'])) {
      $oid = $_POST['oid'];
    }
    $source = $_POST['source'];

    if($client=='wrm') {
        $sql="SELECT id from recipe WHERE source=$source and owner in (select id from owner where dboid=$oid) and approved is true and visible is true";
    } else {
        $sql="SELECT id from recipe WHERE source=$source and approved is true and visible is true";
    }
    $get = $rdb->prepare($sql);
    $get->execute();
    $err=$rdb->errorInfo();
    $recnum = $get->rowCount();
    $getrecipes = $get->fetchAll(PDO::FETCH_BOTH);
    $get->closeCursor();
    if ($recnum>0) {
        for ($lt = 0; $lt < $recnum; $lt++) {
            $id=$getrecipes[$lt][0];
            if($lt==0) {
                $idlist="$id";
            } else {
                $idlist .= ",$id";
            }
        }
    }
    if(isset($idlist)) {
        require('searchmenu.php');
    }
?>

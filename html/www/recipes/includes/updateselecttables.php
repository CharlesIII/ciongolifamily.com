<?php
$val=trim($val);
$sql = "$call query_".$var."_exists(:val)";
$get = $rdb->prepare($sql);
$get->bindValue(':val', $val);
$get->execute();
$err=$rdb->errorInfo();
$getrows=$get->rowCount();
$getid = $get->fetch(PDO::FETCH_BOTH);
$get->closeCursor();

if ($getrows>0) {
        $rid = $getid[0];
        $isql = "$call query_".$var."_owner_exists(:rid,:uid)";
        $rget = $rdb->prepare($isql);
        $rget->bindValue(':rid', $rid);
        $rget->bindValue(':uid', $uid);
        $rget->execute();
        $err=$rdb->errorInfo();
        $rgetrows=$rget->rowCount();
        $rget->closeCursor();
        
        if ($rgetrows==0) {
           $isql = "$call query_add_owner_".$var."(:rid,:uid)";
           $radd = $rdb->prepare($isql);
           $radd->bindValue(':rid', $rid);
           $radd->bindValue(':uid', $uid);
           $radd->execute();
$err=$rdb->errorInfo();
            $radd->closeCursor();
        }
} else {
       $isql = "$call query_add_".$var."(:val)";
       $get = $rdb->prepare($isql);
       $get->bindValue(':val', $val);
       $get->execute();
       $err=$rdb->errorInfo();
       $get->closeCursor();
       
       if ($var=='unit' && $client=='wrm') {
           $usql = "insert into unit_base (unit) values(:val)";
           $get = $rdb->prepare($usql);
           $get->bindValue(':val', $val);
           $get->execute();
           $err=$rdb->errorInfo();
           $get->closeCursor(); 
       }
       
       $sql = "$call query_".$var."_exists(:val)";
       $get = $rdb->prepare($sql);
       $get->bindValue(':val', $val);
       $get->execute();
       $err=$rdb->errorInfo();
       $getid = $get->fetch(PDO::FETCH_BOTH);
       $get->closeCursor();
       
       $rid = $getid[0];
       
       $isql = "$call query_add_owner_".$var."(:rid,:uid)";
       $radd = $rdb->prepare($isql);
       $radd->bindValue(':rid', $rid);
       $radd->bindValue(':uid', $uid);
       $radd->execute();
       $err=$rdb->errorInfo();
       $radd->closeCursor();
}
?>
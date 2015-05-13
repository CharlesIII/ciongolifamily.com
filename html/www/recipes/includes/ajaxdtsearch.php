<?php

    require_once('rdb.php');
      
    if(isset($_POST['oid'])) {
      $oid = $_POST['oid'];
    }

    if($client=='wrm') {
        $sql="SELECT recipe, get_recipename(recipe) as name from recipe_diet WHERE diet=".$_POST['diet']." and recipe in(SELECT distinct id FROM recipe where owner in (select id from owner where dboid=$oid) and approved is true and visible is true) ORDER BY name";
    } else {
        $sql="SELECT recipe, get_recipename(recipe) as name from recipe_diet WHERE diet=".$_POST['diet']." and recipe in(SELECT distinct id FROM recipe where approved is true and visible is true) ORDER BY name";
    }
    $get = $rdb->prepare($sql);
    $get->execute();
    $err=$rdb->errorInfo();
    $numdrecs = $get->rowCount();
    $getrecipes = $get->fetchAll(PDO::FETCH_BOTH);
    $get->closeCursor();
    if ($numdrecs>0) {
        for ($lt = 0; $lt < $numdrecs; $lt++) {
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

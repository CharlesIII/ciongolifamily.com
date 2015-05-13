<?php
    require_once('rdb.php');
    
    if (isset($_POST['recid'])) {
        $recid=$_POST['recid'];
    }
    if (isset($_POST['oldcat'])) {
        $oldcat=$_POST['oldcat'];
    }
    if (isset($_POST['oldsubcat'])) {
        $oldsubcat=$_POST['oldsubcat'];
    }
    if (isset($_POST['newsubcat'])) {
        $newsubcat=$_POST['newsubcat'];
    }
    if (isset($_POST['newcat'])) {
        $newcat=$_POST['newcat'];
    }
    if(isset($oldsubcat) && isset($newsubcat)) {
        $sql="UPDATE recipe_cat_subcat SET cat = (select id from category where category.category='$newcat'), subcat = (select id from subcategory where subcategory.subcategory='$newsubcat') WHERE recipe = $recid and recipe in(select id from recipe where recipe.owner=$uid) and cat=(select id from category where category.category='$oldcat') and subcat=(select id from subcategory where subcategory.subcategory='$oldsubcat')";
        $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
    } else if(isset($oldsubcat)) {
        $sql="UPDATE recipe_cat_subcat SET cat = (select id from category where category.category='$newcat'), subcat = NULL WHERE recipe = $recid and recipe in(select id from recipe where recipe.owner=$uid) and cat=(select id from category where category.category='$oldcat') and subcat=(select id from subcategory where subcategory.subcategory='$oldsubcat')";
        $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
    } else if(isset($newsubcat)) {
        $sql="UPDATE recipe_cat_subcat SET cat = (select id from category where category.category='$newcat'), subcat = (select id from subcategory where subcategory.subcategory='$newsubcat') WHERE recipe = $recid and recipe in(select id from recipe where recipe.owner=$uid) and cat=(select id from category where category.category='$oldcat') and subcat is null";
        $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
    }  else  {
        $sql="UPDATE recipe_cat_subcat SET cat = (select id from category where category.category='$newcat') WHERE recipe = $recid and recipe in(select id from recipe where recipe.owner=$uid) and cat=(select id from category where category.category='$oldcat') and subcat is null";
        $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
    }

    
?>
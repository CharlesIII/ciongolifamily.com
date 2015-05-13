<?php
    require_once('rdb.php');

    foreach ($_POST['aisle'] as $position => $item) {

       $sql="UPDATE ingredient_owner SET aisle_order = $position WHERE aisle = $item and owner=$uid";
       $result = $rdb->prepare($sql);
       $result->execute();
       $err=$rdb->errorInfo();
       $result->closeCursor();

    }
?>
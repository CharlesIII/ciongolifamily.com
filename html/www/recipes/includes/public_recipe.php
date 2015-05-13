<?php

    require_once('rdb.php');

    $id = $_POST['id'];

    $sql="$call query_add_public_to_recipe(:id)";
    $rsing = $rdb->prepare($sql);
    $rsing->bindValue(':id', $id);
    $rsing->execute();
    $err=$rdb->errorInfo();
    $rsing->closeCursor();
?>
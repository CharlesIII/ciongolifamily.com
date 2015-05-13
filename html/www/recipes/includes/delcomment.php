<?php

    require_once('rdb.php');

	$commentid = $_POST['commentid'];

	$sql = "delete from comments where commentid=:commentid";
	$result = $rdb->prepare($sql);
    $result->bindValue(':commentid', $commentid);
    $result->execute();
    $err=$rdb->errorInfo();
    $result->closeCursor();
?>
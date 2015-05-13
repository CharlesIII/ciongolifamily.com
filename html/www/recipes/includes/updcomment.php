<?php
	
    require_once('rdb.php');
    
	$cid = $_POST['commentid'];
	$newcomment = $_POST['newcomment'];

	$sql = "update comments set comment=:newcomment where commentid=:cid";
	$result = $rdb->prepare($sql);
    $result->bindValue(':newcomment', $newcomment);
    $result->bindValue(':cid', $cid);
    $result->execute();
    $err=$rdb->errorInfo();
    $result->closeCursor();
	
?>
<?php

    require_once('rdb.php');

	$aisle = $_POST['aisle'];

	$sql = "$call query_aisle_id(:aisle)";
	$result = $rdb->prepare($sql);
    $result->bindValue(':aisle', $aisle);
    $result->execute();
    $err=$rdb->errorInfo();
    $aresult = $result->fetch(PDO::FETCH_BOTH);
    $result->closeCursor();
    
    $aisleid = $aresult[0];
                                                 
	$sql="$call query_aisle_used_by_others(:aisleid, :uid)";
    $result = $rdb->prepare($sql);
    $result->bindValue(':aisleid', $aisleid);
    $result->bindValue(':uid', $uid);
    $result->execute();
    $err=$rdb->errorInfo();
    $found=$result->rowCount();
    $result->closeCursor();

	if ($found>0) {
		$sql = "$call query_remove_aisle_from_ing(:aisleid, :uid)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':aisleid', $aisleid);
        $result->bindValue(':uid', $uid);
        $result->execute();
$err=$rdb->errorInfo();
        $result->closeCursor();
	} else {
		$sql = "$call query_delete_aisle(:aisle)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':aisle', $aisle);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
	}
?>
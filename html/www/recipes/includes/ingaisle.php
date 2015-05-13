<?php
	
	require_once('rdb.php');

	$ing = $_POST['ing'];
	$aisle = $_POST['aisle'];
    if(!isset($aisle)) {
        exit;
    }

	$sql = "$call query_ingredient_exists(:ing)";
	$result = $rdb->prepare($sql);
    $result->bindValue(':ing', $ing);
    $result->execute();
    $err=$rdb->errorInfo();
    $resultid = $result->fetch(PDO::FETCH_BOTH);
    $result->closeCursor();
    
    $ingid=$resultid[0];

	if ($aisle=='Other Items') {
		$sql = "$call query_add_aisle_to_ing(null, :ingid, :uid)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':ingid', $ingid);
        $result->bindValue(':uid', $uid);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
	} else {

		$sql = "$call query_aisle_id(:aisle)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':aisle', $aisle);
        $result->execute();
        $err=$rdb->errorInfo();
        $resultid = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
        
        $aisleid=$resultid[0];

		$sql = "$call query_ingredient_owner_exists(:ingid, :uid)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':ingid', $ingid);
        $result->bindValue(':uid', $uid);
        $result->execute();
        $err=$rdb->errorInfo();
        $rows = $result->rowCount();
        $result->closeCursor();
        
		if ($rows>0) {
			$sql = "$call query_add_aisle_to_ing(:aisleid, :ingid, :uid)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':aisleid', $aisleid);
            $result->bindValue(':ingid', $ingid);
            $result->bindValue(':uid', $uid);
            $result->execute();
            $err=$rdb->errorInfo();
            $result->closeCursor();
		} else {
			$sql = "$call query_add_aisle_ing(:ingid, :aisleid, :uid)";
			$result = $rdb->prepare($sql);
            $result->bindValue(':aisleid', $aisleid);
            $result->bindValue(':ingid', $ingid);
            $result->bindValue(':uid', $uid);
            $result->execute();
            $err=$rdb->errorInfo();
            $result->closeCursor();
		}
	}
?>
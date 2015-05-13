<?php
	
    require_once('rdb.php');
    
	$aisle = $_POST['aisle'];
	$newaisle = $_POST['newaisle'];

	$sql = "$call query_aisle_id(:aisle)";
	$result = $rdb->prepare($sql);
    $result->bindValue(':aisle', $aisle);
    $result->execute();
    $err=$rdb->errorInfo();
    $resultid = $result->fetch(PDO::FETCH_BOTH);
    $result->closeCursor();
    
	$aisleid = $resultid[0];

	$sql = "$call query_aisle_id(:newaisle)";
	$result = $rdb->prepare($sql);
    $result->bindValue(':newaisle', $newaisle);
    $result->execute();
    $err=$rdb->errorInfo();
    $resultid = $result->fetchAll(PDO::FETCH_BOTH);
    $result->closeCursor();
    
    $newaisleid = $resultid[0];

	$sql="$call query_aisle_used_by_others(:aisleid, :uid)";
    $result = $rdb->prepare($sql);
    $result->bindValue(':aisleid', $aisleid);
    $result->bindValue(':uid', $uid);
    $result->execute();
    $err=$rdb->errorInfo();
    $found=$result->rowCount();
    $result->closeCursor();

	if ($found>0) {
		if (!isset($newaisleid)) {
			$sql="$call query_aisle_exists(:newaisle)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':newaisle', $newaisle);
            $result->execute();
$err=$rdb->errorInfo();
            $rows = $result->rowCount();
            $result->closeCursor();
            
			if ($rows==0) {
				$sql="$call query_add_aisle(:newaisle)";
                $result = $rdb->prepare($sql);
                $result->bindValue(':newaisle', $newaisle);
                $result->execute();
$err=$rdb->errorInfo();
                $result->closeCursor();
			}
			$sql = "$call query_aisle_id(:newaisle')";
			$result = $rdb->prepare($sql);
            $result->bindValue(':newaisle', $newaisle);
            $result->execute();
$err=$rdb->errorInfo();
            $resultid = $result->fetchAll(PDO::FETCH_BOTH);
            $result->closeCursor();
            
            $newaisleid = $resultid[0];
		}
		$sql="$call query_upd_aisle_for_ing(:newaisleid, :aisleid, :uid)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':newaisleid', $newaisleid);
        $result->bindValue(':aisleid', $aisleid);
        $result->bindValue(':uid', $uid);
        $result->execute();
$err=$rdb->errorInfo();
        $result->closeCursor();
	} else {
		$sql = "$call query_update_aisle(:newaisle,:aisle)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':newaisle', $newaisle);
        $result->bindValue(':aisle', $aisle);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
	}
?>
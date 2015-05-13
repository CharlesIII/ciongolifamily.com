<?php
	
	require_once('rdb.php');

	$exclnum = $_POST['exclnum'];

	//delete any existing exclusions before saving the updated version
	$sql = "$call query_delete_exclusions(:uid)";
    $rsing = $rdb->prepare($sql);
    $rsing->bindValue(':uid', $uid);
    $rsing->execute();
    $err=$rdb->errorInfo();
    $rsing->closeCursor();
    
	if (isset($exclnum) && $exclnum>0) {
		for ($lt = 0; $lt < $exclnum; $lt++){
			if(isset($_POST["item$lt"]) and isset($_POST["chk$lt"])){
				$item=$_POST["item$lt"];
				$sql = "$call query_add_exclusion(:item, :uid)";
				$rsing = $rdb->prepare($sql);
                $rsing->bindValue(':item', $item);
                $rsing->bindValue(':uid', $uid);
                $rsing->execute();
                $err=$rdb->errorInfo();
                $rsing->closeCursor();
			}
		}
	}
	echo "Exclusion List Saved";
?>
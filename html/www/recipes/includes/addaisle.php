<?php

    require_once('rdb.php');

    $aisleid=$_POST['aisleid'];
    $aisle=$_POST['aisle'];

    if (!isset($aisleid)) {
        echo "ok";
        $sql="$call query_aisle_exists(:aisle)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':aisle', $aisle);
        $result->execute();
        $err=$rdb->errorInfo();
        $rows = $result->rowCount();
        $result->closeCursor();
        if ($rows==0) {
            $sql="$call query_add_aisle(:aisle)";
            $rsimg = $rdb->prepare($sql);
            $rsimg->bindValue(':aisle', $aisle);
            $rsimg->execute();
            $err=$rdb->errorInfo();
            $rsimg->closeCursor();
        }
    } else {
        //check aisle has an order value
		$sql="$call query_aisle_has_order(:aisleid,:uid)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':aisleid', $aisleid);
        $result->bindValue(':uid', $uid);
        $result->execute();
        $err=$rdb->errorInfo();
        $oaresult = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
        
		$aorder=$oaresult[0];
        
		if (isset($aorder)) {
	
		    $aisles=$_POST['aisles'];
		    $sql="select distinct aisle, aisle_order from ingredient_owner where aisle in (select id from aisles where aisle in($aisles)) order by aisle_order,aisle";
		    $result = $rdb->prepare($sql);
            $result->execute();
            $err=$rdb->errorInfo();
            $onum=$result->rowCount();
            $oresult = $result->fetchAll(PDO::FETCH_BOTH);
            $result->closeCursor();
		    
		    for ($lt = 0; $lt < $onum; $lt++) {
		        if ($oresult[$lt][0]==$aisleid) {
			        $order=$oresult[$lt][1];
			        /*if (!isset($order) || $order==$onum-1) {
			            echo 'ok';
			        } else {*/
			            echo $order;
			        //}
			        break;
		        }
		    }
		} else {
		    echo "ok";
		}
    }
?>
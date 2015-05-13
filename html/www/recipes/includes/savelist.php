<?php
	require_once('rdb.php');

    if(isset($_POST['id'])) {
       $id = $_POST['id']; 
    }
	if(isset($_POST['list'])) {
       $list = $_POST['list']; 
    }
	
	$ingnum = $_POST['ingnum'];

	for ($lt = 0; $lt < $ingnum; $lt++){
        if(isset($_POST["chk$lt"])) {
		    if($_POST["chk$lt"]!='on'){
			    $ingfound=1;
			    break;
		    }
        }
	}


	if (!isset($list) && !isset($ingfound)) {
		echo "0|A shopping list name and at least 1 ingredient are required";
    } elseif (!isset($list)) {
        echo "0|A shopping list name is required";
    } elseif (!isset($ingfound)) {
        echo "0|At least 1 ingredient is required";
	} else {
		if(isset($id)) {
			//we are editing an existing menu so we delete it before saving the updated version
			$sql="$call query_delete_list(:id)";
            $rsing = $rdb->prepare($sql);
            $rsing->bindValue(':id', $id);
            $rsing->execute();
            $err=$rdb->errorInfo();
            $rsing->closeCursor();
		} else {
			$newlist=1;
		}
		$sql= "$call query_add_list(:uid, :list)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->bindValue(':list', $list);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
        
		$sql="$call query_new_list_id(:list,:uid)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->bindValue(':list', $list);
        $result->execute();
        $err=$rdb->errorInfo();
		$resultid = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
                           
        $id = $resultid[0];

		for ($lt = 0; $lt < $ingnum; $lt++){
			if(isset($_POST["listitem$lt"]) and isset($_POST["chk$lt"])){
				$item=$_POST["listitem$lt"];
				$ing=$_POST["ing$lt"];
                if(isset($_POST["recid$lt"])) {
                    $recid=$_POST["recid$lt"];
                }
				                
                $sql = "$call query_ingredient_exists(:ing)";
				$result = $rdb->prepare($sql);
                $result->bindValue(':ing', $ing);
                $result->execute();
                $err=$rdb->errorInfo();
                $resultid = $result->fetch(PDO::FETCH_BOTH);
                $result->closeCursor();
                
				$ingid=$resultid[0];
                
                if (!isset($recid)) {
                    $sql = "$call query_add_list_entry(:id, :item, :ingid, null)";
                    $result = $rdb->prepare($sql);
                    $result->bindValue(':id', $id);
                    $result->bindValue(':item', $item);
                    $result->bindValue(':ingid', $ingid);
                } else {
				    $sql = "$call query_add_list_entry(:id, :item, :ingid, :recid)";
                    $result = $rdb->prepare($sql);
                    $result->bindValue(':id', $id);
                    $result->bindValue(':item', $item);
                    $result->bindValue(':ingid', $ingid);
                    $result->bindValue(':recid', $recid);
                }
				$result->execute();
                $err=$result->errorInfo();
                $result->closeCursor();
			}
		}
        $msg= $id."|Shopping List Saved|";
        if(isset($newlist)) {
           $msg .= $newlist; 
        }
		echo $msg;
	}
?>
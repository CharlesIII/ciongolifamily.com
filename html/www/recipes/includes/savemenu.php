<?php
    require_once('rdb.php');
    
	if(isset($_POST['menu'])) {
        $menu = $_POST['menu'];
    }
    $recipefound=0;

	foreach ($_POST['recid'] as $key=>$value){
		if(isset($value)){
			$recipefound=1;
			break;
		}
	}

	if (!isset($menu) || $recipefound=0) {
		$err1 = "A meal plan name and at least 1 recipe are required.";
	} else {
        $sql="$call query_menu_exists(:menu,:uid)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->bindValue(':menu', $menu);
        $result->execute();
        $err=$rdb->errorInfo();
        $rows = $result->rowCount();
        $resultid = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
        
        if($rows>0) {
            //we are editing an existing menu so we delete it before saving the updated version
            $oldid=$resultid[0];
			$sql="$call query_delete_menu(:oldid)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':oldid', $oldid);
            $result->execute();
            $err=$rdb->errorInfo();
            $result->closeCursor();
            $newmenu=0;
        }  else {
            $newmenu=1;
        }
        
		$sql = "$call query_add_menu(:uid, :menu)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->bindValue(':menu', $menu);
        $result->execute();
        $err=$rdb->errorInfo();
        $result->closeCursor();
		
		$sql="$call query_new_menu_id(:menu,:uid)";
		$result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->bindValue(':menu', $menu);
        $result->execute();
        $err=$rdb->errorInfo();
        $resultid = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
		                       
        $id = $resultid[0];

		foreach ($_POST['recid'] as $key=>$value){
            $recid = $value;
            $link=$_POST["link"][$key];
            $day=$_POST["day"][$key];
            $rank=$key;
            $meal=$_POST["meal"][$key];
            
            $sql = "INSERT INTO menu_recipe (menu,link,recipe,day,rank,meal) VALUES (:id,:link,:recid,:day,:rank,:meal)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':id', $id);
            $result->bindValue(':link', $link);
            $result->bindValue(':recid', $recid);
            $result->bindValue(':rank', $rank);
            $result->bindValue(':meal', $meal);
            $result->bindValue(':day', $day);
            $result->execute();
            $err=$rdb->errorInfo();
            $result->closeCursor();
        }	
		echo $id."|Meal Plan Saved|".$newmenu;
	}

	if (isset($err1) || isset($err3)) {
		$msgtxt = "0|Save Unsuccessful";
		if (isset($err1)) {
			$msgtxt .= " - ".$err1;
		}
		if (isset($err3)){
			$msgtxt .= " - ".$err3;
		}
		echo $msgtxt;
	}
?>
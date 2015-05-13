<?php
    require_once('rdb.php');

    $id=$_POST['id'];
    
	$sql="$call query_related_recipes(:id)";
    $dbrel = $rdb->prepare($sql);
    $dbrel->bindValue(':id', $id);
    $dbrel->execute();
    $err=$rdb->errorInfo();
    $rrrows = $dbrel->rowCount();
    $rsrel = $dbrel->fetchAll(PDO::FETCH_BOTH);
    $dbrel->closeCursor();
    
    if($rrrows>0) {
        for ($lt = 0; $lt < $rrrows; $lt++) {
            $relid = $rsrel[$lt][1];
            $relrecipe = $rsrel[$lt][3];      
            $relrecipes[$lt] = array('relid' => $relid, 'relname' => $relrecipe);
        }
        $response['relrecipes'] = $relrecipes;
       
        echo json_encode($response);
    }
?>
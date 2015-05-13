<?php
    require_once('rdb.php');

    $kw = $_POST['kw'];
    $kwnum=count($kw);
    if(isset($_POST['oid'])) {
      $oid = $_POST['oid'];
    }
    
    if($client=='wrm') {
        $sql="$call query_owner_recipes_with_name_id(:oid)";
        $dbrecipe = $rdb->prepare($sql);
        $dbrecipe->bindValue(':oid', $oid);
    } else {
        $sql="$call query_recipes_with_name_id()";
        $dbrecipe = $rdb->prepare($sql);
    }
    $dbrecipe->execute();
    $err=$rdb->errorInfo();

    $numr = $dbrecipe->rowCount();
    $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
    $dbrecipe->closeCursor();
        
    for ($lt = 0; $lt < $numr; $lt++) {
        $recnum=0;
        foreach($kw as $value) {
           $pos = stripos($rsrecipe[$lt][1],"$value");
           if ($pos>-1) {
                $recnum++;
           }
        }
        if ($recnum==$kwnum) {
            $id=$rsrecipe[$lt][0];
            if(isset($idlist)) {
                $idlist .= ",$id";
            } else {
               $idlist="$id"; 
            }
        }

    }
    if(isset($idlist)) {
        require_once('searchmenu.php');
    }
?>

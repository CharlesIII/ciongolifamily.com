<?php

    require_once('rdb.php');

    $sql="SELECT unit, base from unit_base";
    $dbunit = $rdb->prepare($sql);
    $dbunit->execute();
    $err=$rdb->errorInfo();
    $unitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
    $urows = $dbunit->rowCount();
    $dbunit->closeCursor();
    
    
    for ($lt = 0; $lt < $urows; $lt++) {
        $unit = $unitarray[$lt][0];
        $base = $unitarray[$lt][1];
        
        $units[$lt] = array('unit' => $unit, 'base' => $base);
    }
    $response['units'] = $units;
    
    echo json_encode($response);
?>

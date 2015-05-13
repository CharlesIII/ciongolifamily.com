<?php

//set up unit arrays

    $eingarray=array('salt','pepper','garlic powder','egg');
    $sql="SELECT unit from unit_base where unit LIKE '% %'";
    $dbunit = $rdb->prepare($sql);
    $dbunit->execute();
    $err=$rdb->errorInfo();
    $mwunitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
    $dbunit->closeCursor();
    
    $sql="SELECT unit from unit_base where unit NOT LIKE '% %'";
    $dbunit = $rdb->prepare($sql);
    $dbunit->execute();
    $err=$rdb->errorInfo();
    $unitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
    $dbunit->closeCursor();

?>
<?php
require_once('rdb.php');

        $sql="$call query_delete_unused()";
        $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
   
?>
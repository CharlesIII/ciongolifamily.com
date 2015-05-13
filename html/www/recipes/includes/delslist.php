<?php
            $lid=$_POST['list'];
            if ($lid) {
                require_once('rdb.php');
                $sql="$call query_delete_list(:lid)";
                $rsing = $rdb->prepare($sql);
                $rsing->bindValue(':lid', $lid);
                $rsing->execute();
                $err=$rdb->errorInfo();
                $rsing->closeCursor();
                echo 'ok';
            }
?>

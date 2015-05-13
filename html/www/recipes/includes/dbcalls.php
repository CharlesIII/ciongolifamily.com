<?php
  if ($dbsql=='mysql') {
        $dbtype='mysql';
        $call='CALL';
  } else {
        $dbtype='pgsql';
        $call='SELECT * FROM';
  }
?>

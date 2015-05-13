<?php
try {
    $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);
}
catch(PDOException $e) {
    $msg = $e->getMessage();
    if (isset($msg)) {
        echo 'nodb';
        exit;
    }
}
?>
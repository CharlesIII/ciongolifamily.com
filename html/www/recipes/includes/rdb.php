<?php
    session_set_cookie_params(0, '/');
    session_start();
    
    require_once('dbclient.php');
    require_once('dbcalls.php');
    
    if(isset($_SESSION[$client.'user'])) {
    
        $user=$_SESSION[$client.'user'];
        $uid=$_SESSION[$client.'uid'];

        if($client=='wrm'){
            require_once('dbvars.php');
        }

        if (!$rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"))) {//connect to database
            echo 'nodb';
            exit;
        }
    }
?>

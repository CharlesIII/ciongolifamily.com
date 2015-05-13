<?php
	session_set_cookie_params('0', '/');
	session_start();
    
    if(isset($_GET['logout'])) {
        session_unset();
        header("Refresh:0 ; URL=index.php");
        exit;
    }

	//*****any changes here must also be made in export & ebook

	require_once('includes/dbclient.php');
    require_once('includes/dbcalls.php');

    if(!isset($_SESSION[$client.'user'])) {
        //$page = curPageName();
        //header("Refresh:0 ; URL=index.php?timeout=yes&lastpage=".$page);
        header("Refresh:0 ; URL=index.php?timeout=yes");
        exit;
    }
    function curPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

    $user=$_SESSION[$client.'user'];
    $suser=$_SESSION[$client.'suser'];
    $uid=$_SESSION[$client.'uid'];
    $limit=$_SESSION[$client.'limit'];
    if(isset($_SESSION[$client.'rapp'])) {
         $rapp=$_SESSION[$client.'rapp'];
    }
    if(isset($_SESSION[$client.'datefmt'])) {
        $seldate = $_SESSION[$client.'datefmt'];
    }
    if(isset($_SESSION[$client.'admin'])) {
        $admin=$_SESSION[$client.'admin'];
    }
    if(isset($_SESSION[$client.'guest'])) {
        $guest=$_SESSION[$client.'guest'];
    }
    
    if($client=='wrm') {
        $oid=$_SESSION[$client.'oid'];
        $owner=$_SESSION[$client.'owner'];
        require_once('includes/dbvars.php');
    }

    $rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    if (curPageName() == 'display.php' || curPageName() == 'menuplanner.php' || curPageName() == 'shopping-list.php' || substr(curPageName(),0,4) == 'norm') {
        if( strcasecmp($_SERVER['REQUEST_METHOD'],"POST") === 0) {
            $_SESSION['postdata'] = $_POST;
            header("Location: ".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
            exit;
        }
        if( isset($_SESSION['postdata'])) {
            $_POST = $_SESSION['postdata'];
            unset($_SESSION['postdata']);
        }        
    }
    
	if(isset($_GET['public'])) {
	       $id=$_GET['id'];
           $sql = "$call query_recipe_is_public(:id)";
           $public = $rdb->prepare($sql);
           $public->bindValue(':id', $id);
           $public->execute();
           $err=$rdb->errorInfo();
	       
           $check = $public->fetchColumn();
           $public->closeCursor();
           
	       if (isset($check) && $check) {
		          $public='yes';
		          $ipaddress = $_SERVER["REMOTE_ADDR"];
                  
		          $sql="$call query_log_public_access(:id,:ipaddress)";
                  $public = $rdb->prepare($sql);
                  $public->bindValue(':id', $id);
                  $public->bindValue(':ipaddress', $ipaddress);
                  $public->execute();
                  $err=$rdb->errorInfo();
                  $public->closeCursor();
	       }
	}

	if($user and $user!='') {
        if($client=='wrm') {
            $sql="$call query_owner_str(:user)";
            $crapp = $rdb->prepare($sql);
            $crapp->bindValue(':user', $user);
            $crapp->execute();
            $err=$rdb->errorInfo();
            $sendstr = $crapp->fetchColumn();
            $crapp->closeCursor();
            
            $sql="$call query_recipes_with_name_id_owner_visible(:oid)";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->bindValue(':oid', $oid);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number(:oid)";  //return all users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->bindValue(':oid', $oid);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users = $dbusers->rowCount();
            $rsusers = $dbusers->fetchAll(PDO::FETCH_BOTH);            
            $dbusers->closeCursor();
                                                     
        } else {
                        
            $sql="$call query_recipes_with_name_id_owner_visible()";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number()";  //return all approved users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users=$dbusers->rowCount();
            $rsusers = $dbusers->fetchAll(PDO::FETCH_BOTH);            
            $dbusers->closeCursor();
            
            $sql = "$call query_unapp_user_number()";  //return all unapproved users from db
            $dbuausers = $rdb->prepare($sql);
            $dbuausers->execute();
            $err=$rdb->errorInfo();
            $uausers=$dbuausers->rowCount();
            $dbuausers->closeCursor();
        }
        
        $sql = "$call query_user_recipe_number(:uid)";  //return all recipes from db
        $dburecipe = $rdb->prepare($sql);
        $dburecipe->bindValue(':uid', $uid);
        $dburecipe->execute();
        $err=$rdb->errorInfo();
        $urecipes = $dburecipe->rowCount();
        $dburecipe->closeCursor();
        
        if($client=='wrm') {
            $sql="$call query_recipe_number(:oid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        } else {
            $sql="$call query_recipe_number()";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        }
        if (isset($admin) && isset($rapp)) {
            $appct=0;
            while($row = $dbrecipe->fetch(PDO::FETCH_BOTH)) {
              $apprec=$row[1];
              if ($apprec) $appct++;
            }
            $unapprec = $recipes-$appct;
        }
        $dbrecipe->closeCursor();
	} else if(!isset($public)) {
		session_unset();
		header("Refresh:0 ; URL=index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="utf-8">
                <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <link href="css/slidebars.css" rel="stylesheet">
                <link href="css/slidebars-theme.css" rel="stylesheet">
                <link href="css/style.css" rel="stylesheet" media="screen">
		        <script src="js/jquery-1.11.0.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/slidebars.min.js"></script>
                <script src="js/jquery_cookie.js"></script>
		        <script src="js/my.messi.js"></script>
		        <script src="js/my.dropdown.js"></script>
		        <script src="js/my.scrolling.msgbox.js"></script>
		        <script src="js/my.font.size.js"></script>
                <script src="js/my.timeout.js"></script>
                <meta content="summary" name="twitter:card">
                <meta content="yes" name="apple-mobile-web-app-capable">
                <meta content="black" name="apple-mobile-web-app-status-bar-style">
                <link href="images/16.png" type="image/png" rel="icon">
                <link sizes="32x32" href="images/32.png" type="image/png" rel="icon">
                <link sizes="48x48" href="images/48.png" type="image/png" rel="icon">
                <link sizes="64x64" href="images/64.png" type="image/png" rel="icon">
                <link sizes="120x120" href="images/152.png" rel="apple-touch-icon">
                <link sizes="152x152" href="images/120.png" rel="apple-touch-icon">
                <link sizes="76x76" href="images/76.png" rel="apple-touch-icon">
                <link sizes="114x114" href="images/114.png" rel="apple-touch-icon">
                <link sizes="57x57" href="images/57.png" rel="apple-touch-icon">
                <link sizes="144x144" href="images/144.png" rel="apple-touch-icon">
                <link sizes="72x72" href="images/72.png" rel="apple-touch-icon">
                <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/1096.png">
                <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" href="images/920.png">
                <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" href="images/460.png">
                <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="images/2008.png">
                <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" href="images/1496.png">
                <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" href="images/1004.png">
                <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" href="images/748.png">
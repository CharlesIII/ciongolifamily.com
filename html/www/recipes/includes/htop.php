<!DOCTYPE html>
<?php
	require_once('includes/dbclient.php');
    require_once('includes/dbcalls.php');
    if($client=='wrm'){
        require_once('includes/dbvars.php');
    }
	
	function curPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
?>
<html lang="en">
        <head>
                <meta charset="utf-8">
                <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <link href="css/slidebars.css" rel="stylesheet">
                <link href="css/slidebars-theme.css" rel="stylesheet">
                <link href="css/style.css" rel="stylesheet">
		        <script src="js/jquery-1.11.0.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/slidebars.min.js"></script>
		        <script src="js/my.scrolling.msgbox.js"></script>
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
                <script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                  ga('create', 'UA-11897355-1', 'auto');
                  ga('send', 'pageview');

                </script>
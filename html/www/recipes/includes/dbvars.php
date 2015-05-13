<?php
if ((isset($user) && (substr($user,0,5)=='demo_' || $user=='demo')) || (isset($suser) && $suser=='demo')) {
    $dbrecipes = "barbwool_demo";
} else {
    $dbrecipes = "barbwool_demo";
}
$dbstate = "barbwool_countries";
$dbawbs = "barbwool_awbs";
$scpath="http://localhost/wrm/awbs/";
$sscpath="https://localhost/wrm/awbs/";
?>
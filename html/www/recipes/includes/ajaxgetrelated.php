<?php
require_once('rdb.php');

$relid=$_POST['relid'];
    
$sql = "$call query_recipe(:relid)";
$dbrrecipe = $rdb->prepare($sql);
$dbrrecipe->bindValue(':relid', $relid);
$dbrrecipe->execute();
$err=$rdb->errorInfo();
$rsrrecipe = $dbrrecipe->fetch(PDO::FETCH_BOTH);
$dbrrecipe->closeCursor();

$rdirections=stripslashes(nl2br(trim($rsrrecipe[1])));
$rnote = stripslashes(nl2br(trim($rsrrecipe[2])));
$ryield = rtrim(trim($rsrrecipe[7], '0'), '.');
$ryield_unit = $rsrrecipe[10];
$rname = $rsrrecipe[0];

    $recipe[1] = array('relid' => $relid, 'rname' => $rname);
    if(isset($rdirections) && $rdirections != "") {
        $recipe[1]['rdirections'] = $rdirections;               
    } else {
        $recipe[1]['rdirections'] = null;
    }
    if(isset($rnote) && $rnote!="") {
        $recipe[1]['rnote'] = $rnote;               
    } else {
        $recipe[1]['rnote'] = null;
    }
    if(isset($ryield) && $ryield!="") {
        $recipe[1]['ryield'] = $ryield;               
    } else {
        $recipe[1]['ryield'] = null;
    }
    if(isset($ryield_unit)) {
        $recipe[1]['ryield_unit'] = $ryield_unit;               
    } else {
        $recipe[1]['ryield_unit'] = null;
    }

$sql="$call query_recipe_ings(:relid)";
$dbing = $rdb->prepare($sql);
$dbing->bindValue(':relid', $relid);
$dbing->execute();
$err=$rdb->errorInfo();
$irows = $dbing->rowCount();
$rsing = $dbing->fetchAll(PDO::FETCH_BOTH);
$dbing->closeCursor();

for ($lt=0;$lt < $irows;$lt++) {
        $quantity = $rsing[$lt][0];
        $qtydec=$rsing[$lt][7];
        $unit = $rsing[$lt][1];
        $quantity2 = $rsing[$lt][5];
        $eunit = $rsing[$lt][6];
        $ing = $rsing[$lt][2];
        $pp = $rsing[$lt][3];
        $pp1 = $rsing[$lt][4];
        
        $ings[$lt] = array('ing' => $ing);
        if(isset($quantity)) {
            $ings[$lt]['quantity'] = $quantity;               
        } else {
            $ings[$lt]['quantity'] = null;
        }
        if(isset($qtydec)) {
            $ings[$lt]['qtydec'] = $qtydec;               
        } else {
            $ings[$lt]['qtydec'] = null;
        }
        if(isset($unit)) {
            $ings[$lt]['unit'] = $unit;               
        } else {
            $ings[$lt]['unit'] = null;
        }
        if(isset($quantity2)) {
            $ings[$lt]['quantity2'] = $quantity2;               
        } else {
            $ings[$lt]['quantity2'] = null;
        }
        if(isset($eunit)) {
            $ings[$lt]['eunit'] = $eunit;               
        } else {
            $ings[$lt]['eunit'] = null;
        }
        if(isset($pp)) {
            $ings[$lt]['pp'] = $pp;               
        } else {
            $ings[$lt]['pp'] = null;
        }
        if(isset($pp1)) {
            $ings[$lt]['pp1'] = $pp1;               
        } else {
            $ings[$lt]['pp1'] = null;
        }
    }
    if(isset($ings)) {
        $response['ings'] = $ings;
    }
    $response['recipe'] = $recipe;
    echo json_encode($response);
?>
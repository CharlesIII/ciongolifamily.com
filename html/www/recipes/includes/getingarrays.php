<?php
    require_once('rdb.php');

	$sql="SELECT get_unit(unit) as unitname from unit_owner where owner=:uid order by unitname";
    $dbunit = $rdb->prepare($sql);
    $dbunit->bindValue(':uid', $uid);
    $dbunit->execute();
    $err=$rdb->errorInfo();
    $unitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
    $urows = $dbunit->rowCount();
    $dbunit->closeCursor();
    
    for ($lt = 0; $lt < $urows; $lt++) {
        $unit = $unitarray[$lt][0];      
        $units[$lt] = array('value' => $unit);
    }
    if ($urows>0) {
        $response['units'] = $units;
    }
	
	$sql="SELECT get_ingredient(ingredient) as ingname from ingredient_owner where owner=:uid order by ingname";
    $dbing = $rdb->prepare($sql);
    $dbing->bindValue(':uid', $uid);
    $dbing->execute();
    $err=$rdb->errorInfo();
    $ingarray = $dbing->fetchAll(PDO::FETCH_BOTH);
    $irows = $dbing->rowCount();
    $dbing->closeCursor();
    
    for ($lt = 0; $lt < $irows; $lt++) {
        $ing = $ingarray[$lt][0];
        $ings[$lt] = array('value' => $ing);
    }
    if ($irows>0) {
        $response['ings'] = $ings;
    }
    
    $sql="SELECT get_preprep(preprep) as ppname from preprep_owner where owner=:uid order by ppname";
    $dbpp = $rdb->prepare($sql);
    $dbpp->bindValue(':uid', $uid);
    $dbpp->execute();
    $err=$rdb->errorInfo();
    $pparray = $dbpp->fetchAll(PDO::FETCH_BOTH);
    $prows = $dbpp->rowCount();
    $dbpp->closeCursor();
    
    for ($lt = 0; $lt < $prows; $lt++) {
        $pp = $pparray[$lt][0];
        $pps[$lt] = array('value' => $pp);
    }
    if ($prows>0) {
        $response['pps'] = $pps;
    }
    
    $sql="SELECT get_source(source) as srcname from source_owner where owner=:uid order by srcname";
    $dbsrc = $rdb->prepare($sql);
    $dbsrc->bindValue(':uid', $uid);
    $dbsrc->execute();
    $err=$rdb->errorInfo();
    $srcarray = $dbsrc->fetchAll(PDO::FETCH_BOTH);
    $srows = $dbsrc->rowCount();
    $dbsrc->closeCursor();
    
    for ($lt = 0; $lt < $srows; $lt++) {
        $src = $srcarray[$lt][0];
        $srcs[$lt] = array('value' => $src);
    }
    if ($srows>0) {
        $response['srcs'] = $srcs;
    }
    
    $sql="SELECT get_cuisine(cuisine) as cuisinename from cuisine_owner where owner=:uid order by cuisinename";
    $dbcuisine = $rdb->prepare($sql);
    $dbcuisine->bindValue(':uid', $uid);
    $dbcuisine->execute();
    $err=$rdb->errorInfo();
    $cuisinearray = $dbcuisine->fetchAll(PDO::FETCH_BOTH);
    $crows = $dbcuisine->rowCount();
    $dbcuisine->closeCursor();
    
    for ($lt = 0; $lt < $crows; $lt++) {
        $cuisine = $cuisinearray[$lt][0];
        $cuisines[$lt] = array('value' => $cuisine);
    }
    if ($crows>0) {
        $response['cuisines'] = $cuisines;
    }
    
    $sql="SELECT get_yield_unit(yield_unit) as yield_unitname from yield_unit_owner where owner=:uid order by yield_unitname";
    $dbyield_unit = $rdb->prepare($sql);
    $dbyield_unit->bindValue(':uid', $uid);
    $dbyield_unit->execute();
    $err=$rdb->errorInfo();
    $yield_unitarray = $dbyield_unit->fetchAll(PDO::FETCH_BOTH);
    $yurows = $dbyield_unit->rowCount();
    $dbyield_unit->closeCursor();
    
    for ($lt = 0; $lt < $yurows; $lt++) {
        $yield_unit = $yield_unitarray[$lt][0];
        $yield_units[$lt] = array('value' => $yield_unit);
    }
    if ($yurows>0) {
        $response['yield_units'] = $yield_units;
    }
    
    $sql="SELECT get_measure(measure) as measurename from measure_owner where owner=:uid order by measurename";
    $dbmeasure = $rdb->prepare($sql);
    $dbmeasure->bindValue(':uid', $uid);
    $dbmeasure->execute();
    $err=$rdb->errorInfo();
    $measurearray = $dbmeasure->fetchAll(PDO::FETCH_BOTH);
    $mrows = $dbmeasure->rowCount();
    $dbmeasure->closeCursor();
    
    for ($lt = 0; $lt < $mrows; $lt++) {
        $measure = $measurearray[$lt][0];
        $measures[$lt] = array('value' => $measure);
    }
    if ($mrows>0) {
        $response['measures'] = $measures;
    }
    
    if($client=='wrm') {
        $sql="$call query_owner_cats(:uid)";
        $dbcat = $rdb->prepare($sql);
        $dbcat->bindValue(':uid', $uid);
        $dbcat->execute();
        $err=$rdb->errorInfo();
        $rscat = $dbcat->fetchAll(PDO::FETCH_BOTH);
        $catrows = $dbcat->rowCount();
        $dbcat->closeCursor();
        
        $sql="$call query_owner_subcats(:uid)";
        $dbscat = $rdb->prepare($sql);
        $dbscat->bindValue(':uid', $uid);
        $dbscat->execute();
        $err=$rdb->errorInfo();
        $rsscat = $dbscat->fetchAll(PDO::FETCH_BOTH);
        $scatrows = $dbscat->rowCount();
        $dbscat->closeCursor();
        
    } else {
        $sql="$call query_cats()";
        $dbcat = $rdb->prepare($sql);
        $dbcat->execute();
        $err=$rdb->errorInfo();
        $rscat = $dbcat->fetchAll(PDO::FETCH_BOTH);
        $catrows = $dbcat->rowCount();
        $dbcat->closeCursor();

        
        $sql="$call query_subcats()";
        $dbscat = $rdb->prepare($sql);
        $dbscat->execute();
        $err=$rdb->errorInfo();
        $rsscat = $dbscat->fetchAll(PDO::FETCH_BOTH);
        $scatrows = $dbscat->rowCount();
        $dbscat->closeCursor();
    }
    
    
    for ($lt = 0; $lt < $catrows; $lt++) {
        $cat = $rscat[$lt][0];
        $cats[$lt] = array('value' => $cat);
    }
    if ($catrows>0) {
        $response['cats'] = $cats;
    }
    
    for ($lt = 0; $lt < $scatrows; $lt++) {
        $scat = $rsscat[$lt][0];
        $scats[$lt] = array('value' => $scat);
    }
    if ($scatrows>0) {
        $response['scats'] = $scats;
    }
    
    $sql="$call query_recipe_names(:uid)";
    $dbrecipe = $rdb->prepare($sql);
    $dbrecipe->bindValue(':uid', $uid);
    $dbrecipe->execute();
    $err=$rdb->errorInfo();
    $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
    $rrows = $dbrecipe->rowCount();
    $dbrecipe->closeCursor();
    
    for ($lt = 0; $lt < $rrows; $lt++) {
        $recipe = $rsrecipe[$lt][0];
        $recipes[$lt] = array('value' => $recipe);
    }
    if ($rrows>0) {
        $response['recipes'] = $recipes;
    }
    
    $sql="$call query_owner_diets(:uid)";
    $dbdiet = $rdb->prepare($sql);
    $dbdiet->bindValue(':uid', $uid);
    $dbdiet->execute();
    $err=$rdb->errorInfo();    
    $numdt = $dbdiet->rowCount();
    $rsdiet = $dbdiet->fetchAll(PDO::FETCH_BOTH);
    $dbdiet->closeCursor();
    
    for ($lt = 0; $lt < $numdt; $lt++) {
        $diet = $rsdiet[$lt][0];
        $diets[$lt] = array('value' => $diet);
    }
    if ($numdt>0) {
        $response['diets'] = $diets;
    }
    
    echo json_encode($response);
?>
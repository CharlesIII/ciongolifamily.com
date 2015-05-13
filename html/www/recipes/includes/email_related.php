<?php
$sql = "$call query_recipe(:relid)";
$rdbrecipe = $rdb->prepare($sql);
$rdbrecipe->bindValue(':relid', $relid);
$rdbrecipe->execute();
$err=$rdb->errorInfo();
$rrsrecipe = $rdbrecipe->fetch(PDO::FETCH_BOTH);
$rdbrecipe->closeCursor();

$rname = $rrsrecipe[0];

$sql="$call query_recipe_ings(:relid)";
$rdbing = $rdb->prepare($sql);
$rdbing->bindValue(':relid', $relid);
$rdbing->execute();
$err=$rdb->errorInfo();
$rirows = $rdbing->rowCount();
$rrsing = $rdbing->fetchAll(PDO::FETCH_BOTH);
$rdbing->closeCursor();

$body .= "<br><h3 style='font-size:18px;font-weight:bold;'>$rname</h3><br>";

if ($rirows>0) {
	$body .= "<strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Ingredients</strong><br><br>";

	$body .= '<table>';
    for ($rlt = 0; $rlt < $rirows; $rlt++) {
        $body .= '<tr>';
        $rquantity = $rrsing[$rlt][0];
        if (isset($rquantity)) {
            $body .= "<td>$rquantity</td>";
        } else {
            $body .= "<td></td>";
        }
        $runit = $rrsing[$rlt][1];
        $rquantity2 = $rrsing[$rlt][5];
        $reunit = $rrsing[$rlt][6];
        if (isset($runit)) {
            $body .= "<td>$runit";
            if (isset($rquantity2) && isset($eunit)) {
               $body .= "($rquantity2 $reunit)"; 
            } else if (isset($rquantity2)) {
               $body .= "($rquantity2)"; 
            } else if (isset($eunit)) {
               $body .= "($rquantity2)";
            }
            $body .= "</td>"; 
        }  else {
            $body .= "<td></td>";
        }
        $ring = $rrsing[$rlt][2];
        if (isset($ring)) {
           $body .= "<td>$ring";
           $rpp = $rrsing[$rlt][3];
            if ($rpp) {
                $body .= ", $rpp";
            }
            $rpp = $rrsing[$rlt][4];
            if ($rpp) {
                $body .= ", $rpp";
            }
            $body .= "</td>"; 
        }  else {
            $body .= "<td></td>";
        }
        
        
        $body .= "</tr>";
    }
    $body .= '</table>';
}

$rnote = $rrsrecipe[2];
if($rnote) {
	$note = stripslashes(nl2br($rnote));
	$body .= "<br><strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Notes</strong><br><br>$rnote<br><br>";
}

$rdirections=$rrsrecipe[1];
if ($rdirections) {
	$rdirections = stripslashes(nl2br($rdirections));
	$body .= "<br><strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Directions</strong><br><br>";
	$body .= "$rdirections";
}

?>
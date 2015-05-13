<?php
$sql = "$call query_recipe(:relid)";
$rrs = $rdb->prepare($sql);
$rrs->bindValue(':relid', $relid);
$rrs->execute();
$err=$rdb->errorInfo();
$rrsrecipe = $rrs->fetch(PDO::FETCH_BOTH);
$rrs->closeCursor();

$rname = $rrsrecipe[0];
$rname=iconv('UTF-8', 'windows-1252', $rname);

$sql="$call query_recipe_ings(:relid)";
$rrs = $rdb->prepare($sql);
$rrs->bindValue(':relid', $relid);
$rrs->execute();
$err=$rdb->errorInfo();
$rirows = $rrs->rowCount();
$rrsing = $rrs->fetchAll(PDO::FETCH_BOTH);
$rrs->closeCursor();
	
$word_output .= "<br><h3 style='font-size:18px;margin-top:10px;margin-bottom:10px;'>$rname</h3><br>";

if ($rirows>0) {
	$word_output .= "<strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Ingredients</u></strong><br><br>";
    $word_output .= '<table>';
	for ($rlt = 0; $rlt < $rirows; $rlt++) {
		$word_output .= '<tr>';
        $rquantity = $rrsing[$rlt][0];
        if (isset($rquantity)) {
            $word_output .= "<td>$rquantity</td>";
        }
        $runit = $rrsing[$rlt][1];
        $rquantity2 = $rrsing[$rlt][5];
        $reunit = $rrsing[$rlt][6];
        if (isset($runit)) {
            $word_output .= "<td>$runit";
            if (isset($rquantity2) && isset($eunit)) {
               $word_output .= "($rquantity2 $reunit)"; 
            } else if (isset($rquantity2)) {
               $word_output .= "($rquantity2)"; 
            } else if (isset($eunit)) {
               $word_output .= "($rquantity2)";
            }
            $word_output .= "</td>"; 
        }
        $ring = $rrsing[$rlt][2];
        if (isset($ring)) {
           $word_output .= "<td>$ring";
           $rpp = $rrsing[$rlt][3];
            if ($rpp) {
                $word_output .= ", $rpp";
            }
            $rpp = $rrsing[$rlt][4];
            if ($rpp) {
                $word_output .= ", $rpp";
            }
            $word_output .= "</td>"; 
        }
        
        
        $word_output .= "</tr>";
	}
    $word_output .= '</table>';
}
$word_output .= '<hr>';

$rnote = $rrsrecipe[2];
if($rnote) {
	$rnote = stripslashes(nl2br($rnote));
    $rnote=iconv('UTF-8', 'windows-1252', $rnote);
	$word_output .= "<br><strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Notes</u></strong><br><br>$rnote<br><br>";
}

$rdirections=$rrsrecipe[1];
if ($rdirections) {
	$rdirections = stripslashes(nl2br($rdirections));
    $rdirections=iconv('UTF-8', 'windows-1252', $rdirections);
	$word_output .= "<br><strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Directions</u></strong><br><br>";
	$word_output .= "$rdirections";
}

?>
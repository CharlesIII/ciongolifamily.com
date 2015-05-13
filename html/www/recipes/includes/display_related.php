<?php
$sql = "SELECT * from query_recipe($relid)";
$rsrrecipe = pg_query($connection,$sql);
$ryield = rtrim(trim(pg_result($rsrrecipe, 0, 7), '0'), '.');
$ryield_unit = pg_result($rsrrecipe, 0, 10);
$rname = str_replace('"',"'",pg_result($rsrrecipe, 0, 0));
$rmeasure = pg_result($rsrrecipe, 0, 12);

$sqling="SELECT * from query_recipe_ings($relid)";
$rsing = pg_query($connection,$sqling);

$rhdr=$rname;
print("<br class=noprint><h3>$rhdr</h3>");
echo '<br><br>';
$numring=pg_numrows($rsing);
if ($numring>0) {
	echo '<strong>Ingredients</strong><br><br>';
}
//handle resizing if required
if ($_POST['rbut_val'] && $_POST['rscale']=='yes') {
    unset($rfraction);
    unset($reuro);
	for ($lt1 = 0; $lt1 < $numring; $lt1++) {
		$rqty1chk=pg_result($rsing, $lt1, 0);
	    $rqtydec=pg_result($rsing, $lt1, 7);
	    if ($rqty1chk and !$rqtydec) {
		    $resizeerror++;
		    break;
	    }
	    if (strchr($rqty1chk,'/')>-1) { //we have a fraction or mixed number
		    $rfraction++;
	    }
	    if (strchr($rqty1chk,',')>-1) { //we have a european format number
		    $reuro++;
	    }
	    $rqty2chk=pg_result($rsing, $lt1, 5);
	    if (strchr($rqty2chk,'/')>-1) { //we have a fraction or mixed number
		    $rfraction++;
	    }
	    if (strchr($rqty2chk,',')>-1) { //we have a european format number
		    $reuro++;
	    }
    }

    if (!$resizeerror) {
		$rnew_yield=$_POST['rbut_val'];
		$rfactor = $rnew_yield/$ryield;
		$ryield = $rnew_yield;
	}
}
//end resizing
for ($lt2 = 0; $lt2 < $numring; $lt2++) {
	$rquantity = pg_result($rsing, $lt2, 0);
	//handle resizing if required
	if ($rfactor) {
		//echo round($factor,3);
		$rqtydec=pg_result($rsing, $lt2, 7);
		if ($rqtydec) {
			$rquantity=$rqtydec*round($rfactor,3);
			$rquantity=round($rquantity,3);
			if ($fraction) {
				$rquantity=toFraction($rquantity);
				$rquantity=str_replace('333/1000','1/3',$rquantity);
				$rquantity=str_replace('667/1000','2/3',$rquantity);
				$rquantity=str_replace('167/1000','1/6',$rquantity);
				$rquantity=str_replace('167/500','1/3',$rquantity);
				$rquantity=str_replace('833/1000','5/6',$rquantity);
				$rquantity=str_replace('83/250','1/3',$rquantity);
				$rquantity=str_replace('73/250','1/3',$rquantity);
				$rquantity=str_replace('73/125','1/2',$rquantity);
				$rquantity=str_replace('21/500','1/24',$rquantity);
				$rquantity=str_replace('21/250','1/12',$rquantity);
				$rquantity=str_replace('501/1000','1/2',$rquantity);
				$rquantity=str_replace('229/500','1/2',$rquantity);
				$rquantity=str_replace('499/1000','1/2',$rquantity);
				$rquantity=str_replace('251/1000','1/4',$rquantity);
				$rquantity=str_replace('167/250','2/3',$rquantity);
				$rquantity=str_replace('271/500','1/2',$rquantity);
				$rquantity=str_replace('583/1000','2/3',$rquantity);
				$rquantity=str_replace('83/1000','1/12',$rquantity);
				$rquantity=str_replace('999/1000','1',$rquantity);
				$rquantity=str_replace('917/1000','1',$rquantity);
				$rquantity=str_replace('417/1000','5/12',$rquantity);
				$rquantity=str_replace('417/500','4/5',$rquantity);
				$rquantity=str_replace('4999999999999/5.0E+15','',$rquantity);
				$rquantity=str_replace('26/125','1/5',$rquantity);
				$rquantity=str_replace('1/1000','',$rquantity);
				$rquantity=str_replace('0/1','',$rquantity);
			} else if ($reuro) {
				$rquantity = str_replace('.',',',$rquantity);
			}
			if (strpos($rquantity,' ')>0 and strpos($rquantity,'/')===false) {
				$rfirstnum=substr($rquantity,0,strpos($rquantity,' '));
				$rsecondnum=substr($rquantity,strpos($rquantity,' ')+1);
				$rquantity=$rfirstnum + $rsecondnum;
			}
		}
	}
	//end ressizing
	$runit = pg_result($rsing, $lt2, 1);
	echo $rquantity,' ',$runit;
	$rquantity2 = pg_result($rsing, $lt2, 5);
	//handle resizing if required
	if ($rfactor) {
		$rquantity2 = str_replace('¼','1/4',$rquantity2);
		$rquantity2 = str_replace('½','1/2',$rquantity2);
		$rquantity2 = str_replace('¾','3/4',$rquantity2);
		$rdash=strchr($rquantity2,'-');
		$rto=strchr($rquantity2,'to');
		$ror=strchr($rquantity2,'or');
		if ( $rdash>-1 || $rto>-1 || $ror>-1) { //we may have a range in the quantity
			 if ($rdash>-1) {
				 $rdashspot=strpos($rquantity2,'-'); //find the first occurence of the dash
			 } else if ($to>-1) {
				 $rdashspot=strpos($rquantity2,'to'); //find the first occurence of the to
			 } else if ($or>-1) {
				 $rdashspot=strpos($rquantity2,'or'); //find the first occurence of the to
			 }
			 $rquantity2=substr($rquantity2,0,$rdashspot);
		}
		if (strchr($rquantity2,'/')>-1) { //we have a fraction or mixed number
			$rmatch = extract_numbers($rquantity2);
			//$ct=-1;
			if (count($rmatch)==2) { //we have a fraction
				$rqtydec2=$rmatch[0]/$rqtydec=$match[1];
			} else if (count($rmatch)>2) { //the qty is a mixed number
				$rqtydec2=$rmatch[0] + ($rmatch[1] / $rmatch[2]);
			}
		} else if (strchr($rquantity2,',')>-1) { //we have a european format number
			$rqtydec2 = str_replace('.','',$rquantity2);
			$rqtydec2 = str_replace(',','.',$rquantity2);
		} else {
			$rqtydec2=$rquantity2;
		}
		if ($rqtydec2) {
			if (is_numeric($rqtydec2)) {
				$rquantity2=$rqtydec2*round($rfactor,3);
				$rquantity2=round($rquantity2,3);
				if ($rfraction) {
					$rquantity2=toFraction($rquantity2);
					$rquantity2=str_replace('333/1000','1/3',$rquantity2);
					$rquantity2=str_replace('667/1000','2/3',$rquantity2);
					$rquantity2=str_replace('167/1000','1/6',$rquantity2);
					$rquantity2=str_replace('167/500','1/3',$rquantity2);
					$rquantity2=str_replace('833/1000','5/6',$rquantity2);
					$rquantity2=str_replace('83/250','1/3',$rquantity2);
					$rquantity2=str_replace('73/250','1/3',$rquantity2);
					$rquantity2=str_replace('73/125','1/2',$rquantity2);
					$rquantity2=str_replace('21/500','1/24',$rquantity2);
					$rquantity2=str_replace('21/250','1/12',$rquantity2);
					$rquantity2=str_replace('501/1000','1/2',$rquantity2);
					$rquantity2=str_replace('229/500','1/2',$rquantity2);
					$rquantity2=str_replace('499/1000','1/2',$rquantity2);
					$rquantity2=str_replace('251/1000','1/4',$rquantity2);
					$rquantity2=str_replace('167/250','2/3',$rquantity2);
					$rquantity2=str_replace('271/500','1/2',$rquantity2);
					$rquantity2=str_replace('583/1000','2/3',$rquantity2);
					$rquantity2=str_replace('83/1000','1/12',$rquantity2);
					$rquantity2=str_replace('417/500','4/5',$rquantity2);
					$rquantity2=str_replace('999/1000','1',$rquantity2);
					$rquantity2=str_replace('917/1000','1',$rquantity2);
					$rquantity2=str_replace('417/1000','5/12',$rquantity2);
					$rquantity2=str_replace('4999999999999/5.0E+15','',$rquantity2);
					$rquantity2=str_replace('26/125','1/5',$rquantity2);
					$rquantity2=str_replace('1/1000','',$rquantity2);
					$rquantity2=str_replace('0/1','',$rquantity2);
				}
				if ($euro) {
					$rquantity2 = str_replace('.',',',$rquantity2);
				}
				if (strpos($rquantity2,' ')>0 and strpos($rquantity2,'/')===false) {
					$rfirstnum=substr($rquantity2,0,strpos($rquantity2,' '));
					$rsecondnum=substr($rquantity2,strpos($rquantity2,' ')+1);
					$rquantity2=$rfirstnum + $rsecondnum;
				}
			} else {
				$raltqtyerror++;
			}
		}
	}
	//end ressizing
	$reunit = pg_result($rsing, $lt2, 6);
	if ($rquantity2 and $reunit) {
		echo '(',$rquantity2,' ',$reunit,')';
	} else if ($rquantity2) {
		echo '(',$rquantity2,')';
	} else if ($reunit) {
		echo '(',$reunit,')';
	}
	$ring = pg_result($rsing, $lt2, 2);
	echo ' ',$ring;
	$rpp = pg_result($rsing, $lt2, 3);
	if ($rpp) {
		echo ', ',$rpp;
	}
	$rpp1 = pg_result($rsing, $lt2, 4);
	if ($rpp1) {
		echo ', ',$rpp1;
	}
	echo '<br>';
}

echo '<br>';

echo '<hr class=nofs>';

$rnote = trim(pg_result($rsrrecipe, 0, 2));
if($rnote) {
	echo '<strong>Notes</strong><br><br>',stripslashes(nl2br($rnote)),'<br>';
}

$rdirections=trim(pg_result($rsrrecipe, 0, 1));
if ($rdirections) {
	echo '<strong>Directions</strong><br><br>';
	echo stripslashes(nl2br($rdirections));
}
if ($ryield) {
	print ("<br><br><strong>Makes: </strong>$ryield $ryield_unit</td></tr>");
}
?>
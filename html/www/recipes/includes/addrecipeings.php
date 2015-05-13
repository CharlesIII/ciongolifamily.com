<?php

	function euclid ($number_one, $number_two) {

		if (($number_one == 0) or ($number_two == 0)) {
		$hcf = 1;
		return $hcf;
		} else {
			if ($number_one < $number_two) {
			  $buffer = $number_one;
			  $number_one = $number_two;
			  $number_two = $buffer;
			}

			$dividend = $number_one;
			$divisor = $number_two;
			$remainder = $dividend;

			while ($remainder > 0) {
			  if ((floor($dividend/$divisor)) == ($dividend/$divisor)) {
				  $quotient = $dividend/$divisor;
				  $remainder = 0;
			  }	else {
				  $quotient = floor($dividend/$divisor);
				  $remainder = $dividend - ($quotient * $divisor);
			  }
			  $hcf = $divisor;
			  $dividend = $divisor;
			  $divisor = $remainder;
			}
		}
	return $hcf;
	}
	function toFraction ($decimal) {
		if ($decimal == 0) {
		  $whole = 0;
		  $numerator = 0;
		  $denominator = 1;
		  $top_heavy = 0;
		} else {
			$sign = 1;
			if ($decimal < 0) {
			  $sign = -1;
			}
			if (floor(abs($decimal)) == 0) {
				$whole = 0;
				$conversion = abs($decimal);
			} else {
				$whole = floor(abs($decimal));
				$conversion = abs($decimal);
			}
			$power = 1;
			$flag = 0;
			while ($flag == 0) {
			  $argument = $conversion * $power;
			  if ($argument == floor($argument)) {
				$flag = 1;
			  }
			  else {
				$power = $power * 10;
			  }
			}

			$numerator = $conversion * $power;
			$denominator = $power;

			$hcf = euclid ($numerator, $denominator);

			$numerator = $numerator/$hcf;
			$denominator = $denominator/$hcf;
			$whole = $sign * $whole;
			$top_heavy = $sign * $numerator;

			$numerator = abs($top_heavy) - (abs($whole) * $denominator);

			if (($whole == 0) && ($sign == -1)) {
			  $numerator = $numerator * $sign;
			}
		}
		if ($whole and $numerator==0) {
		  return $whole;
		} else if ($whole) {
            return $whole.' '.$numerator.'/'.$denominator;
        } else {
            return $numerator.'/'.$denominator;
        }
	}

	require_once('rdb.php');
    
    $recipelist=$_POST['recipelist'];
    
	//bring in all the related recipes for the recipes in the recipe list and add them to the recipe list
	$recarray = explode(",",$recipelist);
	while (list ($key, $val) = each ($recarray)) {
		$sql="$call query_related_recipes(:val)";
        $rel = $rdb->prepare($sql);
        $rel->bindValue(':val', $val);
        $rel->execute();
        $err=$rdb->errorInfo();
        $relrecnum = $rel->rowCount();
        $rsrel = $rel->fetchAll(PDO::FETCH_BOTH);
        $rel->closeCursor();
        
		if ($relrecnum>0) {
			for ($lt = 0; $lt < $relrecnum; $lt++) {
				$relid = $rsrel[$lt][1];
				$recipelist .=",$relid";
			}
		}
	}
    if($dbsql=='mysql') {
        $sql="select sum(qtydec), get_unit(unit) as unit, get_ingredient(ing) as ingredient from recipe_ing where recipe in($recipelist) and ing not in(select ing from excluded_ing where owner=$uid) and binary upper(get_ingredient(ing)) != get_ingredient(ing) group by ingredient, unit order by ingredient";
    } else {
	    $sql="select sum(qtydec), get_unit(unit) as unit, get_ingredient(ing) as ingredient from recipe_ing where recipe in($recipelist) and ing not in(select ing from excluded_ing where owner=$uid) and upper(get_ingredient(ing)) != get_ingredient(ing) group by ingredient, unit order by ingredient";
    }
	$rec_ing = $rdb->prepare($sql);
    $rec_ing->execute();
    $err=$rdb->errorInfo();
    $recrows = $rec_ing->rowCount();
    $rec_ings = $rec_ing->fetchAll(PDO::FETCH_BOTH);
    $rec_ing->closeCursor();
    
	if($dbsql=='mysql') {
        $sql="select DISTINCT get_unit(unit) as unit, get_ingredient(ing) as ing, (SELECT get_aisle(aisle) FROM ingredient_owner WHERE ingredient=ing and owner=$uid) as aisle, recipe, get_ing_aisle_order(ing,$uid) as aisle_order, (SELECT aisle IS null FROM ingredient_owner WHERE ingredient=ing and owner=$uid) as anull, get_ing_aisle_order(ing,$uid) IS NULL as aonull from recipe_ing where recipe in($recipelist) and ing not in(select ing from excluded_ing where owner=$uid) and binary upper(get_ingredient(ing)) != get_ingredient(ing) order by aonull, aisle_order, anull, aisle, ing";
    } else {
        $sql="select DISTINCT get_unit(unit) as unit, get_ingredient(ing) as ing, (SELECT get_aisle(aisle) FROM ingredient_owner WHERE ingredient=ing and owner=$uid) as aisle, recipe, get_ing_aisle_order(ing,$uid) as aisle_order, (SELECT aisle IS null FROM ingredient_owner WHERE ingredient=ing and owner=$uid) as anull, get_ing_aisle_order(ing,$uid) IS NULL as aonull from recipe_ing where recipe in($recipelist) and ing not in(select ing from excluded_ing where owner=$uid) and upper(get_ingredient(ing)) != get_ingredient(ing) order by aonull, aisle_order, anull, aisle, ing";
    }
    $ings_recipe = $rdb->prepare($sql);
    $ings_recipe->execute();
    $err=$rdb->errorInfo();
    $numi = $ings_recipe->rowCount();
    $ings_recipes = $ings_recipe->fetchAll(PDO::FETCH_BOTH);
    $ings_recipe->closeCursor();
     
	for ($lt = 0; $lt < $numi; $lt++) {
		$qty=0;
        unset($image);
		$unit=$ings_recipes[$lt][0];
		$ing=$ings_recipes[$lt][1];
		$recipe=$ings_recipes[$lt][3];
        
		$sql="select name from recipe where id=$recipe";
        $recname = $rdb->prepare($sql);
        $recname->execute();
        $err=$rdb->errorInfo();
        $recnames = $recname->fetch(PDO::FETCH_BOTH);
        $recname->closeCursor();
        
        $sql="$call query_recipe_images(:recipe)";
        $recimg = $rdb->prepare($sql);
        $recimg->bindValue(':recipe', $recipe);
        $recimg->execute();
        $err=$rdb->errorInfo();
        $imgrows = $recimg->rowCount();
        $recimgs = $recimg->fetch(PDO::FETCH_BOTH);
        $recimg->closeCursor();
                
		if ($imgrows>0) {
			$image=$recimgs[1];
		}
		$name=$recnames[0];
        
		for ($lt2 = 0; $lt2 < $recrows; $lt2++) {
			if ($rec_ings[$lt2][1]==$unit && $rec_ings[$lt2][2]==$ing) {
				$qty = $qty + $rec_ings[$lt2][0];
			}
		}

		$qtydec= toFraction($qty);
		$qtydec=str_replace('333/1000','1/3',$qtydec);
		$qtydec=str_replace('667/1000','2/3',$qtydec);
		$qtydec=str_replace('167/1000','1/6',$qtydec);
		$qtydec=str_replace('833/1000','5/6',$qtydec);
		$qtydec=str_replace('0/1','',$qtydec);
		$listitem=$qtydec.' '.$unit.' '.$ing;
		$listitem = preg_replace('/\s+/', ' ',$listitem);
		$aisle=$ings_recipes[$lt][2];
        $aisle_order=$ings_recipes[$lt][4];
		$ings[$lt] = array('item' => $listitem, 'ing' => $ing);
            if(isset($aisle)) {
                $ings[$lt]['aisle'] = $aisle;               
            } else {
                $ings[$lt]['aisle'] = null;
            }
            if(isset($image)) {
                $ings[$lt]['image'] = $image;               
            } else {
                $ings[$lt]['image'] = null;
            }
            if(isset($name)) {
                $ings[$lt]['name'] = $name;               
            } else {
                $ings[$lt]['name'] = null;
            }
            if(isset($recipe)) {
                $ings[$lt]['recid'] = $recipe;               
            } else {
                $ings[$lt]['recid'] = null;
            }
            if(isset($aisle_order)) {
                $ings[$lt]['aisle_order'] = $aisle_order;               
            } else {
                $ings[$lt]['aisle_order'] = null;
            }
	}
    if(isset($ings)) {
	    $response['ings'] = $ings;
    }
    if (isset($response)) {
	    echo json_encode($response);
    } else {
        echo 'noings';
    }
?>
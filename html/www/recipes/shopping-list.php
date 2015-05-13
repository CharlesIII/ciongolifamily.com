<?php
    require_once('includes/top.php');
    
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
?>
    <title>Shopping Lists</title>
    <meta name="description" content="Create shopping lists from meal plans, recipes, previously purhased items or manually.">
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.ui.multidraggable.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
	<script src="js/my.shopping.js"></script>
    <script src="js/my.combo.js"></script>
	<script src="js/decode.min.js"></script>
    <link href="css/print.css" rel="stylesheet" type="text/css" media="print">
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
		if (isset($status)) {
			if ($status=='suspended') {
				echo "<script>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                    $('.message_box').show();
                </script>";
			}
		}
	$ct=0;
    if (isset($_POST['id'])) {
	    foreach($_POST['id'] as $key => $id) {
	        $recipelist[] = array('ing' => $id);
	    }
    }
	
	if (isset($recipelist)) {
        $recipelist=json_encode($recipelist);   
	} 
    ?>
    <div id="sb-site" class="sb-slide">
            <div class=container>
                <div class="row">
                    <!-- content start -->
                    <div class="col-xs-12 col-sm-12">
			            <h3><strong>shopping </strong>lists</h3>
			            <!--<form name='form1' method=post id=addsl>-->
				            <div class='noprint sdiv'>
					            <div class=dib>
						            <INPUT type=submit name=save value=Save class="btn save lloaded" style="display:none;">
					            </div>
					            <div class=dib>
						            <INPUT type=submit name=delete value='Delete' class='btn delete lloaded' style="display:none;">
					            </div>
					            <div class=dib>
						            <INPUT type=submit name=clear value='Clear' class="btn clear lloaded" style="display:none;">
					            </div>
				            
					            <?php
						            if (isset($recipelist)) {
							            print("<div class='dib'>
								            <INPUT type=submit name=backmenu value='Meal Plan' class='btn backmenu' onclick=this.form.action='menuplanner.php'>
							            </div>");
						            }
					            ?>
					            <div class=dib>
						            <INPUT type=button id=prints name=prints value='Print' class='btn lloaded' onclick="window.print();" style="display:none;">
					            </div>
                                <div class=dib>
						            <INPUT type=button id=email name=email value='Email' class='btn lloaded' onclick=emaillist(); style="display:none;">
					            </div>
                                <div class='dib'>
                                    <INPUT type=button name=shopping value='Shopping' class="btn shopping" style="display:none;">
                                </div>
                                <div class='dib sdib'>
                                    <INPUT type=button name=nm value='Normal View' id=norm class="nm">
                                </div>
                                <div class='dib sdib'>
                                    <INPUT type=button name=drag value='Drag On' id=dragtoggle class="nm">
                                </div>
                                
				            </div>
			            <br class=noprint>
			            <div class='noprint noshop'>
				            
				            <div class=dib>
					            <strong>Saved Shopping Lists:</strong>
				            </div>
				            <div class=dib>
					            <?php
						            if (isset($_POST['list'])) {
							            $selid=$_POST['list'];
						            }
						            if (isset($items)) {
							            $ingnum=count($items);
						            }  else {
							            $ingnum=0;
						            }
						            print("<input id='ingnum' type=hidden name='ingnum' value=$ingnum>");
						            $sql = "$call query_owner_lists(:uid)";  //return all shopping lists from db
						            $dblist = $rdb->prepare($sql);
                                    $dblist->bindValue(':uid', $uid);
                                    $dblist->execute();
                                    $err=$rdb->errorInfo();
                                    
                                    $numsl = $dblist->rowCount();
                                    $rslist = $dblist->fetchAll(PDO::FETCH_BOTH);
                                    $dblist->closeCursor();
                                    
						            print("<select class=form-control id=slist name=slist onKeyPress='return disableEnterKey(event)'>");
						            if (!isset($selid)) {
							            print("<option></option>");
						            }
						            for ($lt = 0; $lt < $numsl; $lt++) {
							            $id = $rslist[$lt][0];
							            $list = $rslist[$lt][1];
							            if (!isset($selid) || (isset($selid) && $selid!=$id)) {
								            print("<option value=$id>$list</option>");
							            } else if (isset($selid)){
								            print("<option selected value=$id>$list</option>");
							            }
						            }
                                    echo '</select>';
					            ?>
				            </div>
			            </div>
			            
			            <br class=noprint>
                        <div id=accordion>
			                <h3 class="noprint">Add Aisles, Ingredients or Recipes</h3>
			                <div class="noprint">                    
                                <br class=noprint>
                                <strong class=noshop>Add Recipes: </strong>
                                <div id='rdrop' class="noprint form-control"></div>
                                <br class=noprint>
                                <INPUT type=submit id=addr name=addr value='Add Recipes' class=btn>
                                <br class=noprint>
                                <br class=noprint>
				                <strong class=noshop>Ingredients: </strong>
				                <?php
					                $sql="$call query_owner_nexcl_ingredients_ids_no_hdr(:uid)";
                                    $ingdb = $rdb->prepare($sql);
                                    $ingdb->bindValue(':uid', $uid);
                                    $ingdb->execute();
                                    $err=$rdb->errorInfo();

                                    $iingnum = $ingdb->rowCount();
                                    $ingrs = $ingdb->fetchAll(PDO::FETCH_BOTH);
                                    $ingdb->closeCursor();
                                    
                                    /*$sql="$call query_owner_slitems_ids_aisles(:uid)";
                                    $sldb = $rdb->prepare($sql);
                                    $sldb->bindValue(':uid', $uid);
                                    $sldb->execute();
                                    $err=$rdb->errorInfo();

                                    $slingnum = $sldb->rowCount();
                                    $slrs = $sldb->fetchAll(PDO::FETCH_BOTH);
                                    $sldb->closeCursor();*/
                                    
                                    print("<select class='form-control dib' id=ings name=ings style='width:200px;'>");
                                    print("<option selected value=0>Choose ingredients...</option>");
                                    
                                    for ($lt = 0; $lt < $iingnum; $lt++) {
                                        $iid = $ingrs[$lt][0];
                                        $iing = $ingrs[$lt][1];
                                        print("<option value=$iid>$iing</option>");
                                    }
                                    print("</select>");
				                ?>
				                <br class=noprint><br class=noprint>
				                <TEXTAREA  class="sl_2 noprint form-control" id='other' name='other' rows=5></TEXTAREA>
                                <br class=noprint>
				                <INPUT type=submit id=add name=add value='Add Ingredients' class=btn>
				                <br class=noprint><br class=noprint>
				                <div class='noprint noshop'>
                                    <div class=dib>
                                        <strong>Add Aisle:</strong>
                                    </div>
                                    <div class=dib>
                                        <?php
                                            if (isset($_POST['aisle'])) {
                                                $aisleid=$_POST['aisle'];
                                            }
                                            print("<select class=form-control id=aisle name=aisle onKeyPress='return disableEnterKey(event)'>");
                                            if (!isset($aisleid)) {
                                                print("<option></option>");
                                            }
                                            $sql = "$call query_owner_aisle_list(:uid)";  //return all aisles from db
                                            $dbaisle = $rdb->prepare($sql);
                                            $dbaisle->bindValue(':uid', $uid);
                                            $dbaisle->execute();
                                            $err=$rdb->errorInfo();

                                            $numa = $dbaisle->rowCount();
                                            $rsaisle = $dbaisle->fetchAll(PDO::FETCH_BOTH);
                                            $dbaisle->closeCursor();
                    
                                            for ($lt = 0; $lt < $numa; $lt++) {
                                                $id = $rsaisle[$lt][0];
                                                $aisle = $rsaisle[$lt][1];
                                                if (!isset($aisleid) || (isset($aisleid) && $aisleid!=$id)) {
                                                    print("<option value=$id>$aisle</option>");
                                                } else if (isset($aisleid)){
                                                    print("<option selected value=$id>$aisle</option>");
                                                }
                                            }
                                            echo '</select>';
                                        ?>
                                    </div>
                               </div>
                               <br class=noprint>
                               <INPUT type=submit id=adda name=adda value='Add Aisle' class=btn>
			                </div>
                        </div>
                        <div id=list class=list>
				            <?php
					            if (isset($recipelist)) {
                                    print("<script language='JavaScript'>
                                            addrecipeings($recipelist);
                                         </script>");
                                    unset($recipelist);
					            }
				            ?>
			            </div>
			            <div class='noprint sdiv'>
				            <div class=dib>
                                <INPUT type=submit name=save value=Save class="btn save lloaded" style="display:none;">
                            </div>
                            <div class=dib>
                                <INPUT type=submit name=delete value='Delete' class='btn delete lloaded' style="display:none;">
                            </div>
                            <div class=dib>
                                <INPUT type=submit name=clear value='Clear' class="btn clear lloaded" style="display:none;">
                            </div>
                            
                            <?php
                                if (isset($recipelist)) {
                                    print("<div class='dib'>
                                        <INPUT type=submit name=backmenu value='Meal Plan' class='btn backmenu' onclick=this.form.action='menuplanner.php'>
                                    </div>");
                                }
                            ?>
                            <div class=dib>
                                <INPUT type=button id=prints name=prints value='Print' class='btn lloaded' onclick="window.print();" style="display:none;">
                            </div>
                            <div class=dib>
                                <INPUT type=button id=email name=email value='Email' class='btn lloaded' onclick=emaillist(); style="display:none;">
                            </div>
                            <div class='dib'>
                                <INPUT type=button name=shopping value='Shopping' class="btn shopping" style="display:none;">
                            </div>
                            <div class='dib sdib'>
                                <INPUT type=button name=nm value='Normal View' id=norm class="nm">
                            </div>
                            <div class='dib sdib'>
                                <INPUT type=button name=drag value='Drag On' id=dragtoggle class="nm">
                            </div>
			            </div>
			            <br class=noprint>
			            <input type=hidden id=client name=client value=<?php echo $client;?>>
                        <?php
                        if(isset($_POST['menu'])) {
			                echo "<input type=hidden name=menu value=".$_POST['menu'].">";
                        }
                        if(isset($curraisles)) {
                           print("<input id='aislenum' type=hidden name='aislenum' value=$curraisles>");
                        } else {
                           print("<input id='aislenum' type=hidden name='aislenum' value=''>"); 
                        }
                        if(isset($rand)) {
                           print("<input id='rand' type=hidden name='rand' value=$rand>");
                        }  else {
                           print("<input id='rand' type=hidden name='rand' value=''>"); 
                        }
                        ?>
			            <input type=hidden id=rdropped value=''>
			            <input type=hidden id=recipelist value=''>
			            
	        
		            <!--</FORM>-->
	            </div>	
            <?php
                    require_once('includes/bottom.php');
            ?>
    
            
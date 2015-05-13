<?php
require_once('includes/top.php');
    
	function extract_numbers($string){
	    preg_match_all('/([\d]+)/', $string, $match);
	    return $match[0];
	}
?>
        <title>Add edit or copy recipes</title>
        <meta name="description" content="Add edit or copy recipes.">
        <script src="js/decode.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
		<link rel="stylesheet" href="css/jquery.ui.plupload.css" type="text/css" />
        <script src="js/moxie.min.js"></script>
		<script src="js/plupload.full.min.js"></script>
		<script src="js/jquery.ui.plupload.min.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.css"> 
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
		if (isset($status)) {
			if ($status=='suspended') {
				echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                    $('.message_box').show();
                </script>";
			}
		}
	
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
		}
		if (isset($_POST['added'])) {
			$added = $_POST['added'];
		}
		if (isset($_POST['edit']) or isset($_GET['edit'])) {
			$hdr = '<strong>edit</strong> recipe';
		} else if(isset($_POST['cbut_val']) && $_POST['cbut_val']=='Copy'){
			$hdr = '<strong>copy</strong> recipe';
		} else {
            $hdr = '<strong>add</strong> new recipe';
        }
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				<?php
					print("<h3>$hdr</h3>");
				?>
                <form name='form1' id=addrecipe enctype="multipart/form-data">
					<input type=submit name=save value=Save class=btn>
					<span id="msgbox" style="display:none"></span>
					<script type="text/javascript" language="javascript">
						$("#msgbox").removeClass().addClass('messagebox').text('Button disabled while page is loading....').fadeIn(1000);
						$('.btn').attr('disabled', 'disabled');
					</script>
					
					<br><br>
					<div  style='width:100%;'>
						<div class=dib>
							<strong>Name*</strong>
						</div>
						<div class=dib>
							<input id=name type=text style='width:300px;' name='name' class=form-control
							<?PHP
								if(isset($_POST['name'])) {
									$name=$_POST['name'];
                                    $name=stripslashes($name);
                                    print(" value=".'"'.$name.'"');
								}
							?>
							>
						</div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Measurement System</strong>
						</div>
						<div class=dib>
							<?PHP
                                $sql = "$call query_user_prefs(:uid)";
								$ownerprefs = $rdb->prepare($sql);
                                $ownerprefs->bindValue(':uid', $uid);
                                $ownerprefs->execute();
                                $err=$rdb->errorInfo();

                                $rsownerprefs = $ownerprefs->fetch(PDO::FETCH_BOTH);
                                $selms=$rsownerprefs[6];
                                $ownerprefs->closeCursor();
		
								if (isset($_POST['measure']) && $_POST['measure']!='') {
									$selms=$_POST['measure'];
								}
								if (isset($selms)) {
                                    print("<input class=form-control name='measure' id='measure' style='max-width:300px; min-width:100px;' value='$selms'>");
                                } else {
                                   print("<input class=form-control name='measure' id='measure' style='max-width:300px; min-width:100px;'>");
                                }
							?>
						</div>
					</div>
					<br>
					<div>
					<?php
						for ($lt1 = 0; $lt1 < 4; $lt1++) {
							unset($selcategory);
		
							if ($lt1 == 0) {
								print("<div class=dib><strong>Recipe Type*</strong><br>");
							}
							if (isset($_POST["cat$lt1"])) {
								$selcategory = $_POST["cat$lt1"];
                                $selcategory=stripslashes($selcategory);
                                
							}
                            if (isset($selcategory)) {
                                    print("<input class='cat form-control' id=cat$lt1 name=cat$lt1 style='max-width:300px; min-width:100px;' value='$selcategory'>");
                                } else {
                                   print("<input class='cat form-control' id=cat$lt1 name=cat$lt1 style='max-width:300px; min-width:100px;'>");
                                }
							if ($lt1 == 3) {
								print("</div>");
							}
						}
						for ($lt1 = 0; $lt1 < 4; $lt1++) {
							unset($selsubcategory);
		
							if ($lt1 == 0) {
								print("<div class=dib><strong>Category</strong><br>");
							}
							if (isset($_POST["scat$lt1"])) {
								$selsubcategory = $_POST["scat$lt1"];
                                $selsubcategory=stripslashes($selsubcategory);
							}
                            if (isset($selsubcategory)) {
                                    print("<input class='scat form-control' id=scat$lt1 name=scat$lt1 style='max-width:300px; min-width:100px;' value='$selsubcategory'>");
                                } else {
                                   print("<input class='scat form-control' id=scat$lt1 name=scat$lt1 style='max-width:300px; min-width:100px;'>");
                                }
							if ($lt1 == 3) {
								print("</div></div>");
							}
						}
						if (isset($_POST['ing']) and $_POST['ing']!= '') {
                            $ingsel=0;
							require_once('includes/parseing.php');
							if ($ingsel==0) {
								$ingsel=10;
							} else {
								$ingsel=$ingsel+3;
							}
							if ($ingsel>45) {
								$ingsel=45;
							}
						}
					?>
					<br>
					<strong class=rheader>Ingredients</strong>
                    <ul id=sorting>
					<?php
						if (!isset($ingsel)) {
                            $ingsel=0;
							for ($lt1 = 0; $lt1 < 45; $lt1++) {
								if (isset($_POST["ing$lt1"]) and $_POST["ing$lt1"]!="") {
									$ingsel++;
								}
							}
							if ($ingsel==0) {
								$ingsel=10;
							} else {
								$ingsel=$ingsel+3;
							}
							if ($ingsel>45) {
								$ingsel=45;
							}
						}
		
						for ($lt1 = 0; $lt1 < $ingsel; $lt1++) {
							unset($selquantity);
							unset($selunit);
							unset($selquantity2);
							unset($seleunit);
							unset($seling);
							unset($selpp);
							unset($selpp2);
				
							if (isset($_POST["qty$lt1"])) {
								$selquantity = $_POST["qty$lt1"];
							} else if (isset(${'qty'.$lt1})) {
								$selquantity = ${'qty'.$lt1};
							}
				
							if (isset($_POST["unit$lt1"])) {
								$selunit = $_POST["unit$lt1"];
							} else if(isset(${'unit'.$lt1})){
								$selunit = ${'unit'.$lt1};
							}
				
							if (isset($_POST["eqty$lt1"])) {
								$selquantity2 = $_POST["eqty$lt1"];
							} else if(isset(${'eqty'.$lt1})){
								$selquantity2 = ${'eqty'.$lt1};
							}
				
							if (isset($_POST["eunit$lt1"])) {
								$seleunit = $_POST["eunit$lt1"];
							} else if(isset(${'eunit'.$lt1})){
								$seleunit = ${'eunit'.$lt1};
							}
				
							if (isset($_POST["ing$lt1"])) {
								$seling = $_POST["ing$lt1"];
                                $seling=stripslashes($seling);
							} else if(isset(${'ing'.$lt1})){
								$seling = ${'ing'.$lt1};
							}
				
							if (isset($_POST["pp1$lt1"])) {
								$selpp = $_POST["pp1$lt1"];
                                $selpp=stripslashes($selpp);
							} else if(isset(${'pp1'.$lt1})){
								$selpp = ${'pp1'.$lt1};
							}
				
							if (isset($_POST["pp2$lt1"])) {
								$selpp2 = $_POST["pp2$lt1"];
                                $selpp2=stripslashes($selpp2);
							} else if(isset(${'pp2'.$lt1})){
								$selpp2 = ${'pp2'.$lt1};
							}
				
							if ($lt1 == 0) {
                                print("<div style='width:980px;' class=topiheader>
                                    <div class='dib' style='width:71px;margin-left:17px;'><strong>Qty</strong></div>
                                    <div class=dib style='width:106px;margin:0;'><strong>Unit</strong></div>
                                    <div class='dib' style='width:71px'><strong>Qty2</strong></div>
                                    <div class=dib style='width:106px;'><strong>Unit2</strong></div>
                                    <div class=dib style='width:206px;'><strong>Ingredient</strong></div>
                                    <div class=dib style='width:176px;'><strong>Prepreparation/Note</strong></div>
                                    <div class=dib style='width:176px;'><strong>Prepreparation/Note</strong></div>
                                    </div>");
								print("<li id=l$lt1><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>");
                                if(isset($selquantity)) {
								    print("<div class=dib><span class='iheaders idib'><strong>Qty</strong></span><input type=text id=qty$lt1 class='smallinp form-control idib' value='".$selquantity."'></div>");
								} else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Qty</strong></span><input type=text id=qty$lt1 class='smallinp form-control idib' value=''></div>");
                                }
                                if(isset($selunit)) {
                                    print('<div class=dib><span class="iheaders idib"><strong>Unit</strong></span><input type=text id=unit'.$lt1.' style="width:110px;" value="'.$selunit.'" class="unit form-control idib">');
								} else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Unit</strong></span><input type=text id=unit$lt1 style='width:110px;' value='' class='unit form-control idib'>");
                                }
							} else {
                                /*print("<div><div class='dib iheaders' style='width:71px;margin-left:17px;'><strong>Qty</strong></div>
                                    <div class='dib iheaders' style='width:106px;margin:0;'><strong>Unit</strong></div>
                                    <div class='dib iheaders' style='width:71px'><strong>Qty2</strong></div>
                                    <div class='dib iheaders' style='width:106px;'><strong>Unit2</strong></div>
                                    <div class='dib iheaders' style='width:206px;'><strong>Ingredient</strong></div>
                                    <div class='dib iheaders' style='width:176px;'><strong>Prepreparation/Note</strong></div>
                                    <div class='dib iheaders' style='width:176px;'><strong>Prepreparation/Note</strong></div>
                                    </div>");*/
								print("<li id=l$lt1><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>");
                                if(isset($selquantity)) {
								    print("<div class='dib'><span class='iheaders idib'><strong>Qty</strong></span><input type=text id=qty$lt1 class='smallinp form-control idib' value='".$selquantity."'></div>");
                                } else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Qty</strong></span><input type=text id=qty$lt1 class='smallinp form-control idib' value=''></div>");
                                }
                                if(isset($selunit)) {
								    print('<div class=dib><span class="iheaders idib"><strong>Unit</strong></span><input type=text class="unit form-control idib" id=unit'.$lt1.' style="width:110px;" value="'.$selunit.'">');
								} else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Unit</strong></span><input type=text class='unit form-control idib' id=unit$lt1 style='width:110px;' value=''>");
                                }
							}
							echo '</div>';
				
							if ($lt1 == 0) {
                                if(isset($selquantity2)) {
                                      print("<div class=dib><span class='iheaders idib'><strong>Qty2</strong></span><input type=text id=eqty$lt1 class='smallinp form-control idib' value='".$selquantity2."'></div>");
                                } else {
								    print("<div class=dib><span class='iheaders idib'><strong>Qty2</strong></span><input type=text id=eqty$lt1 class='smallinp form-control idib' value=''></div>");
								}
                                if(isset($seleunit)) {
                                    print('<div class=dib><span class="iheaders idib"><strong>Unit2</strong></span><input type=text id=eunit'.$lt1.' style="width:110px;" value="'.$seleunit.'" class="unit form-control idib">');
                                } else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Unit2</strong></span><input type=text id=eunit$lt1 style='width:110px;' value='' class='unit form-control idib'>");
                                }
							} else {
                                if(isset($selquantity2)) {
								    print("<div class=dib><span class='iheaders idib'><strong>Qty2</strong></span><input type=text id=eqty$lt1 class='smallinp form-control idib' value='".$selquantity2."'></div>");
								} else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Qty2</strong></span><input type=text id=eqty$lt1 class='smallinp form-control idib' value=''></div>");
                                }
                                if(isset($seleunit)) {
                                    print('<div class=dib><span class="iheaders idib"><strong>Unit2</strong></span><input type=text id=eunit'.$lt1.' style="width:110px;" value="'.$seleunit.'" class="unit form-control idib">');
								} else {
                                    print("<div class=dib><span class='iheaders idib'><strong>Unit2</strong></span><input type=text id=eunit$lt1 style='width:110px;' value='' class='unit form-control idib'>");
                                }
							}
							echo '</div>';
				
							if ($lt1 == 0) {
								print("<div class=dib>");
							} else {
								print("<div class=dib>");
							}
                            print("<span class='iheaders idib'><strong>Ingredient</strong></span><input type=text class='ing form-control idib' id=ing$lt1 style='width:210px;' ");
                            if(isset($seling)) {
							    print('value="'.$seling.'">');
                            } else{
                                print("value=''>");
                            }
							echo '</div>';
							if ($lt1 == 0) {
								print("<div class=dib>");
							} else {
								print("<div class=dib>");
							}
                            print("<span class='iheaders idib'><strong>Preprep</strong></span><input type=text class='pp form-control idib' id=pp1$lt1 style='width:180px;' ");
                            if(isset($selpp)) {
							    print('value="'.$selpp.'">');
                            } else {
                                print("value=''>");
                            }
							echo '</div>';
							if ($lt1 == 0) {
								print("<div class=dib>");
							} else {
								print("<div class=dib>");
							}
                            print("<span class='iheaders idib'><strong>Preprep</strong></span><input type=text class='pp form-control idib' id=pp2$lt1 style='width:180px;' ");
                            if(isset($selpp2)) {
							    print('value="'.$selpp2.'">');
                            } else {
                                print("value=''>");
                            }
							echo '</div>';
							/*$downarrow=$ingsel-1;
							if ($lt1<$downarrow) {
								if ($lt1==0) {
									echo '<div class=dib><br class=nophone><img id=movedown'.$lt1.' src="images/red_dwn.png" border=0 alt="Move Down One Row" title="Move Down One Row"></div>';
								} else {
									echo '<div class=dib><img id=movedown'.$lt1.' src="images/red_dwn.png" border=0 alt="Move Down One Row" title="Move Down One Row"></div>';
								}
							} else {
								echo '<div class=dib><div id=downdiv'.$lt1.'></div></div>';
							}
							if ($lt1>0 && $lt1 != $downarrow) {
								echo '<div class=dib><img id=moveup'.$lt1.' src="images/red_up.png" border=0 alt="Move Up One Row" title="Move Up One Row"></div>';
							} else if ($lt1==$downarrow) {
								echo '<div class=dib><img class=lastup id=moveup'.$lt1.' src="images/red_up.png" border=0 alt="Move Up One Row" title="Move Up One Row"></div>';
							} else {
								echo '<div class=dib><div id=updiv'.$lt1.'></div></div>';
							} */
							echo '<span class="barrow dib ui-icon ui-icon-arrowthick-2-n-s"></span></li>';
						}
                        
						for ($lt1 = $ingsel; $lt1 < 45; $lt1++) {
							print("<div id=ingdiv$lt1 style='display:none;'></div>");
						}
                        echo '</ul>';
						if ($ingsel<45) {
							print("<div id=adddiv><a href='#' id=adding class='$ingsel btn'>Add Ingredient</a></div>");
						}
					
						echo '<br><strong>Fahrenheit Celsius Converter</strong>
							<br>Enter a number in either field, then click Convert
							<strong>Fahrenheit </strong><INPUT class="dib smallinp form-control" type="text" id=f>
							<strong>Celcius </strong><INPUT class="dib smallinp form-control" type="text" id=c>
                            <input type=button id=convert value=Convert class=btn onclick="convertTemp()">
							<br><br><p>Here are the characters for degrees celsius and fahrenheit if you need them &deg;C &deg;F - Copy and paste them into your directions as required.</p>
						';
				
						if (isset($_POST['directions'])) {
							$pdirections = $_POST['directions'];
							$pdirections=stripslashes($pdirections);
					
							if  (isset($headers)) {
								foreach ($headers as $hvalue) {
								    $pdirections=preg_replace('/Additional directions:/',$hvalue,$pdirections,1);
								}
							}
                            $pdirections = str_replace("<br />", "", $pdirections);

						}
		
						if (isset($_POST['note'])) {
							$pnote = $_POST['note'];
							$pnote=stripslashes($pnote);
                            if  (isset($headers)) {
							    foreach ($headers as $hvalue) {
								$pnote=preg_replace('/Additional note:/',$hvalue,$pnote,1);
							    }
							}
                            $pnote = str_replace("<br />", "", $pnote);
						}
					?>
					<strong>Directions</strong>
					<br><TEXTAREA  class="form-control" id='directions' name='directions'  rows="5" cols="100""><?php if (isset($pdirections)) {echo $pdirections;}?> </TEXTAREA>
					<br>
					<br>
					<strong>Notes</strong>
					<br><TEXTAREA class="form-control" id=note  rows="5" cols="100"' name='note'><?php if (isset($pnote)) {echo $pnote;}?></TEXTAREA><br><br>
					
					<div>
						<div class=dib>
							<strong>Preparation Time</strong>
						</div>
						<div class=dib>
							<input class="form-control" type=text id=preptime name='preptime' value='<?php if (isset($_POST['preptime'])) {print($_POST['preptime']);}?>'>
			
						</div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Cooking Time</strong>
						</div>
						<div class=dib>
							<input class="form-control" type=text id=cooktime name='cooktime' value='<?php if (isset($_POST['cooktime'])) {print($_POST['cooktime']);}?>'>
			
						</div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Makes </strong>
						</div>
						<div class=dib>
							<input class="form-control smallinp" type=text id=yield name='yield' <?PHP if(isset($_POST['yield'])) {print("value='".$_POST['yield']."'");} ?>>
						</div>
                        <div class=dib>
                            <?PHP
                                if (isset($_POST['yield_unit'])) {
                                    $selyield_unit=$_POST['yield_unit'];
                                    $selyield_unit=stripslashes($selyield_unit);
                                }
                                if (isset($selyield_unit)) {
                                    print("<input class=form-control name='yield_unit' id='yield_unit' style='max-width:300px; min-width:100px;' value='$selyield_unit'>");
                                } else {
                                   print("<input class=form-control name='yield_unit' id='yield_unit' style='max-width:300px; min-width:100px;'>");
                                }
                            ?>
                        </div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Source</strong>
						</div>
						<div class=dib>
							<?php
								if (isset($_POST['source'])) {
                                    $selsource=$_POST['source'];
                                    $selsource=stripslashes($selsource);
                                }
                                if (isset($selsource)) {
                                    print("<input class=form-control name='source' id='source' style='max-width:300px; min-width:100px;' value='$selsource'>");
                                } else {
								   print("<input class=form-control name='source' id='source' style='max-width:300px; min-width:100px;'>");
                                }
							?>
						</div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Rating</strong>
						</div>
						<div class=dib>
						<?PHP
                            print("<select class=form-control style='width:100px;' name=rating id=rating>");
                            
							if (isset($_POST['rating']) && $_POST['rating']!="") {
								$selrating=$_POST['rating'];
							} else {
                                echo "<option selected></option>";
                            }
							for ($lt = 0; $lt < 6; $lt++) {
                                if($lt==1) {
                                    $rt="$lt Star";
                                } elseif ($lt==0){
                                    $rt="No Rating";
                                } else{
                                    $rt="$lt Stars";
                                }
								$rtid = $lt;
								if (isset($selrating) && $rtid==$selrating) {
									print("<option selected value=$rtid>$rt</option>"); 
								} else {
									print("<option value=$rtid>$rt</option>");
								}
							}
							echo '</select>';
						?>
						</div>
					</div>
					<br>
                    <input type=checkbox class='chk css-checkbox' id=tried name=tried <?php if(isset($_POST['tried']) && $_POST['tried']=='Yes') {print(" CHECKED");} ?>>
                    <label for=tried class=css-label><strong> Tried</strong></label>
					<br><br>
					<div>
						<div class=dib>
							<strong>Cuisine</strong>
						</div>
						<div class=dib>
							<?PHP
								if (isset($_POST['cuisine'])) {
                                    $selcuisine=$_POST['cuisine'];
                                    $selcuisine=stripslashes($selcuisine);
                                }
                                if (isset($selcuisine)) {
                                    print("<input class=form-control name='cuisine' id='cuisine' style='max-width:300px; min-width:100px;' value='$selcuisine'>");
                                } else {
                                   print("<input class=form-control name='cuisine' id='cuisine' style='max-width:300px; min-width:100px;'>");
                                }
							?>
						</div>
					</div>
					<br>
					<div>
						<div class=dib>
							<strong>Added By</strong>
						</div>
						<div class=dib>
							<input class="form-control" type=text id=addedby name='addedby' value='<?php if (isset($_POST['addedby']) && $_POST['addedby']!='') {print($_POST['addedby']);} else {print($user);}?>'>
			
						</div>
					</div>
					
					<br>
					
					<div>
						<div class=dib>
                            <strong>Diets</strong>
                        </div>
                        <div id=dietdiv class=dib>
                            <?PHP
                                if (isset($_POST['diet'])) {
                                    foreach( $_POST['diet'] as $key=>$relrec ) {
                                        $relrec=stripslashes($relrec);
                                        if ($key==0) {
                                           $seldiet=$relrec; 
                                        } else {
                                           $seldiet.=", $relrec"; 
                                        }
                                    }
                                }
                                if (isset($seldiet)) {
                                    print("<input class=form-control name='diet' id='diet' value='$seldiet'>");
                                } else {
                                   print("<input class=form-control name='diet' id='diet'>");
                                }
                            ?>
                        </div>
					</div>
                    <br>
					<div>
						<div class=dib>
                            <strong>Related Recipes</strong>
                        </div>
                        <div id=rrdiv class=dib>
                            <?PHP
                                if (isset($_POST['related_recipe'])) {
                                    foreach( $_POST['related_recipe'] as $key=>$relrec ) {
                                        $relrec=stripslashes($relrec);
                                        if ($key==0) {
                                           $selrelated_recipe=$relrec; 
                                        } else {
                                           $selrelated_recipe.=", $relrec"; 
                                        }
                                    }
                                }
                                if (isset($selrelated_recipe)) {
                                    print("<input class=form-control name='related_recipe' id='related_recipe' value='$selrelated_recipe'>");
                                } else {
                                   print("<input class=form-control name='related_recipe' id='related_recipe'>");
                                }
                            ?>
                        </div>
					</div>
					
					<br><br>
					
					<div>
						
							<strong>Images </strong>
						
						
							<?php
							if ((isset($_POST["newimage9"]) || isset($_POST["image9"])) and $_POST["image9"] != "") {
								echo '
									<div id="uploader" style="display:none;">
										<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
									</div>';
							} else {
								echo '
									<div id="uploader">
										<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
									</div>';
							}
					
							echo'<br><div>';
                            $ict=0;
							for ($lt=0;$lt<3;$lt++) {
								print("<div class=dib><div class=image id='imagedisp$lt'>");
								if(isset($_POST["newimage$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$user.'-'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input name=image'.$lt.' id=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									}
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
			
									}
								}
								if(isset($_POST["newimage$lt"])) {
									echo ' | <a id=delimage'.$lt.' href="#">Delete image</a><input id=newimage'.$lt.' name=newimage'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">';
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									print(' | <a id=delimage'.$lt.' href="#">Delete image</a>');
								}
								echo '</div></div>';
							}
							for ($lt=3;$lt<6;$lt++) {
								print("<div class=dib><div class=image id='imagedisp$lt'>");
								if(isset($_POST["newimage$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$user.'-'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input name=image'.$lt.' id=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									}
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
			
									}
								}
								if(isset($_POST["newimage$lt"])) {
									echo ' | <a id=delimage'.$lt.' href="#">Delete image</a><input id=newimage'.$lt.' name=newimage'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">';
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									print(' | <a id=delimage'.$lt.' href="#">Delete image</a>');
								}
								echo '</div></div>';
							}
							for ($lt=6;$lt<9;$lt++) {
								print("<div class=dib><div class=image id='imagedisp$lt'>");
								if(isset($_POST["newimage$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$user.'-'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input name=image'.$lt.' id=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									}
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
			
									}
								}
								if(isset($_POST["newimage$lt"])) {
									echo ' | <a id=delimage'.$lt.' href="#">Delete image</a><input id=newimage'.$lt.' name=newimage'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">';
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									print(' | <a id=delimage'.$lt.' href="#">Delete image</a>');
								}
								echo '</div></div>';
							}
							for ($lt=9;$lt<10;$lt++) {
								print("<div class=dib><div class=image id='imagedisp$lt'>");
								if(isset($_POST["newimage$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$user.'-'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["newimage$lt"].'"><br><a id=remimg href="#">Replace image</a><input name=image'.$lt.' id=image'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">');
									}
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									$ict++;
									if($id) {
										print('<img src="images/recipe/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
									} else {
										print('<img src="imagetmp/'.$_POST["image$lt"].'"><br><a id=remimg'.$lt.' href="#">Replace image</a><input id=image'.$lt.' name=image'.$lt.' type=hidden value="'.$_POST["image$lt"].'">');
			
									}
								}
								if(isset($_POST["newimage$lt"])) {
									echo ' | <a id=delimage'.$lt.' href="#">Delete image</a><input id=newimage'.$lt.' name=newimage'.$lt.' type=hidden value="'.$_POST["newimage$lt"].'">';
								} else if(isset($_POST["image$lt"]) and !empty($_POST["image$lt"])) {
									print(' | <a id=delimage'.$lt.' href="#">Delete image</a>');
								}
								echo '</div></div>';
							}
							
							echo '</div>';
		                    $ilft=10-$ict;
							print("<input id=imagenum name=imagenum type=hidden value=$ict>
                                   <input id=imagesleft name=imagesleft type=hidden value=$ilft> ");
							?>
					</div>
					<div>
						
						<strong>Video </strong>
                        <br>
						Uploading can take quite some time depending on the size of your video.Even though the progress bar may say it's at 100% the video is still uploading until the upload box disappears.
						<br>
						<?php
							if (isset($_POST['newvideo']) || (isset($_POST['video']) and $_POST['video'] != "")) {
								echo '
									<div id="uploadervideo" style="display:none;">
										<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
									</div>';
							} else {
								echo '
									<div id="uploadervideo">
										<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
									</div>';
							}
							echo "
							<br><div class=video id='videodisp'>";
							if(isset($_POST['newvideo'])) {
								echo $_POST['newvideo'].'<br><a class=remvideo href="#">Replace Video</a><input id=newvideo name=newvideo type=hidden value="'.$_POST['newvideo'].'">';
			
							} else if(isset($_POST['video']) and !empty($_POST['video'])) {
								print($_POST['video'].'<br><a class=remvideo href="#">Replace Video</a><input id=video name=video type=hidden value="'.$_POST['video'].'">');
							}
							if(isset($_POST['newvideo'])) {
								echo ' | <a class=delvideo href="#">Delete Video</a>';
							} else if(isset($_POST['video']) and !empty($_POST['video'])) {
								print(' | <a class=delvideo href="#">Delete Video</a>');
							}
				
							echo '
							</div>
							<br>';
						?>
						
					</div>
					<div>
						
						<strong>PDF </strong>
						
						<br>
						<?php
						if ((isset($_POST['newpdf']) || (isset($_POST['pdf'])) and $_POST['pdf'] != "")) {
							echo '
								<div id="uploaderpdf" style="display:none;">
									<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
								</div>';
						} else {
							echo '
								<div id="uploaderpdf">
									<p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p>
								</div>';
						}
						echo "
						<br><div class=pdf id='pdfdisp'>";
						if(isset($_POST['newpdf'])) {
							echo '<br><img src="images/recipe/'.$_POST['newpdf'].'"><br><a class=rempdf href="#">Replace PDF</a><input id=newpdf name=newpdf type=hidden value="'.$_POST['newpdf'].'">';
						} else if(isset($_POST['pdf']) and !empty($_POST['pdf'])) {
							print('<br><img src="images/recipe/'.$_POST['pdf'].'"><br><a class=rempdf href="#">Replace PDF</a><input id=pdf name=pdf type=hidden value="'.$_POST['pdf'].'">');
						}
						if(isset($_POST['newpdf'])) {
							echo ' | <a class=delpdf href="#">Delete PDF</a>';
						} else if(isset($_POST['pdf']) and !empty($_POST['pdf'])) {
							print(' | <a class=delpdf href="#">Delete PDF</a>');
						}
			
						echo '
						</div>
						<br>';
						?>
						
					</div>
					<br>
					<INPUT type=submit name=save value=Save class=btn>
					<br><br>
					<input type=HIDDEN id=id name=id value=<?php if(isset($_POST['cbut_val']) && $_POST['cbut_val']!='Copy') {echo $id;}?>>
					<input type=HIDDEN name=added id=added value=<?php if(isset($_POST['cbut_val']) && $_POST['cbut_val']!='Copy') {echo $added;} ?>>
					<input type=hidden name='rapp' id=rapp value=<?php if(isset($rapp)) {echo $rapp;}?>>
					<!--<input type=hidden name='rowner' id=rowner value=<?php if(isset($_POST['rowner'])) {echo $_POST['rowner'];}?>>-->
				</form>
				<script src="js/my.add.recipe.js"></script>
				<script src="js/my.disable.page.js"></script>
			</div>
			<?php
				require_once('includes/bottom.php');
			?>
                
                
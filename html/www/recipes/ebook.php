<?php
	session_set_cookie_params('0', '/');
	session_start();

	//*****any changes here must also be made in export & ebook
    require_once('includes/dbclient.php');
    require_once('includes/dbcalls.php');

	if(!isset($_SESSION[$client.'user'])) {
        //$page = curPageName();
        //header("Refresh:0 ; URL=index.php?timeout=yes&lastpage=".$page);
        header("Refresh:0 ; URL=index.php?timeout=yes");
        exit;
    }
    function curPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

	$user=$_SESSION[$client.'user'];
    $suser=$_SESSION[$client.'suser'];
    $uid=$_SESSION[$client.'uid'];
    $limit=$_SESSION[$client.'limit'];
    if(isset($_SESSION[$client.'rapp'])) {
         $rapp=$_SESSION[$client.'rapp'];
    }
    if(isset($_SESSION[$client.'datefmt'])) {
        $seldate = $_SESSION[$client.'datefmt'];
    }
    if(isset($_SESSION[$client.'admin'])) {
        $admin=$_SESSION[$client.'admin'];
    }
    if(isset($_SESSION[$client.'guest'])) {
        $guest=$_SESSION[$client.'guest'];
    }
    
    if($client=='wrm') {
        $oid=$_SESSION[$client.'oid'];
        $owner=$_SESSION[$client.'owner'];
        require_once('includes/dbvars.php');
    }

	$rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	if($user and $user!='') {
        if($client=='wrm') {
            $sql="$call query_owner_str(:user)";
            $crapp = $rdb->prepare($sql);
            $crapp->bindValue(':user', $user);
            $crapp->execute();
            $err=$rdb->errorInfo();
            $sendstr = $crapp->fetchColumn();
            $crapp->closeCursor();
            
            $sql="$call query_recipes_with_name_id_owner_visible(:oid)";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->bindValue(':oid', $oid);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number(:oid)";  //return all users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->bindValue(':oid', $oid);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users = $dbusers->rowCount();
            $dbusers->closeCursor();
                                                     
        } else {
                        
            $sql="$call query_recipes_with_name_id_owner_visible()";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number()";  //return all approved users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users=$dbusers->rowCount();
            $dbusers->closeCursor();
            
            $sql = "$call query_unapp_user_number()";  //return all unapproved users from db
            $dbuausers = $rdb->prepare($sql);
            $dbuausers->execute();
            $err=$rdb->errorInfo();
            $uausers=$dbuausers->rowCount();
            $dbuausers->closeCursor();
        }
        
        
        
        $sql = "$call query_user_recipe_number(:uid)";  //return all recipes from db
        $dburecipe = $rdb->prepare($sql);
        $dburecipe->bindValue(':uid', $uid);
        $dburecipe->execute();
        $err=$rdb->errorInfo();
        $urecipes = $dburecipe->rowCount();
        $dburecipe->closeCursor();

        if($client=='wrm') {
            $sql="$call query_recipe_number(:oid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        } else {
            $sql="$call query_recipe_number()";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        }
        if (isset($admin) && isset($rapp)) {
            $appct=0;
            while($row = $dbrecipe->fetch(PDO::FETCH_BOTH)) {
              $apprec=$row[1];
              if ($apprec) $appct++;
            }
            $unapprec = $recipes-$appct;
        }
        $dbrecipe->closeCursor();
	}

	if (isset($_POST['create'])) {
        if (isset($_POST['title']) and $_POST['title']!="") {
			if (isset($_POST['paper']) and $_POST['paper']!="") {
				if(isset($_POST['related_recipe'])){
                       $toctfont=3/4*18;
                                   
					   ini_set('max_execution_time', 600);
                       require('includes/toc.php');

					   if(isset($_POST['toc'])) {$toc=$_POST['toc'];}
					   if(isset($_POST['catt'])) {$catt=$_POST['catt'];}
					   if(isset($_POST['pdf'])) {$ipdf=$_POST['pdf'];}
					   if(isset($_POST['paper'])) {$paper=$_POST['paper'];}

					   $pdf=new PDF('P','mm',$paper);
					   $pdf->SetLeftMargin(20);
					   $pdf->AddFont('tahoma','','tahoma.php');
					   $pdf->AddFont('tahoma bold','','tahoma bold.php');
					   $pdf->AddFont('mvboli','','mvboli.php');
					   $pdf->AddPage();
					   $pdf->SetFont('mvboli','',18);
					   $pdf->Cell(0,20,"eBook Generated by $clientname");
					   $pdf->Ln(100);
					   $pdf->SetFont('tahoma bold','',25);
					   $pdf->Cell(0,10,utf8_decode(stripslashes($_POST['title'])));
                       
                       $recipelist='';
					   while (list ($key, $val) = each ($_POST['related_recipe'])) {
						   $recipelist .= $val.', ';
					   }
					   $recipelist=substr($recipelist,0,strlen($recipelist)-2);
                       $sql="select get_category(cat) as category, get_subcategory(subcat) as subcategory, get_recipename(recipe) as name, recipe from recipe_cat_subcat where recipe in($recipelist) order by category, subcategory, name";
					   $dbselrecipe= $rdb->prepare($sql);
                       $dbselrecipe->execute();
                       $err=$rdb->errorInfo();
                       $numselrec = $dbselrecipe->rowCount();
                       $rsselrecipe = $dbselrecipe->fetchAll(PDO::FETCH_BOTH);
                       $dbselrecipe->closeCursor();

					   $ct=-1;
					   for ($lt = 0; $lt < $numselrec; $lt++) {
                           $fontsize = $_POST['font'];
                           if ($fontsize=='small') {
                              $font=3/4*10;
                              $lh=4;
                           } else if ($fontsize=='med') {
                              $font=3/4*12;
                              $lh=5;
                           } else if ($fontsize=='large') {
                              $font=3/4*14;
                              $lh=6;
                           } else {
                              $font=3/4*10;
                              $lh=4;
                           }
						   if (isset($toc) && isset($catt)) {
							   $catmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][0]);
							   $scatmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][1]);
							   $id = $rsselrecipe[$lt][3];
							   if ($lt==0) {
                                   $pdf->SetFont('tahoma bold','',$toctfont);
								   $pdf->AddPage();
								   $pdf->startPageNums();
								   $pdf->Cell(0,10,$catmenu);
								   $pdf->TOC_Entry($catmenu, 0);
								   if ($scatmenu) {
									   $pdf->Ln(20);
									   $pdf->SetFont('tahoma','',$font);
									   $pdf->Cell(0,10,'   '.$scatmenu);
									   $pdf->TOC_Entry($scatmenu, 1);
								   }
							   } else {
								   $pcatmenu= $rsselrecipe[$ct][0];
								   $pscatmenu= $rsselrecipe[$ct][1];
								   if ($catmenu!=$pcatmenu) {
									   $pdf->SetFont('tahoma bold','',$toctfont);
									   $pdf->AddPage();
									   $pdf->Cell(0,10,$catmenu);
									   $pdf->TOC_Entry($catmenu, 0);
									   if ($scatmenu) {
										   $pdf->Ln(20);
										   $pdf->SetFont('tahoma','',$font);
										   $pdf->Cell(0,10,'   '.$scatmenu);
										   $pdf->TOC_Entry($scatmenu, 1);
									   }
								   } else {
									   if ($scatmenu) {
										   if ($pscatmenu and $scatmenu!=$pscatmenu) {
											   $pdf->SetFont('tahoma bold','',$toctfont);
											   $pdf->AddPage();
											   $pdf->Cell(0,10,$catmenu);
											   $pdf->Ln(20);
											   $pdf->SetFont('tahoma','',$font);
											   $pdf->Cell(0,10,'   '.$scatmenu);
											   $pdf->TOC_Entry($scatmenu, 1);
										   }
									   }  else {
										   if ($pscatmenu) {
											   $pdf->SetFont('tahoma bold','',$toctfont);
											   $pdf->AddPage();
											   $pdf->Cell(0,10,$catmenu);
										   }
									   }
								   }
							   }
							   //start outputting recipes
							   $pdf->startPageNums();
							   require('includes/print.php');
							   $ct++;
						   } else if (isset($toc)) {
							   $catmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][0]);
							   $scatmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][1]);
							   $id = $rsselrecipe[$lt][3];
							   if ($lt==0) {
								   $pdf->TOC_Entry($catmenu, 0);
								   if ($scatmenu) {
									   $pdf->TOC_Entry($scatmenu, 1);
								   }
							   } else {
								   $pcatmenu= $rsselrecipe[$ct][0];
								   $pscatmenu= $rsselrecipe[$ct][1];
								   if ($catmenu!=$pcatmenu) {
									   $pdf->TOC_Entry($catmenu, 0);
									   if ($scatmenu) {
										   $pdf->TOC_Entry($scatmenu, 1);
									   }
								   } else {
									   if ($scatmenu) {
										   if ($pscatmenu and $scatmenu!=$pscatmenu) {
											   $pdf->TOC_Entry($scatmenu, 1);
										   }
									   }
								   }
							   }
							   //start outputting recipes
							   $pdf->startPageNums();
							   require('includes/print.php');
							   $ct++;
						   } else if (isset($catt)) {
							   $catmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][0]);
							   $scatmenu = iconv('UTF-8', 'windows-1252', $rsselrecipe[$lt][1]);
							   $id = $rsselrecipe[$lt][3];
							   if ($lt==0) {
								   $pdf->SetFont('tahoma bold','',$toctfont);
								   $pdf->AddPage();
								   $pdf->startPageNums();
								   $pdf->Cell(0,10,$catmenu);
								   //$pdf->TOC_Entry($catmenu, 0);
								   if ($scatmenu) {
									   $pdf->Ln(20);
									   $pdf->SetFont('tahoma','',$toctfont);
									   $pdf->Cell(0,10,'   -'.$scatmenu);
								   }
							   } else {
								   $pcatmenu= $rsselrecipe[$ct][0];
								   $pscatmenu= $rsselrecipe[$ct][1];
								   if ($catmenu!=$pcatmenu) {
									   $pdf->SetFont('tahoma bold','',$toctfont);
									   $pdf->AddPage();
									   $pdf->Cell(0,10,$catmenu);
									   if ($scatmenu) {
										   $pdf->Ln(20);
										   $pdf->SetFont('tahoma','',$toctfont);
										   $pdf->Cell(0,10,'   -'.$scatmenu);
									   }
								   } else {
									   if ($scatmenu) {
										   if ($pscatmenu and $scatmenu!=$pscatmenu) {
											   $pdf->SetFont('tahoma bold','',$toctfont);
											   $pdf->AddPage();
											   $pdf->Cell(0,10,$catmenu);
											   $pdf->Ln(20);
											   $pdf->SetFont('tahoma','',$toctfont);
											   $pdf->Cell(0,10,'   -'.$scatmenu);
										   }
									   }  else {
										   if ($pscatmenu) {
											   $pdf->SetFont('tahoma bold','',$toctfont);
											   $pdf->AddPage();
											   $pdf->Cell(0,10,$catmenu);
										   }
									   }
								   }
							   }
							   //start outputting recipes
							   require('includes/print.php');
							   $ct++;
						   }
					   }
					   if (!isset($toc) and !isset($catt)) {
						   $recarray=explode(',',$recipelist);
						   foreach ($recarray as $id) {
							   require('includes/print.php');
						   }
					}
					if (isset($toc)) {
						   $pdf->stopPageNums();
						   $pdf->insertTOC(2);
					}
					$pdf->Output('filename.pdf','D');
					$pdf->Close();
                    $msg='ok';
				} else {
					$msg="No Recipes Selected";
				}
			} else {
				   $msg='Please Select a Paper Size';
			}
		} else {
			$msg='Please Enter a Title';
		}
        $msg='eBook Created';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/slidebars.css" rel="stylesheet">
        <link href="css/slidebars-theme.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" media="screen">
	    <script src="js/jquery-1.11.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slidebars.min.js"></script>
        <script src="js/jquery_cookie.js"></script>
	    <script src="js/my.messi.js"></script>
	    <script src="js/my.dropdown.js"></script>
	    <script src="js/my.scrolling.msgbox.js"></script>
	    <script src="js/my.getfont.size.js"></script>
	    <script src="js/my.font.size.js"></script>
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
	    <title>Create Ebook</title>
	    <meta name="description" content="Create an Ebook containing some or all of your recipes.">
	    <script src="js/my.ebook.js"></script>
	    <script src="js/jquery.selectboxes.pack.js"></script> 
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
		if (isset($msg)) {
            if($msg=='eBook Created') {
                echo "<script type='text/javascript'>
                    $('.message_box').addClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                    $('.message_box').show();
                </script>";    
            } else {
			    echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                    $('.message_box').show();
                </script>";
            }
		}
		if (isset($_SESSION[$client.'toc'])) {
            $seltoc=$_SESSION[$client.'toc'];
        }
        if (isset($_SESSION[$client.'catt'])) {
		    $selcatt=$_SESSION[$client.'catt'];
        }
        if (isset($_SESSION[$client.'title'])) {
		    $seltitle=$_SESSION[$client.'title'];
        }
        if (isset($_SESSION[$client.'paper'])) {
		    $selpaper=$_SESSION[$client.'paper'];
        }
        if (isset($_SESSION[$client.'pdf'])) {
		    $selpdf=$_SESSION[$client.'pdf'];
        }
        
        if(isset($_GET['indv'])) {
		    $rid=$_COOKIE['rid'];
        }
        if ($client=='wrm' && isset($admin)) {
            $sql = "$call query_owner_recipes_with_name_id(:oid)";  //return all recipes from db
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
        } else if (isset($admin)) {
            $sql = "$call query_recipes_with_name_id()";
            $dbrecipe = $rdb->prepare($sql);
        } else {
            $sql = "$call query_user_recipes_with_name_id(:uid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':uid', $uid);
        }
        $dbrecipe->execute();
        $err=$rdb->errorInfo();
        $numr = $dbrecipe->rowCount();
        $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
        $dbrecipe->closeCursor();
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>create <strong>eBook</strong></h3>
				            <br>
				            <form action="" name=form1 enctype="multipart/form-data" method="POST">
					            <input type=submit class=btn name="create" value="Create" class=button><br>
					            <br>
					            <div>
						            <div class='dib ebstuff'>
							            <strong>eBook Title*</strong>
						            </div>
						            <div class=dib>
							            <input type=text class=form-control size=50 name='title' id=title
							            <?PHP
								            if(isset($_POST['title'])) {
									            print("value=\"".$_POST['title']."\"");
								            } else if (isset($seltitle)) {
									            print("value=\"$seltitle\"");
								            }
							            ?>
							            >
						            </div>
					            </div>
					            <br>
					            <div>
						            <div class='dib ebstuff'>
							            <strong>Paper Size*:</strong>
						            </div>
						            <div class=dib>
							            <?php
								            if (isset($_POST['paper'])) { //if item already selected trap value
									            $selpaper=$_POST['paper'];
								            }
								            $paperarray=array('A3','A4','A5','Legal','Letter');
								            echo '<select class=form-control id=paper name="paper">';
								            if (isset($selpaper)) {
									            foreach ($paperarray as $key=>$val) {
										            if ($selpaper==$key) {
											            print("<option SELECTED>$val</option>");
										            }
									            }
								            } else {
									            print("<option value=''></option>");
								            }
								            foreach ($paperarray as $key=>$val) {
									            if (!isset($selpaper) || $selpaper!=$key) {
										            print("<option>$val</option>");
									            }
								            }
								            echo '</select>';
							            ?>
						            </div>
					            </div>
					            <br>
                                <?php 
                                    echo "<input type=checkbox class='chk css-checkbox' id=toc name='toc' ";
                                        if (isset($_POST['toc']) && $_POST['toc']) {
                                            print(" CHECKED");
                                        } else if (isset($seltoc) && $seltoc) {
                                            print(" CHECKED");
                                        }
                                        
                                    echo"
                                        ><label for=toc class=css-label><strong> Table of Contents</strong></label>";
					            ?>
					            <br>
                                <?php 
                                    echo "<input type=checkbox class='chk css-checkbox' id=catt name='catt' ";
                                        if (isset($_POST['catt']) && $_POST['catt']) {
                                            print(" CHECKED");
                                        } else if (isset($selcatt) && $selcatt) {
                                            print(" CHECKED");
                                        }
                                        
                                    echo"
                                        ><label for=catt class=css-label><strong> Recipe Type & Category Title Pages</strong></label>";
                                ?>
					            <br>
                                <?php 
                                    echo "<input type=checkbox class='chk css-checkbox' id=pdf name='pdf' ";
                                        if (isset($_POST['pdf']) && $_POST['pdf']) {
                                            print(" CHECKED");
                                        } else if (isset($selpdf) && $selpdf) {
                                            print(" CHECKED");
                                        }
                                        
                                    echo"
                                        ><label for=pdf class=css-label><strong> Include PDF Images</strong></label>";
                                ?>
					            <br><br>
					            <div>
						            <div class=dib>
							            <strong class=rheader>Recipes</strong>
							            <br><br>
							            <select class='multselect form-control' id=erecipelist name=recipe[] size=<?php echo $recipes;?> multiple>
							            <?PHP
								            for ($lt = 0; $lt < $numr; $lt++) {
									            $recipeid = $rsrecipe[$lt][0];
									            $recipeval = stripslashes($rsrecipe[$lt][1]);
									            if (!isset($rid) || (isset($rid) && $rid != $recipeid)) {
											            print("<option VALUE=$recipeid>".$recipeval."</option>");
									            }
								            }
							            ?>
							            </select>
						            </div>
						            <div id=centre class=dib>
							            <div class=mdib><input id="add" type="button" class=btn value=">"></div>
							            <div class=mdib><input id="addAll" type="button" class=btn value=">>"></div>
							            <div class=mdib><input id="remove" type="button" class=btn value="<"></div>
							            <div class=mdib><input id="removeAll"type="button" class=btn value="<<"></div>
						            </div>
						            <div class=dib>
							            <strong class=rheader>Recipes To Include</strong>
							            <br><br>
							            <select class='multselect form-control' id=erelated_recipe name=related_recipe[] size=<?php echo $recipes;?> multiple>
								            <?php
									            for ($lt = 0; $lt < $numr; $lt++) {
										            $recipeid = $rsrecipe[$lt][0];
										            $recipeval = stripslashes($rsrecipe[$lt][1]);
										            if (isset($rid) && $rid == $recipeid) {
												            print("<option VALUE=$recipeid selected>".$recipeval."</option>");
										            }
									            }
								            ?>
							            </select>
						            </div>
					            </div>
					            <br><br>
					            <input type=submit class=btn name="create" value="Create" class=button>
					            <input type=hidden name=font id=font>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>   
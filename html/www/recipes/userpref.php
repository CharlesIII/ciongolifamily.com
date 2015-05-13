<?php
        require_once('includes/top.php');
?>
        <title>My Preferences</title>
        <meta name="description" content="Select your preferences for the way Web Recipe Manager behaves.">
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <script src="js/decode.min.js"></script>
        <script src="js/jquery_cookie.js"></script>
        <script src="js/my.userpref.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.css">
        <script src="js/my.combo.js"></script>
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
        if (isset($_SESSION[$client.'toc'])) {               
		    $seltoc=$_SESSION[$client.'toc'];
        }  else {
            $seltoc=FALSE;
        }
		if (isset($_SESSION[$client.'catt'])) {               
            $selcatt=$_SESSION[$client.'catt'];
        } else {
            $selcatt=FALSE;
        }
		if (isset($_SESSION[$client.'datefmt'])) {               
            $seldate=$_SESSION[$client.'datefmt'];
        }
		if (isset($_SESSION[$client.'dmeasure'])) {               
            $selms=$_SESSION[$client.'dmeasure'];
        }
		if (isset($_SESSION[$client.'title'])) {               
            $seltitle=$_SESSION[$client.'title'];
        }
		if (isset($_SESSION[$client.'paper'])) {               
            $selpaper=$_SESSION[$client.'paper'];
        }
		if (isset($_SESSION[$client.'pdf'])) {               
            $selpdf=$_SESSION[$client.'pdf'];
        }  else {
            $selpdf=FALSE;
        }
		if (isset($_SESSION[$client.'rapp'])) {               
            $selrapp=$_SESSION[$client.'rapp'];
        }  else {
            $selrapp=FALSE;
        }
        if (isset($_COOKIE['numfmt'])) {               
            $selnumfmt=$_COOKIE['numfmt'];
        }
        if (isset($_COOKIE['fracdec'])) {               
            $selfracdec=$_COOKIE['fracdec'];
        }
        if (isset($_COOKIE['region'])) {               
            $selregion=$_COOKIE['region'];
        }
        if (isset($_COOKIE['groroz'])) {               
            $selgroroz=$_COOKIE['groroz'];
        }
        if (isset($_COOKIE['popovers'])) {
            if ($_COOKIE['popovers']=='true') {              
                $selpopovers=TRUE;
            } else {
                $selpopovers=FALSE;
            }    
        } else {
            $selpopovers=FALSE;
        }
        
		$sql="$call query_user_welcome_pref(:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();

        $rsw = $rs->fetch(PDO::FETCH_BOTH);
        $rs->closeCursor();
        
		$selwelcome=$rsw[0];
        
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>my <strong>preferences</strong></h3>
				            <form id="support_form" enctype="multipart/form-data">
					            <br>
					            <input class="btn" type="submit" value="Save" name="submit">
					            <br>
                                <br>
                                <strong class=rheader>General</strong>
                                <br><br>
					            <?php
						            if (isset($admin)) {
							            echo "<input type=checkbox class='chk css-checkbox' id=rapp name='rapp'";
                                        if ($selrapp) {
                                             print(" CHECKED");
                                        }
                                        
                                        echo"
                                        ><label for=rapp class=css-label> Recipe Approval Required</label><br><br>";   
						            }                           
                                    echo "<input type=checkbox class='chk css-checkbox' id=popovers name='popovers'";
                                    if ($selpopovers) {
                                         print(" CHECKED");
                                    }
                                    
                                    echo"
                                    ><label for=popovers class=css-label> Show Hints & Tips Popovers</label>";
                                    ?>
					            <br>
                                <br>
					            <strong class=rheader>Login</strong>
					            <br><br>
                                <?php
					                echo "<input type=checkbox class='chk css-checkbox' id=welcome name='welcome'";
                                    if ($selwelcome) {
                                         print(" CHECKED");
                                    }
                                    echo"><label for=welcome class=css-label> Show Welcome Screen</label><br>";
                                ?>
					            <br><br>
					            <strong class=rheader>Recipe</strong>
					            <br><br>
					            <div class=multiopt>
						            <div class='label dib'>
							            Default Measurement System For New Recipes 
						            </div>
						            <div class=dib>
							            <?php
								            $sql = "$call query_measures()";
                                            $dbms = $rdb->prepare($sql);
                                            $dbms->execute();
                                            $err=$rdb->errorInfo();

                                            $numm = $dbms->rowCount();
                                            $rsms = $dbms->fetchAll(PDO::FETCH_BOTH);
                                            $dbms->closeCursor();
								            
								            print("<select class=form-control id=measure name=measure>");
								            
								            if (isset($selms)) {
									            for ($lt = 0; $lt < $numm; $lt++) {
										            if ($selms==$rsms[$lt][1]) {
											            $selid=$rsms[$lt][0];
											            print("<option SELECTED value=$selid>$selms</option>");
										            }
									            }
								            } else {
									            print("<option value=''></option>");
								            }
								            for ($lt = 0; $lt < $numm; $lt++) {
									            $msid = $rsms[$lt][0];
									            $ms = $rsms[$lt][1];
									            if (!isset($selms) || (isset($selms) && $selms!=$ms)) {
										            print("<option value=$msid>$ms</option>");
									            }
								            }
								            echo '</select>';
							            ?>
						            </div>
					            </div>
					            <div class=multiopt>
						            <div class='label dib'>
							            Date Format 
						            </div>
						            <div class=dib>
							            <?php
								            $dtarray=array('dd/mm/yy','mm/dd/yy');              
								            echo '<select class="form-control" id=date name="date">';
								            if (isset($seldate)) {
									            foreach ($dtarray as $key=>$val) {
										            if ($seldate==$key) {
											            print("<option SELECTED value=$key>$val</option>");
										            }
									            }
								            } else {
									            print("<option value=''></option>");
								            }
								            foreach ($dtarray as $key=>$val) {
									            if (!isset($seldate) || $seldate!=$key) {
										            print("<option value=$key>$val</option>");
									            }
								            }
								            echo '</select>';
							            ?>
						            </div>
					            </div>
                                <br><br>
                                <strong class=rheader>Resizing & Conversion of Recipes</strong><br>
                                All are required if you wish to convert/resize recipes
                                <br><br>
                                <div class=multiopt>
                                    <div class='label dib'>
                                        Number Format
                                    </div>
                                    <div class=dib>
                                        <?php
                                       $nfarray=array('1,000,000.00','1 000 000,000','1 000.000,000','1.000.000,000');              
                                       echo '<select class="form-control formselect" id=numfmt name="numfmt">';
                                       if (isset($selnumfmt) && $selnumfmt!= 'notset') {
                                           foreach ($nfarray as $key=>$val) {
                                               if ($selnumfmt==$val) {
                                                   print("<option SELECTED value=$key>$val</option>");
                                               }
                                           }
                                       } else {
                                           print("<option value=''></option>");
                                       }
                                       foreach ($nfarray as $key=>$val) {
                                           if (!isset($selnumfmt) || $selnumfmt!=$val) {
                                               print("<option value=$key>$val</option>");
                                           }
                                       }
                                       echo '</select>';
                                        ?>
                                    </div>
                                </div>
					            <div class=multiopt>
                                    <div class='label dib'>
                                        Decimals or Fractions 
                                    </div>
                                    <div class=dib>
                                        <?php
                                            $fdarray=array('Fractions(1/2)','Decimals(0.5)');              
                                            echo '<select class="form-control formselect" id=fracdec name="fracdec">';
                                            if (isset($selfracdec) && $selfracdec!= 'notset') {
                                                foreach ($fdarray as $key=>$val) {
                                                    if ($selfracdec==$val) {
                                                        print("<option SELECTED value=$key>$val</option>");
                                                    }
                                                }
                                            } else {
                                                print("<option value=''></option>");
                                            }
                                            foreach ($fdarray as $key=>$val) {
                                                if (!isset($selfracdec) || $selfracdec!=$val) {
                                                    print("<option value=$key>$val</option>");
                                                }
                                            }
                                            echo '</select>';
                                        ?>
                                    </div>
                                </div>
                                <div class=multiopt>
                                    <div class='label dib'>
                                        Convert recipes to this measurement system
                                    </div>
                                    <div class=dib>
                                        <?php
                                            $sql = "$call query_regions()";
                                            $dbrg = $rdb->prepare($sql);
                                            $dbrg->execute();
                                            $err=$rdb->errorInfo();

                                            $numr = $dbrg->rowCount();
                                            $rsrg = $dbrg->fetchAll(PDO::FETCH_BOTH);
                                            $dbrg->closeCursor();
                                            
                                            print("<select class=form-control id=region name=region style='width:auto; min-width:100px;'>");
                                            if (isset($selregion) && $selregion!= 'notset') {
                                                for ($lt = 0; $lt < $numr; $lt++) {
                                                    if ($selregion==$rsrg[$lt][1]) {
                                                        $selrid=$rsrg[$lt][0];
                                                        print("<option value=$selrid SELECTED>$selregion</option>");
                                                    }
                                                }
                                            } else {
                                                print("<option value=''></option>");
                                            }
                                            for ($lt = 0; $lt < $numr; $lt++) {
                                                $rgid = $rsrg[$lt][0];
                                                $rg = $rsrg[$lt][1];
                                                if (!isset($selregion) || (isset($selregion) && $selregion!=$rg)) {
                                                    print("<option value=$rgid>$rg</option>");
                                                }
                                            }
                                            echo '</select>';                                            
                                        ?>
                                    </div>
                                </div>
                                <div class=multiopt>
                                    <div class='label dib'>
                                       Imperial or Metric
                                    </div>
                                    <div class=dib>
                                        <?php
                                           $goarray=array('Metric (g,kg,ml,etc)','Imperial (oz,lb,etc)');              
                                            echo '<select class="form-control formselect" id=groroz name="groroz">';
                                            if (isset($selgroroz) && $selgroroz!= 'notset') {
                                                foreach ($goarray as $key=>$val) {
                                                    if ($selgroroz==$val) {
                                                        print("<option SELECTED value=$key>$val</option>");
                                                    }
                                                }
                                            } else {
                                                print("<option value=''></option>");
                                            }
                                            foreach ($goarray as $key=>$val) {
                                                if (!isset($selgroroz) || $selgroroz!=$val) {
                                                    print("<option value=$key>$val</option>");
                                                }
                                            }
                                            echo '</select>';
                                        ?>
                                    </div>
                                </div>
					            <br><br>
					            <strong class=rheader>eBook</strong>
					            <br><br>
					            <div class=multiopt>
						            <div class='label dib'>
							            eBook Title
						            </div>
						            <div class=dib>
							            <input class=form-control type=text name='title' id=title
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
					            <div class=multiopt>
						            <div class='label dib'>
                                        Paper Size
                                    </div>
						            <div class=dib>
							            <?php
								            $paperarray=array('A3','A4','A5','Legal','Letter');
								            echo '<select class="formselect form-control" id=paper name="paper">';
								            if (isset($selpaper)) {
									            foreach ($paperarray as $key=>$val) {
										            if ($selpaper==$key) {
											            print("<option SELECTED value=$key>$val</option>");
										            }
									            }
								            } else {
									            print("<option value=''></option>");
								            }
								            foreach ($paperarray as $key=>$val) {
									            if (!isset($selpaper) || $selpaper!=$key) {
										            print("<option value=$key>$val</option>");
									            }
								            }
								            echo '</select>';
							            ?>
						            </div>
					            </div>
					            <div class=multiopt>
						            <?php
                                        echo "<input type=checkbox class='chk css-checkbox' id=toc name='toc'";
                                        if ($seltoc) {
                                             print(" CHECKED");
                                        }
                                        echo"><label for=toc class=css-label> Include a Table of Contents</label><br>";
                                    ?>
					            </div>
					            <div class=multiopt>
						            <?php
                                        echo "<input type=checkbox class='chk css-checkbox' id=catt name='catt'";
                                        if ($selcatt) {
                                             print(" CHECKED");
                                        }
                                        echo"><label for=catt class=css-label> Include Recipe Type & Category Title Pages</label><br>";
                                    ?>
					            </div>
					            <div class=multiopt>
						            <?php
                                        echo "<input type=checkbox class='chk css-checkbox' id=pdf name='pdf'";
                                        if ($selpdf) {
                                             print(" CHECKED");
                                        }
                                        echo"><label for=pdf class=css-label> Include PDF images</label><br>";
                                    ?>
					            </div>
					            <input class="btn" type="submit" value="Save" name="submit">
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
			
			
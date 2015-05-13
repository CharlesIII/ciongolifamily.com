<?php
        require_once('includes/top.php');       
?>
        <title>Menu Planner</title>
        <meta name="description" content="Plan your meals for a week at a time and generate your weekly shopping list.">
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.ui.touch-punch.min.js"></script>
	<script src="js/my.menu.planner.js"></script>
	<script src="js/decode.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/my.combo.js"></script>
    <link href="css/printmenu.css" rel="stylesheet" type="text/css" media="print">
</head>
<body onload='loadmenu();'>
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
    ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>meal<strong> planner</strong></h3>
				            <form name='form1' method=post id=addmenu>
					            <div class=noprint>
						            <div class=dib>
							            <strong>Meal Plans:</strong>
						            </div>
						            <div class=dib>
							            <?php
								            $sql = "$call query_owner_menus(:uid)";  //return all menus from db
                                            $dbmenus = $rdb->prepare($sql);
                                            $dbmenus->bindValue(':uid', $uid);
                                            $dbmenus->execute();
                                            $err=$rdb->errorInfo();

                                            $mrows = $dbmenus->rowCount();
                                            $rsmenus = $dbmenus->fetchAll(PDO::FETCH_BOTH);
                                            $dbmenus->closeCursor();
                                            
								            if (isset($_POST['menu'])) {
									            $selid=$_POST['menu'];
								            }
								            print("<select class=form-control id=menu name=menu style='width:auto; min-width:200px;'>");
								            if (!isset($selid)) {
									            print("<option></option>");
								            }
								            for ($lt = 0; $lt < $mrows; $lt++) {
									            $id = $rsmenus[$lt][0];
									            $menu = $rsmenus[$lt][1];
									            if ((isset($selid) && $selid!=$id) || !isset($selid)) {
										            print("<option value=$id>$menu</option>");
									            } else {
										            print("<option selected value=$id>$menu</option>");
									            } 
								            }
                                            echo "</select>"
							            ?>
						            </div>
					            </div>
					            <br class=noprint>
					            <div class=noprint>
						            
						            <div class=dib>
							            <INPUT type=submit name=save value=Save class="btn save mloaded" style='display:none;'>
						            </div>
						            <div class=dib>
							            <INPUT type=submit class='btn delete mloaded' name=delete value='Delete' style='display:none;'>
						            </div>
						            <div class=dib>
							            <INPUT type=submit name=clear value=Clear class="btn clear mloaded" style='display:none;'>
						            </div>
						            <div class=dib>
							            <INPUT type=submit value='Create Shopping List' class='btn mloaded' onClick=this.form.action='shopping-list.php' style='display:none;'>
						            </div>
						            <div class=dib>
							            <INPUT type=button id=print name=print value=Print class='btn mloaded' onclick="window.print();" style='display:none;'>
						            </div>
						            
					            </div>
					            <br class=noprint>
                                <div id=mpt>
                                    <table id=drop>
						                <tr>
							                <th class=navbar-default>Mon - Breakfast</th>
                                            <th class=navbar-default>Tue - Breakfast</th>
                                            <th class=navbar-default>Wed - Breakfast</th>
                                            <th class=navbar-default>Thu - Breakfast</th>
                                            <th class=navbar-default>Fri - Breakfast</th>
                                            <th class=navbar-default>Sat - Breakfast</th>
                                            <th class=navbar-default>Sun - Breakfast</th>
                                        </tr>
                                        <tr>
							                <td id=droppablemonb></td>
                                            <td id=droppabletueb></td>
                                            <td id=droppablewedb></td>
                                            <td id=droppablethub></td>
                                            <td id=droppablefrib></td>
                                            <td id=droppablesatb></td>
                                            <td id=droppablesunb></td>
                                        </tr>
                                        <tr>
							                <th  class=navbar-default>Mon - Lunch</th>
                                            <th  class=navbar-default>Tue - Lunch</th>
                                            <th  class=navbar-default>Wed - Lunch</th>
                                            <th  class=navbar-default>Thu - Lunch</th>
                                            <th  class=navbar-default>Fri - Lunch</th>
                                            <th  class=navbar-default>Sat - Lunch</th>
                                            <th  class=navbar-default>Sun - Lunch</th>
                                        </tr>
                                        <tr>
							                <td id=droppablemonl></td>
                                            <td id=droppabletuel></td>
                                            <td id=droppablewedl></td>
                                            <td id=droppablethul></td>
                                            <td id=droppablefril></td>
                                            <td id=droppablesatl></td>
                                            <td id=droppablesunl></td>
                                        </tr>
                                        <tr>
							                <th class=navbar-default>Mon - Dinner</th>
                                            <th class=navbar-default>Tue - Dinner</th>
                                            <th class=navbar-default>Wed - Dinner</th>
                                            <th class=navbar-default>Thu - Dinner</th>
                                            <th class=navbar-default>Fri - Dinner</th>
                                            <th class=navbar-default>Sat - Dinner</th>
                                            <th class=navbar-default>Sun - Dinner</th>
                                        </tr>
                                        <tr>
							                <td id=droppablemond></td>
                                            <td id=droppabletued></td>
                                            <td id=droppablewedd></td>
                                            <td id=droppablethud></td>
                                            <td id=droppablefrid></td>
                                            <td id=droppablesatd></td>
                                            <td id=droppablesund></td>
                                        </tr>
                                        <tr>
							                <th  class=navbar-default>Mon - Snacks</th>
                                            <th  class=navbar-default>Tue - Snacks</th>
                                            <th  class=navbar-default>Wed - Snacks</th>
                                            <th  class=navbar-default>Thu - Snacks</th>
                                            <th  class=navbar-default>Fri - Snacks</th>
                                            <th  class=navbar-default>Sat - Snacks</th>
                                            <th  class=navbar-default>Sun - Snacks</th>
                                        </tr>
                                        <tr>
							                <td id=droppablemons></td>
                                            <td id=droppabletues></td>
                                            <td id=droppableweds></td>
                                            <td id=droppablethus></td>
                                            <td id=droppablefris></td>
                                            <td id=droppablesats></td>
                                            <td id=droppablesuns></td>
						                </tr>
                                    </table>
                                </div>
                                <br class=noprint>
                                <div class=cb>
                                    
                                    <div class=dib>
                                        <INPUT type=submit name=save value=Save class="btn save mloaded" style='display:none;'>
                                    </div>
                                    <div class=dib>
                                        <INPUT type=submit class='btn delete mloaded' name=delete value='Delete' style='display:none;'>
                                    </div>
                                    <div class=dib>
                                        <INPUT type=submit name=clear value=Clear class="btn clear mloaded" style='display:none;'>
                                    </div>
                                    <div class=dib>
                                        <INPUT type=submit value='Create Shopping List' class='btn mloaded' onClick=this.form.action='shopping-list.php' style='display:none;'>
                                    </div>
                                    <div class=dib>
                                        <INPUT type=button id=print name=print value=Print class='btn mloaded' onclick="window.print();" style='display:none;'>
                                    </div>
                                    
                                </div>
			            </FORM>
			            </div>
                        
			            <?php
				            require_once('includes/bottom.php');
			            ?>     
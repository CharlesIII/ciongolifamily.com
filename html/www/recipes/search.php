<?php
        require_once('includes/top.php');
?>
        <title>Search recipes</title>
        <meta name="description" content="Search for recipes by keyword, rating, ingredients on hand, diet, cuisine or from a list of your recipes.">
        <script src="js/my.search.js"></script>
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
        if($client=='wrm') {
		    $sql="$call query_owner_recipes_with_name_id(:oid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
        } else {
            $sql="$call query_recipes_with_name_id()";
            $dbrecipe = $rdb->prepare($sql);
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
				            <h3>recipe <strong>search</strong></h3>
				            <form action="" name=form1 enctype="multipart/form-data" method="POST" id=search>
					            <br><input type=submit class=btn name="search" value="Search" class=button><br><br>
					            <div class=group>
						            <div class=dib>
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Keyword/s In Recipe Name:</strong>
								            </div>
								            <div>
									            <input class='kwd form-control' type="text" name="keyword" value="<?php if(isset($_POST['keyword'])) {echo $_POST['keyword'];} ?>">
								            </div>
							            </div>
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Recipe List:</strong>
								            </div>
								            <div>
									            <select class='form-control' id=search1 name=recipe[] size=32 multiple>
										            <?PHP
                                                    if(isset($_POST['recipe'])) {
										                $selrows = count($_POST['recipe']);
                                                    }
										            for ($lt = 0; $lt < $numr; $lt++) {
											            $recipeid = $rsrecipe[$lt][0];
											            $recipeval = $rsrecipe[$lt][1];
											            if (isset($_POST['recipe'])) {
												            $match = '';
                                                            if(isset($selrows)) {
												                for ($r=0; $r < $selrows; $r++) {
													                $selval = $_POST['recipe'][$r];
													                if ($selval == $recipeid) {
														                $match = 'yes';
														                print("<OPTION SELECTED VALUE='$recipeid'>$recipeval</option>");
													                }
												                
                                                                }
                                                            }
												            if (empty($match)) {
														            print("<option VALUE='$recipeid'>$recipeval</option>");
												            }
											            } else {
												            print("<option VALUE='$recipeid'>$recipeval</option>");
											            }
										            }
										            ?>
									            </select>
								            </div>
							            </div>
						            </div>
						            <div class=dib>						
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Rating:</strong>
								            </div>
								            <div>
									            <select id=rating class='wide form-control' name="rating"><option></option>
									            <?php
										            if (isset($_POST['rating']) && is_numeric($_POST['rating'])) {$selrating=$_POST['rating'];} //if item already selected trap value}
										            $ratings = array('unrated','rated','2 stars or more', '3 stars or more', '4 stars or more', '5 stars');
										            foreach ($ratings as $i => $value) {
											            $rt = $value;
											            if (isset($selrating) && $i==$selrating) {
												            print("<option value=$i SELECTED>$rt</option>");
											            } else {
												            print("<option value=$i>$rt</option>");
											            }
										            }
										            echo '</select>';
									            ?>
		            
								            </div>
							            </div>						
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Cuisine:</strong>
								            </div>
								            <div>
									            <select id=cuisine class='wide form-control' name="cuisine"><option></option>
									            <?php
										            if (isset($_POST['cuisine'])) {$selcuisine=$_POST['cuisine'];} //if item already selected trap value}
										            if($client=='wrm') {
                                                        $sql="$call query_owner_cuisines(:oid)";
                                                        $dbcuisine = $rdb->prepare($sql);
                                                        $dbcuisine->bindValue(':oid', $oid);
                                                    } else {
                                                        $sql="$call query_cuisines()";
                                                        $dbcuisine = $rdb->prepare($sql);
                                                    }
                                                    $dbcuisine->execute();
                                                    $err=$rdb->errorInfo();

                                                    $numc = $dbcuisine->rowCount();
                                                    $rscuisine = $dbcuisine->fetchAll(PDO::FETCH_BOTH);
                                                    $dbcuisine->closeCursor();
                                                    
										            for ($lt = 0; $lt < $numc; $lt++) {
											            $cuisine = $rscuisine[$lt][0];
											            $cuisineid = $rscuisine[$lt][1];
											            if (isset($selcuisine) && $cuisineid==$selcuisine) {
												            print("<option SELECTED value=$cuisineid>$cuisine</option>");
											            } else {
												            print("<option value=$cuisineid>$cuisine</option>");
											            }
										            }
										            echo '</select>';
									            ?>
									            </select>
								            </div>
							            </div>						
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Diet:</strong>
								            </div>
								            <div>
									            <select id=diet class='wide form-control' name="diet"><option></option>
									            <?php
										            if (isset($_POST['diet'])) {$seldiet=$_POST['diet'];} //if item already selected trap value}
										            if($client=='wrm') {
                                                        $sql="$call query_owner_diets(:oid)";
                                                        $dbdiet = $rdb->prepare($sql);
                                                        $dbdiet->bindValue(':oid', $oid);
                                                    } else {
                                                        $sql="$call query_diets()";
                                                        $dbdiet = $rdb->prepare($sql);
                                                    }				
										            $dbdiet->execute();
                                                    $err=$rdb->errorInfo();

                                                    $numd = $dbdiet->rowCount();
                                                    $rsdiet = $dbdiet->fetchAll(PDO::FETCH_BOTH);
                                                    $dbdiet->closeCursor();
                                                    
										            for ($lt = 0; $lt < $numd; $lt++) {
											            $diet = $rsdiet[$lt][0];
											            $dietid = $rsdiet[$lt][1];
											            if (isset($seldiet) && $dietid==$seldiet) {
												            print("<option SELECTED value=$dietid>$diet</option>");
											            } else {
												            print("<option value=$dietid>$diet</option>");
											            }
										            }
										            echo '</select>';
									            ?>
								            </div>
							            </div>
                                        <div>
                                            <div class=navbar-default>
                                                <strong class=white>Source:</strong>
                                            </div>
                                            <div>
                                                <select id=source class='wide form-control' name="source"><option></option>
                                                <?php
                                                    if (isset($_POST['source'])) {$selsource=$_POST['source'];} //if item already selected trap value}
                                                    if($client=='wrm') {
                                                        $sql="$call query_owner_sources(:oid)";
                                                        $dbsource = $rdb->prepare($sql);
                                                        $dbsource->bindValue(':oid', $oid);
                                                    } else {
                                                        $sql="$call query_sources()";
                                                        $dbsource = $rdb->prepare($sql);
                                                    }
                                                    $dbsource->execute();
                                                    $err=$rdb->errorInfo();

                                                    $numc = $dbsource->rowCount();
                                                    $rssource = $dbsource->fetchAll(PDO::FETCH_BOTH);
                                                    $dbsource->closeCursor();
                                                    
                                                    for ($lt = 0; $lt < $numc; $lt++) {
                                                        $source = $rssource[$lt][0];
                                                        $sourceid = $rssource[$lt][1];
                                                        if (isset($selsource) && $sourceid==$selsource) {
                                                            print("<option SELECTED value=$sourceid>$source</option>");
                                                        } else {
                                                            print("<option value=$sourceid>$source</option>");
                                                        }
                                                    }
                                                    echo '</select>';
                                                ?>
                                                </select>
                                            </div>
                                        </div>
							            <div>
								            <div class=navbar-default>
									            <strong class=white>Ingredients At Hand:</strong>
								            </div>
								            <div>
									            <TEXTAREA class='form-control' id=search2 id=ing name=ingredient><?php if(isset($_POST['ingredient'])) {print($_POST['ingredient']);}?></TEXTAREA>
									            <br>
									            <span class=wide>of those ingredients how many are required?</span>
									            <br>
							            
									            <select class='wide form-control' name='reqnum'>
										            <?php
											            if (!isset($_POST['reqnum']) || $_POST['reqnum']=='All') {
												            echo '
												            <option SELECTED>All</option>
												            <option>Any</option>';
											            } else {
												            echo '
												            <option>All</option>
												            <option SELECTED>Any</option>';
											            }
										            ?>
									            </select>
								            </div>
							            </div>
						            </div>
					            </div>
					            <br>
					            <input type=submit class=btn name="search" value="Search" class=button>
                                <?php
                                    if(isset($oid)) {
                                        print("<input type=hidden id=ownerid name=ownerid value=$oid>");
                                    }
                                ?>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
			
			
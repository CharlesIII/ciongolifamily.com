<?php
        require_once('includes/top.php');
?>
        <title>Manage Ingredients</title>
        <meta name="description" content="Manage your recipe ingredients here">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/my.norm.js"></script>
	<script src="js/jquery.titlecase.js"></script>
	<script src="js/decode.min.js"></script>
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
		if (isset($_POST['save']) && $_POST['save']=='Apply Changes') {
            echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('Applying changes...');
                $('.message_box').show();
            </script>";
			$ingno = $_POST['ings'];
			for($i=0;$i<$ingno;$i++) {
				$id = $_POST["id$i"];
				$ing = $_POST["ing$i"];
                
                $sql = "$call query_chk_ing_used_elsewhere(:id, :uid)";
                $founde = $rdb->prepare($sql);
                $founde->bindValue(':id', $id);
                $founde->bindValue(':uid', $uid);
                $founde->execute();
                $err=$rdb->errorInfo();
                $erows = $founde->rowCount();
                $founde->closeCursor();
                
				if(isset($_POST["dbox$i"])) {
					$recnum=$_POST["recipes$i"];
					if ($recnum>0) {
						$notdel++;
					} else {
						//only delete ingredient if not used by someone else otherwise just remove from ing_owner table
						if ($erows>0) {
						    $sql="$call query_delete_owner_ing(:id, :uid)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->bindValue(':uid', $uid);
                            $rs->execute();
                            $err=$rdb->errorInfo();
                            $rs->closeCursor();
						} else {
							$sql="$call query_delete_ing(:id)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
                            $err=$rdb->errorInfo();
                            $rs->closeCursor();
						}
					}
				} else {
					//check if name has changed
					$sql = "$call query_ingredient_name(:id)";
                    $crs = $rdb->prepare($sql);
                    $crs->bindValue(':id', $id);
                    $crs->execute();
                    $err=$rdb->errorInfo();
                    $rs = $crs->fetch(PDO::FETCH_BOTH);
                    $crs->closeCursor();
                    if ($rs[0]!=$ing) {
                
						//it has so check if the new ing already exists
                        $sql = "$call query_ingredient_exists(:ing)";
                        $dbingid = $rdb->prepare($sql);
                        $dbingid->bindValue(':ing', $ing);
                        $dbingid->execute();
                        $err=$rdb->errorInfo();
                        $ingrows = $dbingid->rowCount();
                        $rsingid = $dbingid->fetch(PDO::FETCH_BOTH);
                        $dbingid->closeCursor();
						if ($ingrows==0) {
							//it doesn't so if no one else is using the old one we can update it otherwise we need to add a new one
							if ($erows==0) {
								$sql="$call query_upd_ing(:ing,:id)";
                                $rsupd = $rdb->prepare($sql);
                                $rsupd->bindValue(':ing', $ing);
                                $rsupd->bindValue(':id', $id);
                                $rsupd->execute();
                                $err=$rdb->errorInfo();
                                $rsupd->closeCursor();
							} else {
								$sql="$call query_add_ingredient(:ing)";
                                $rsadd = $rdb->prepare($sql);
                                $rsadd->bindValue(':ing', $ing);
                                $rsadd->execute();
                                $err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                                
								$sql="$call query_ingredient_exists(:ing)";
                                $idrs = $rdb->prepare($sql);
                                $idrs->bindValue(':ing', $ing);
                                $idrs->execute();
                                $err=$rdb->errorInfo();
                                $rs = $idrs->fetch(PDO::FETCH_BOTH);
                                $idrs->closeCursor();
                                
                                $ingid = $rs[0];
                                
								$sql="$call query_add_owner_ingredient(:ingid,:uid)";
                                $oadd = $rdb->prepare($sql);
                                $oadd->bindValue(':ingid', $ingid);
                                $oadd->bindValue(':uid', $uid);
                                $oadd->execute();
                                $err=$rdb->errorInfo();
                                $oadd->closeCursor();
                                
								//update ings in recipes
								$sql="$call query_upd_ings_in_recipes(:ingid,:id,:uid)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':ingid', $ingid);
                                $radd->bindValue(':id', $id);
                                $radd->bindValue(':uid', $uid);
                                $radd->execute();
                                $err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                                
								//only delete ingredient if not used by someone else otherwise just remove from ing_owner table
								if ($erows>0) {
								    $sql="$call query_delete_owner_ing(:id, :uid)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->bindValue(':uid', $uid);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
								} else {
									$sql="$call query_delete_ing(:id)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->execute();
$err=$rdb->errorInfo();
                                    $rs->closeCursor();
								}
							}
						} else {
							//it does so we need to add it to ingredient_owner if it's not already there
							$ingid = $rsingid[0];
                            
							$sql="$call query_ingredient_owner_exists(:ingid,:uid)";
                            $ingownerrs = $rdb->prepare($sql);
                            $ingownerrs->bindValue(':ingid', $ingid);
                            $ingownerrs->bindValue(':uid', $uid);
                            $ingownerrs->execute();
                            $err=$rdb->errorInfo();
                            $ingownerrsrows = $ingownerrs->rowCount();
                            $ingownerrs->closeCursor();
                            
							if ($ingownerrsrows==0) {
								$sql="$call query_add_owner_ingredient(:ingid,:uid)";
                                $ingowneradd = $rdb->prepare($sql);
                                $ingowneradd->bindValue(':ingid', $ingid);
                                $ingowneradd->bindValue(':uid', $uid);
                                $ingowneradd->execute();
                                $err=$rdb->errorInfo();
                                $ingowneradd->closeCursor();
							}
							//update ings in recipes
							$sql="$call query_upd_ings_in_recipes(:ingid,:id,:uid)";
                            $radd = $rdb->prepare($sql);
                            $radd->bindValue(':ingid', $ingid);
                            $radd->bindValue(':id', $id);
                            $radd->bindValue(':uid', $uid);
                            $radd->execute();
                            $err=$rdb->errorInfo();
                            $radd->closeCursor();
							//only delete ingredient if not used by someone else otherwise just remove from ing_owner table
							if ($erows>0) {
                                $sql="$call query_delete_owner_ing(:id, :uid)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':id', $id);
                                $rs->bindValue(':uid', $uid);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            } else {
                                $sql="$call query_delete_ing(:id)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            }
						}
					}
				}
			}
			if (isset($notdel) && $notdel==1) {
                $wmsg='1 ingredient was not deleted, as it is used in recipes';
            } else if(isset($notdel)){
                $wmsg="$notdel ingredients were not deleted, as they are used in recipes";
            }
            if (isset($notdel)) {
                echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Changes Applied<br><br>Note: $wmsg');
                $('.message_box').show();
                </script>";
            } else {
                echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Changes Applied');
                $('.message_box').show();
                </script>";
            } 
		}
		$sql="$call query_all_ingredients(:uid)";
        $result = $rdb->prepare($sql);
        $result->bindValue(':uid', $uid);
        $result->execute();
        $err=$rdb->errorInfo();
        $irows = $result->rowCount();
        $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
        $result->closeCursor();
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>manage <strong>ingredients</strong></h3>
				            <form method=post id=normalise enctype='multipart/form-data'>
					            <br>
					            <INPUT type=submit class='submit btn' name=save value='Apply Changes'>
					            <span id="msgbox" style="display:none"></span>
					            <script type="text/javascript" language="javascript">
						            $("#msgbox").removeClass().addClass('messagebox').text('Button disabled while page is loading....').fadeIn(1000);
						            $('.btn').attr('disabled', 'disabled');
					            </script>
					            <br><br>
					            <?php 
						            echo 'Total Records: '.$irows; 
					            ?>
					            <INPUT type=hidden name=ings value=<?php echo $irows; ?>>
					            <br><br>
					            <strong>Ingredients will be updated in all your personal recipes</strong><br><br>
					            <a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					            <br>
                                <br>
					            <a href='#' class=tcase_not_upper>Convert all (except headers) to title case</a>&nbsp|&nbsp<a href='#' class=lcase_not_upper>Convert all (except headers) to lower case</a>
					            <br><br>
					            <table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						            <thead class='userhead navbar-default'>
							            <tr>
								            <th class=header>Ingredient</th>
                                            <th class=header>Used</th>
								            <th class=header>Recipes Used In</th>
								            <th class=header>Delete</th>
							            </tr>
						            </thead>
						            <tbody class=userbody>
							            <?php
								            $ct=0;
								            foreach($rsresult as $row) {
									            $sql="SELECT distinct recipe, get_recipename(recipe) as name FROM recipe_ing WHERE ing=:cid and recipe in (select id from recipe where owner=:uid)";
                                                $rs = $rdb->prepare($sql);
                                                $rs->bindValue(':cid', $row[1]);
                                                $rs->bindValue(':uid', $uid);
                                                $rs->execute();
                                                $err=$rdb->errorInfo();
                                                $numrecipes = $rs->rowCount();
                                                $rsrec = $rs->fetchAll(PDO::FETCH_BOTH);
                                                $rs->closeCursor(); 
									            print("
									            <tr>
										            <td>
											            <input type=text value='$row[0]' name=ing$ct class=ing>
										            </td>
                                                    <td>
                                                        $numrecipes
                                                        <input type=hidden value='$numrecipes' name=recipes[$ct]>
                                                    </td>
                                                    <td>");
                                                    if ($numrecipes>0) {
                                                        print("<select class='rlist form-control'>
                                                            <option>Select a recipe to view...</option>");
                                                        foreach ($rsrec as $rec) {
                                                           print("<option href=display.php value=$rec[0]>$rec[1]</option>"); 
                                                        }
                                                        echo '</select>';
                                                    }
                                                print("</td>
                                                    <td>
											            <INPUT name=dbox$ct class=chk type=checkbox>
										            </td>
										            <td style='display:none;'>
											            <input type=text value='$row[1]' name=id$ct>
										            </td>
									            </tr>
									            ");
									            $ct++;
								            }
							            ?>
						            </tbody>
					            </table>
					            <a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					            <br>
					            <a href='#' class=tcase_not_upper>Convert all (except headers) to title case</a>&nbsp|&nbsp<a href='#' class=lcase_not_upper>Convert all (except headers) to lower case</a>
					            <br><br>
					            <INPUT type=submit class='submit btn' name=save value='Apply Changes'>
					            
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
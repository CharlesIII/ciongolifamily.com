<?php
        require_once('includes/top.php');
?>
        <title>Manage Categories</title>
        <meta name="description" content="Administrators can manage categories here">
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
                
                if($client=='wrm') {
                    $sql = "$call query_chk_subcat_used_elsewhere(:id, :oid)";
                    $founde = $rdb->prepare($sql);
                    $founde->bindValue(':id', $id);
                    $founde->bindValue(':oid', $oid);
                    $founde->execute();
                    $err=$rdb->errorInfo();
                    $erows = $founde->rowCount();
                    $founde->closeCursor();
                }
				
				if(isset($_POST["dbox$i"])) {
					$recnum=$_POST["recipes$i"];
					if ($recnum>0) {
						$notdel++;
					} else {
						//only delete ingredient if not used by someone else otherwise just remove from owner table
						if ($client=='wrm' && $erows>0) {
                           $sql="$call query_delete_owner_subcat(:id, :oid)";
                           $rs = $rdb->prepare($sql);
                           $rs->bindValue(':id', $id);
                           $rs->bindValue(':oid', $oid);
                           $rs->execute();
$err=$rdb->errorInfo();
                           $rs->closeCursor();
                        } else {
                            $sql="$call query_delete_subcat(:id)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
$err=$rdb->errorInfo();
                            $rs->closeCursor();
                        }
					}
				} else {
					//check if name has changed
					$sql = "$call query_subcat_name(:id)";
                    $crs = $rdb->prepare($sql);
                    $crs->bindValue(':id', $id);
                    $crs->execute();
                    $err=$rdb->errorInfo();
                    $rs = $crs->fetch(PDO::FETCH_BOTH);
                    $crs->closeCursor();
                    if ($rs[0]!=$ing) {
                        
						//it has so check if the new one already exists
						$sql = "$call query_subcategory_exists(:ing)";
                        $dboscat = $rdb->prepare($sql);
                        $dboscat->bindValue(':ing', $ing);
                        $dboscat->execute();
                        $err=$rdb->errorInfo();
                        $oscatrows = $dboscat->rowCount();
                        $rsoscat = $dboscat->fetch(PDO::FETCH_BOTH);
                        $dboscat->closeCursor();
                        if ($oscatrows==0) {
							//it doesn't so if no one else is using the old one we can update it otherwise we need to add a new one
							if ((isset($erows) && $erows==0) || $client!='wrm') {
                                $sql="$call query_upd_subcat(:ing,:id)";
                                $rsupd = $rdb->prepare($sql);
                                $rsupd->bindValue(':ing', $ing);
                                $rsupd->bindValue(':id', $id);
                                $rsupd->execute();
                                $err=$rdb->errorInfo();
                                $rsupd->closeCursor();
                            } else {
								$sql="$call query_add_subcategory(:ing)";
                                $rsadd = $rdb->prepare($sql);
                                $rsadd->bindValue(':ing', $ing);
                                $rsadd->execute();
                                $err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                                
                                $sql="$call query_subcategory_exists(:ing)";
                                $idrs = $rdb->prepare($sql);
                                $idrs->bindValue(':ing', $ing);
                                $idrs->execute();
                                $err=$rdb->errorInfo();
                                $rs = $idrs->fetch(PDO::FETCH_BOTH);
                                $idrs->closeCursor();
                                
                                $ingid = $rs[0];
                                
                                $sql="$call query_add_owner_subcategory(:ingid,:uid)";
                                $oadd = $rdb->prepare($sql);
                                $oadd->bindValue(':ingid', $ingid);
                                $oadd->bindValue(':uid', $uid);
                                $oadd->execute();
                                $err=$rdb->errorInfo();
                                $oadd->closeCursor();
                                
								//update ings in recipes
								$sql="$call query_upd_subcats_in_recipes(:ingid,:id,:oid)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':ingid', $ingid);
                                $radd->bindValue(':id', $id);
                                $radd->bindValue(':oid', $oid);
                                $radd->execute();
                                $err=$rdb->errorInfo();
                                $radd->closeCursor();
                                
								//only delete ingredient if not used by someone else otherwise just remove from owner table
								if ($erows>0) {
                                   $sql="$call query_delete_owner_subcat(:id, :oid)";
                                   $rs = $rdb->prepare($sql);
                                   $rs->bindValue(':id', $id);
                                   $rs->bindValue(':oid', $oid);
                                   $rs->execute();
                                   $err=$rdb->errorInfo();
                                   $rs->closeCursor();
                                } else {
                                    $sql="$call query_delete_subcat(:id)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->execute();
$err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                }
							}
						} else {
							//it does so we need to add it to owner table if it's not already there
							$ingid = $rsoscat[0];
                            
                            if($client=='wrm') {
                                $sql="$call query_subcategory_dbowner_exists(:ingid,:oid)";
                                $ingownerrs = $rdb->prepare($sql);
                                $ingownerrs->bindValue(':ingid', $ingid);
                                $ingownerrs->bindValue(':oid', $oid);
                                $ingownerrs->execute();
                                $err=$rdb->errorInfo();
                                $ingownerrsrows = $ingownerrs->rowCount();
                                $ingownerrs->closeCursor();
                            } else {
                                $sql="$call query_subcategory_owner_exists(:ingid,:uid)";
                                $ingownerrs = $rdb->prepare($sql);
                                $ingownerrs->bindValue(':ingid', $ingid);
                                $ingownerrs->bindValue(':uid', $uid);
                                $ingownerrs->execute();
$err=$rdb->errorInfo();
                                $ingownerrsrows = $ingownerrs->rowCount();
                                $ingownerrs->closeCursor();
                            }
							if ($ingownerrsrows==0) {
                                $sql="$call query_add_owner_subcategory(:ingid,:uid)";
                                $ingowneradd = $rdb->prepare($sql);
                                $ingowneradd->bindValue(':ingid', $ingid);
                                $ingowneradd->bindValue(':uid', $uid);
                                $ingowneradd->execute();
                                $err=$rdb->errorInfo();
                                $ingowneradd->closeCursor();
                            }
							//update ings in recipes
							if($client=='wrm') {
                                $sql="$call query_upd_subcats_in_recipes(:ingid,:id,:oid)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':ingid', $ingid);
                                $radd->bindValue(':id', $id);
                                $radd->bindValue(':oid', $oid);
                                $radd->execute();
                                $err=$rdb->errorInfo();
                                $radd->closeCursor();
                            } else {
                                $sql="$call query_upd_subcategorys_in_recipes(:ingid, :id)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':ingid', $ingid);
                                $radd->bindValue(':id', $id);
                                $radd->execute();
$err=$rdb->errorInfo();
                                $radd->closeCursor();
                            }
							//only delete it if not used by someone else otherwise just remove from owner table
							if ($client=='wrm' && $erows>0) {
                               $sql="$call query_delete_owner_subcat(:id, :oid)";
                               $rs = $rdb->prepare($sql);
                               $rs->bindValue(':id', $id);
                               $rs->bindValue(':oid', $oid);
                               $rs->execute();
$err=$rdb->errorInfo();
                                $rs->closeCursor();
                            } else {
                                $sql="$call query_delete_subcat(:id)";
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
				$wmsg='1 category was not deleted, as it is used in recipes';
			} else if(isset($notdel)){
				$wmsg="$notdel categories were not deleted, as they are used in recipes";
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
		if($client=='wrm') {
            $sql="$call query_all_subcats(:oid)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':oid', $oid);
            $result->execute();
            $err=$rdb->errorInfo();
            $irows = $result->rowCount();
        } else {
            $sql="$call query_all_subcategorys()";
            $result = $rdb->prepare($sql);
            $result->execute();
$err=$rdb->errorInfo();
            $irows = $result->rowCount();
        }
        $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
        $result->closeCursor();
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				<h3>manage <strong>categories</strong></h3>
				<form id=normalise enctype='multipart/form-data'" method=post>
					<br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<br><br>
					<?php 
						echo 'Total Records: '.$irows; 
					?>
					<br><br>
					<strong>Categories will be updated in all recipes in your shared database</strong><br><br>
					<a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					<table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						<thead class='userhead navbar-default'>
							<tr>
								<th class=header>Category</th>
                                <th class=header>Used</th>
                                <th class=header>Recipes Used In</th>
                                <th class=header>Delete</th>
							</tr>
						</thead>
						<tbody class=userbody>
					<?php
						$ct=0;
						foreach($rsresult as $row) {
                            if($client=='wrm') {
                                $sql="SELECT distinct recipe, get_recipename(recipe) as name FROM recipe_cat_subcat WHERE subcat=:cid and recipe in (select id from recipe where owner in (select id from owner where dboid=:oid))";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':cid', $row[1]);
                                $rs->bindValue(':oid', $oid);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $numrecipes = $rs->rowCount();
                                $rsrec = $rs->fetchAll(PDO::FETCH_BOTH);
                                $rs->closeCursor();
                            } else {                  
                                $sql="SELECT distinct recipe, get_recipename(recipe) as name FROM recipe_cat_subcat WHERE cat=:cid";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':cid', $row[1]);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $numrecipes = $rs->rowCount();
                                $rsrec = $rs->fetchAll(PDO::FETCH_BOTH);
                                $rs->closeCursor();                                
                            }
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
					<br><br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<INPUT type=hidden name=ings value=<?php echo $irows; ?>>
				</form>
			</div>
			<?php
				require_once('includes/bottom.php');
			?>
<?php
        require_once('includes/top.php');
?>
    <title>Manage Yield Units</title>
    <meta name="description" content="Manage your recipe yield units here">
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
				$id = $_POST['id'][$i];
				$yunit = $_POST['ing'][$i];
				
                $sql = "$call query_chk_yield_unit_used_elsewhere(:id, :uid)";
                $founde = $rdb->prepare($sql);
                $founde->bindValue(':id', $id);
                $founde->bindValue(':uid', $uid);
                $founde->execute();
                $err=$rdb->errorInfo();
                $erows = $founde->rowCount();
                $founde->closeCursor();
                
				if(isset($_POST['dbox'][$i])) {
					$recnum=$_POST['recipes'][$i];
					if ($recnum>0) {
						$notdel++;
					} else {
						//only delete if not used by someone else otherwise just remove from owner table
						if ($erows>0) {
                            $sql="$call query_delete_owner_yield_unit(:id, :uid)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->bindValue(':uid', $uid);
                            $rs->execute();
$err=$rdb->errorInfo();
                            $rs->closeCursor();
                        } else {
                            $sql="$call query_delete_yield_unit(:id)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
$err=$rdb->errorInfo();
                            $rs->closeCursor();
                        }
					}
				} else {
					//check if name has changed
					$sql = "$call query_yield_unit_name(:id)";
                    $crs = $rdb->prepare($sql);
                    $crs->bindValue(':id', $id);
                    $crs->execute();
                    $err=$rdb->errorInfo();
                    $rs = $crs->fetch(PDO::FETCH_BOTH);
                    $crs->closeCursor();
                    if ($rs[0]!=$yunit) {
						//it has so check if the new one already exists
						$sql = "$call query_yield_unit_exists(:yunit)";
                        $dbunitid = $rdb->prepare($sql);
                        $dbunitid->bindValue(':yunit', $yunit);
                        $dbunitid->execute();
                        $err=$rdb->errorInfo();
                        $unitrows = $dbunitid->rowCount();
                        $rsunitid = $dbunitid->fetch(PDO::FETCH_BOTH);
                        $dbunitid->closeCursor();
                        
                        if ($unitrows==0) {
							//it doesn't so if no one else is using the old one we can update it otherwise we need to add a new one
							if ($erows==0) {
								$sql="$call query_upd_yield_unit(:yunit,:id)";
                                $rsupd = $rdb->prepare($sql);
                                $rsupd->bindValue(':yunit', $yunit);
                                $rsupd->bindValue(':id', $id);
                                $rsupd->execute();
                                $err=$rdb->errorInfo();
                                $rsupd->closeCursor();
							} else {
								$sql="$call query_add_yield_unit(:yunit)";
                                $rsadd = $rdb->prepare($sql);
                                $rsadd->bindValue(':yunit', $yunit);
                                $rsadd->execute();
$err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                                
								$sql="$call query_yield_unit_exists(:yunit)";
                                $idrs = $rdb->prepare($sql);
                                $idrs->bindValue(':yunit', $yunit);
                                $idrs->execute();
$err=$rdb->errorInfo();
                                $rs = $idrs->fetch(PDO::FETCH_BOTH);
                                $idrs->closeCursor();
                                
                                $yunitid = $rs[0];
                                
								$sql="$call query_add_owner_yield_unit(:yunitid,:uid)";
                                $oadd = $rdb->prepare($sql);
                                $oadd->bindValue(':yunitid', $yunitid);
                                $oadd->bindValue(':uid', $uid);
                                $oadd->execute();
$err=$rdb->errorInfo();
                                $oadd->closeCursor();
                                
								//update in recipes
								$sql="$call query_upd_yield_unit_in_recipes(:yunitid,:id,:uid)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':yunitid', $yunitid);
                                $radd->bindValue(':id', $id);
                                $radd->bindValue(':uid', $uid);
                                $radd->execute();
$err=$rdb->errorInfo();
                                $radd->closeCursor();
								//only delete if not used by someone else otherwise just remove from owner table
								if ($erows>0) {
                                    $sql="$call query_delete_owner_yield_unit(:id, :uid)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->bindValue(':uid', $uid);
                                    $rs->execute();
                                    $rs->closeCursor();
                                } else {
                                    $sql="$call query_delete_yield_unit(:id)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->execute();
                                    $rs->closeCursor();
                                }
							}
						} else {
							//it does so we need to add it to owner table if it's not already there
							$yunitid = $rsunitid[0];
							$sql="$call query_unit_owner_exists(:yunitid,:uid)";
                            $yunitownerrs = $rdb->prepare($sql);
                            $yunitownerrs->bindValue(':yunitid', $yunitid);
                            $yunitownerrs->bindValue(':uid', $uid);
                            $yunitownerrs->execute();
                            $err=$rdb->errorInfo();
                            $yunitownerrsrows = $yunitownerrs->rowCount();
                            $yunitownerrs->closeCursor();
							
                            if ($yunitownerrsrows==0) {
                                $sql="$call query_add_owner_yield_unit(:yunitid,:uid)";
                                $unitowneradd = $rdb->prepare($sql);
                                $unitowneradd->bindValue(':yunitid', $yunitid);
                                $unitowneradd->bindValue(':uid', $uid);
                                $unitowneradd->execute();
                                $err=$rdb->errorInfo();
                                $unitowneradd->closeCursor();
                            }
							//update in recipes
							$sql="$call query_upd_yield_unit_in_recipes(:yunitid,:id,:uid)";
                            $radd = $rdb->prepare($sql);
                            $radd->bindValue(':yunitid', $yunitid);
                            $radd->bindValue(':id', $id);
                            $radd->bindValue(':uid', $uid);
                            $radd->execute();
                            $err=$rdb->errorInfo();
                            $radd->closeCursor();
                            //only delete if not used by someone else otherwise just remove from owner table
                            if ($erows>0) {
                                $sql="$call query_delete_owner_yield_unit(:id, :uid)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':id', $id);
                                $rs->bindValue(':uid', $uid);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            } else {
                                $sql="$call query_delete_yield_unit(:id)";
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
                $wmsg='1 yield unit was not deleted, as it is used in recipes';
            } else if(isset($notdel)){
                $wmsg="$notdel yield units were not deleted, as they are used in recipes";
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
		$sql="$call query_all_yield_units(:uid)";
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
				<h3>manage <strong>yield units</strong></h3>
				<form method=post enctype='multipart/form-data'">
					<br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<br><br>
					<?php 
						echo 'Total Records: '.$irows; 
					?>
					<br><br>
					<strong>Yield Units will be updated in all your personal recipes</strong><br><br>
					<a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					<table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						<thead class='userhead navbar-default'>
							<tr>
								<th class=header>Yield Unit</th>
                                <th class=header>Used</th>
                                <th class=header>Recipes Used In</th>
                                <th class=header>Delete</th>
							</tr>
						</thead>
						<tbody class=userbody>
					<?php
                        $ct=0;
						foreach($rsresult as $row) {
							$sql="SELECT id, name FROM recipe WHERE yield_unit=:cid and owner=:uid";
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
									<input type=text value='$row[0]' name=ing[$ct] class=ing>
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
									<INPUT name=dbox[$ct] class=chk type=checkbox>
								</td>
								<td style='display:none;'>
									<input type=text value='$row[1]' name=id[$ct]>
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
<?php
        require_once('includes/top.php');
?>
        <title>Manage prepreparation/notes</title>
        <meta name="description" content="Manage your recipe prepreparation/notes here">
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
				$pp = $_POST["ing$i"];
				
                $sql = "$call query_chk_pp_used_elsewhere(:id, :uid)";
                $founde = $rdb->prepare($sql);
                $founde->bindValue(':id', $id);
                $founde->bindValue(':uid', $uid);
                $founde->execute();
                $err=$rdb->errorInfo();
                $erows = $founde->rowCount();
                $founde->closeCursor();
                
				if(isset($_POST["dbox$i"])) {
					$recnum=$_POST['recipes'][$i];
					if ($recnum>0) {
						$notdel++;
					} else {
						//only delete if not used by someone else otherwise just remove from owner table
						if ($erows>0) {
                            $sql="$call query_delete_owner_pp(:id, :uid)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->bindValue(':uid', $uid);
                            $rs->execute();
$err=$rdb->errorInfo();
                            $rs->closeCursor();
                        } else {
                            $sql="$call query_delete_pp(:id)";
                            $rs = $rdb->prepare($sql);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
$err=$rdb->errorInfo();
                            $rs->closeCursor(); 
                        }
					}
				} else {
					//check if name has changed
					$sql = "$call query_pp_name(:id)";
                    $cdb = $rdb->prepare($sql);
                    $cdb->bindValue(':id', $id);
                    $cdb->execute();
                    $err=$rdb->errorInfo();
                    $crs = $cdb->fetch(PDO::FETCH_BOTH);
                    $cdb->closeCursor();
                    if ($crs[0]!=$pp) {
						//it has so check if the new one already exists
						$sql = "$call query_preprep_exists(:pp)";
                        $dbppid = $rdb->prepare($sql);
                        $dbppid->bindValue(':pp', $pp);
                        $dbppid->execute();
                        $err=$rdb->errorInfo();
                        $pprows = $dbppid->rowCount();
                        $rsppid = $dbppid->fetch(PDO::FETCH_BOTH);
                        $dbppid->closeCursor();
                        if ($pprows==0) {
							//it doesn't so if no one else is using the old one we can update it otherwise we need to add a new one
							if ($erows==0) {
								$sql="$call query_upd_pp(:pp,:id)";
                                $rsupd = $rdb->prepare($sql);
                                $rsupd->bindValue(':pp', $pp);
                                $rsupd->bindValue(':id', $id);
                                $rsupd->execute();
                                $err=$rdb->errorInfo();
                                $rsupd->closeCursor();
							} else {
								$sql="$call query_add_preprep(:pp)";
                                $rsadd = $rdb->prepare($sql);
                                $rsadd->bindValue(':pp', $pp);
                                $rsadd->execute();
                                $err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                                
                                $sql="$call query_preprep_exists(:pp)";
                                $iddb = $rdb->prepare($sql);
                                $iddb->bindValue(':pp', $pp);
                                $iddb->execute();
                                $err=$rdb->errorInfo();
                                $idrs = $iddb->fetch(PDO::FETCH_BOTH);
                                $iddb->closeCursor();
                                
                                $ppid = $idrs[0];
                                
                                $sql="$call query_add_owner_preprep(:ppid,:uid)";
                                $oadd = $rdb->prepare($sql);
                                $oadd->bindValue(':ppid', $ppid);
                                $oadd->bindValue(':uid', $uid);
                                $oadd->execute();
                                $err=$rdb->errorInfo();
                                $oadd->closeCursor();
								//update ings in recipes
								$sql="$call query_upd_pp_in_recipes(:ppid,:id,:uid)";
                                $radd = $rdb->prepare($sql);
                                $radd->bindValue(':ppid', $ppid);
                                $radd->bindValue(':id', $id);
                                $radd->bindValue(':uid', $uid);
                                $radd->execute();
                                $err=$rdb->errorInfo();
                                $radd->closeCursor();
                                
                                //only delete if not used by someone else otherwise just remove from owner table
                                if ($erows>0) {
                                    $sql="$call query_delete_owner_pp(:id, :uid)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->bindValue(':uid', $uid);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                } else {
                                    $sql="$call query_delete_pp(:id)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':id', $id);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                }
							}
						} else {
							//it does so we need to add it to owner table if it's not already there
				            $ppid = $rsppid[0];
                            
                            $sql="$call query_preprep_owner_exists(:ppid,:uid)";
                            $ppownerrs = $rdb->prepare($sql);
                            $ppownerrs->bindValue(':ppid', $ppid);
                            $ppownerrs->bindValue(':uid', $uid);
                            $ppownerrs->execute();
                            $err=$rdb->errorInfo();
                            $ppownerrsrows = $ppownerrs->rowCount();
                            $ppownerrs->closeCursor();
                            
                            if ($ppownerrsrows==0) {
                                $sql="$call query_add_owner_preprep(:ppid,:uid)";
                                $ppowneradd = $rdb->prepare($sql);
                                $ppowneradd->bindValue(':ppid', $ppid);
                                $ppowneradd->bindValue(':uid', $uid);
                                $ppowneradd->execute();
                                $err=$rdb->errorInfo();
                                $ppowneradd->closeCursor();
                            }
							//update in recipes
							$sql="$call query_upd_pp_in_recipes(:ppid,:id,:uid)";
                            $radd = $rdb->prepare($sql);
                            $radd->bindValue(':ppid', $ppid);
                            $radd->bindValue(':id', $id);
                            $radd->bindValue(':uid', $uid);
                            $radd->execute();
                            $err=$rdb->errorInfo();
                            $radd->closeCursor();
                            //only delete if not used by someone else otherwise just remove from owner table
                            if ($erows>0) {
                                $sql="$call query_delete_owner_pp(:id, :uid)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':id', $id);
                                $rs->bindValue(':uid', $uid);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            } else {
                                $sql="$call query_delete_pp(:id)";
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
                $wmsg='1 prepreparation/note was not deleted, as it is used in recipes';
            } else if(isset($notdel)){
                $wmsg="$notdel prepreparation/note were not deleted, as they are used in recipes";
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
		$sql="$call query_all_pp(:uid)";
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
				<h3>manage <strong>prepreparation/notes</strong></h3>
				<form method=post enctype='multipart/form-data'">
					<br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<INPUT type=hidden name=ings value=<?php echo $irows; ?>>
					<br><br>
					<?php 
						echo 'Total Records: '.$irows; 
					?>
					<br><br>
					<strong>Prepreparation/Notes will be updated in all your personal recipes</strong><br><br>
					<a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					<table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						<thead class='userhead navbar-default'>
							<tr>
								<th class=header>Prepreparation/Note</th>
                                <th class=header>Used</th>
                                <th class=header>Recipes Used In</th>
                                <th class=header>Delete</th>
							</tr>
						</thead>
						<tbody class=userbody>
					<?php
                        $ct=0;
						foreach($rsresult as $row) {
							$sql="SELECT distinct recipe, get_recipename(recipe) FROM recipe_ing WHERE (preprep1=:cid or preprep2=:cid) and recipe in (select id from recipe where owner=:uid)";
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
					<br><br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
				</form>
			</div>
			<?php
				require_once('includes/bottom.php');
			?>
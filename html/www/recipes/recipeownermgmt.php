<?php
        require_once('includes/top.php');
?>
    <title>Manage recipe owners</title>
    <meta name="description" content="Manage your recipe owners here">
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
			$ingno = count($_POST['ingowner']);
			for($i=0;$i<$ingno;$i++) {
				$id = $_POST['id'][$i];
				$ownerid = $_POST['ingowner'][$i];
                
				$sql="$call query_upd_owner_in_recipes(:ownerid,:id)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':ownerid', $ownerid);
                $rs->bindValue(':id', $id);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
			}
			echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Changes Applied');
                $('.message_box').show();
                </script>";
		}
        if($client=='wrm') {
		    $sql="$call query_recipes_with_name_id_owner(:uid)";
            $result= $rdb->prepare($sql);
            $result->bindValue(':uid', $uid);
            $result->execute();
            $err=$rdb->errorInfo();
            $rrows = $result->rowCount();
            $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
            $result->closeCursor();
        } else {
            $sql="$call query_recipes_with_name_id_owner()";
            $result = $rdb->prepare($sql);
            $result->execute();
            $err=$rdb->errorInfo();
            $rrows = $result->rowCount();
            $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
            $result->closeCursor();
        }
        
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				<h3>manage <strong>recipe owners</strong></h3>
				<form method=post enctype='multipart/form-data'">
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<INPUT type=hidden name=ings value=<?php echo $rrows; ?>>
					<br><br>
					<?php 
						echo 'Total Records: '.$rrows; 
					?>
					<br><br>
					<div class='ok message_box' style="display:none;"></div>
					<table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						<thead class='userhead navbar-default'>
							<tr>
								<th class=header>Recipe Name</th>
								<th class=header>Owner</th>
							</tr>
						</thead>
						<tbody class=userbody>
					<?php
                        $ct=0;
                        foreach($rsresult as $row) {
							Print("
							<tr>
								<td>
									$row[1]
								</td>
								<td>
									<select class=form-control name=ingowner[$ct]>");
                                       for($lt=0;$lt<$users;$lt++) {
                                           $ouser=$rsusers[$lt][1];
                                           $ouserid=$rsusers[$lt][0];
                                           $pos = strpos($ouser, "_");
                                           if ($pos>-1) {
                                                $souser = substr($ouser,$pos+1);
                                           } else {
                                                $souser= $ouser;
                                           }
                                           if($ouser==$row[2]) {
                                               print("<option SELECTED value=$ouserid>$souser</option>");
                                           } else {
                                               
                                               print("<option value=$ouserid>$souser</option>");
                                           }
                                       }
								print("</select></td>
								<td style='display:none;'>
									<input type=text value='$row[0]' name=id[$ct]>
								</td>
							</tr>
							");
                            $ct++;
						}
					?>
						</tbody>
					</table>
					<br><br>
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
				</form>
			</div>
			<?php
				require_once('includes/bottom.php');
			?>
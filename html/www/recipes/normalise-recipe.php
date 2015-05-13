<?php
        require_once('includes/top.php');
?>
    <title>Manage recipe names</title>
    <meta name="description" content="Manage your recipe names here">
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
				$recipe = $_POST['ing'][$i];
                
				$sql = "$call query_recipe_name(:id)";
				$crs = $rdb->prepare($sql);
                $crs->bindValue(':id', $id);
                $crs->execute();
                $err=$rdb->errorInfo();
                $rs = $crs->fetch(PDO::FETCH_BOTH);
                $crs->closeCursor();
                $name = $rs[0];
                
                if ($name!=$recipe) {				
					$sql = "$call query_upd_name_in_recipes(:recipe,:id)";
					$rsupd = $rdb->prepare($sql);
                    $rsupd->bindValue(':recipe', $recipe);
                    $rsupd->bindValue(':id', $id);
                    $rsupd->execute();
                    $err=$rdb->errorInfo();
                    $rsupd->closeCursor();                                              
				}
			}
			echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Changes Applied');
                $('.message_box').show();
                </script>";
		}
		$sql="$call query_user_recipes_with_name_id(:uid)";
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
				<h3>manage <strong>recipe names</strong></h3>
				<form method=post enctype='multipart/form-data'">
					<INPUT type=submit id=submit name=save value='Apply Changes' class=btn>
					<INPUT type=hidden name=ings value=<?php echo $irows; ?>>
					<br><br>
					<?php 
						echo 'Total Records: '.$irows; 
					?>
					<br><br>
					<a href='#' class=tcase>Convert all to title case</a>&nbsp|&nbsp<a href='#' class=lcase>Convert all to lower case</a>
					<table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						<thead class='userhead navbar-default'>
							<tr>
								<th class=header>Recipe Name</th>
							</tr>
						</thead>
						<tbody class=userbody>
					<?php
                        $ct=0;
						foreach($rsresult as $row ) {
							echo '
							<tr>
								<td>
									<input type=text value="'.$row[1].'" name=ing['.$ct.'] class="recipe recipewide">
								</td>
								<td style="display:none;">
									<input type=text value="'.$row[0].'" name=id['.$ct.']>
								</td>
							</tr>
							';
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
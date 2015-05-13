<?php
        require_once('includes/top.php');
?>
    <title>Manage Deleted Recipes</title>
    <meta name="description" content="Administrators can recipes deleted by other users here">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/my.table.js"></script>
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
		if (isset($_POST['save']) && $_POST['save']=='Update') {
            echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('Applying changes...');
                $('.message_box').show();
            </script>";
			$ingno = $_POST['ings']+1;
			for($i=1;$i<$ingno;$i++) {
				$id = $_POST['id'][$i];
                if(isset($_POST['vis'][$i])) {
				    $vis = $_POST['vis'][$i];
                }
				if(isset($_POST['dbox'][$i])) {
                    $oldid=$id;
					require('includes/delrecipe.php');
                    if($oldid==$_COOKIE['rid']) {
                        require_once('includes/get_latest_recipe.php');
                        if ($recrows>0) {
                            $id=$result[0];
                            require_once('includes/get_recipe_owner.php');
                             echo "<script type='text/javascript'>
                                $.cookie('rid',$id, { path: '/' });
                                $.cookie('rowner',$rowner, { path: '/' });
                            </script>";
                        }       
                    }
				} else {
					if (isset($vis) && $vis) {
						$vis=TRUE;
					}  else {
						$vis=FALSE;
					}
					$sql="$call query_add_visible_to_recipe(:vis,:uid, :id)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':vis', $vis);
                    $rs->bindValue(':uid', $uid);
                    $rs->bindValue(':id', $id);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor(); 
				}
			}
			echo "<script type='text/javascript'>
            $('.message_box').addClass('ok');
            $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Changes Applied');
            $('.message_box').show();
            </script>";
		}
        if($client=='wrm') {
		    $sql="$call query_recipes_with_name_id_owner_visible(:oid)";
            $result = $rdb->prepare($sql);
            $result->bindValue(':oid', $oid);
        } else {
            $sql="$call query_recipes_with_name_id_owner_visible()";
            $result = $rdb->prepare($sql);
        }
        $result->execute();
        $err=$rdb->errorInfo();
        $rows = $result->rowCount();
        $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
        $result->closeCursor();
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>manage <strong>deleted recipes</strong></h3>
				            <form method=post enctype='multipart/form-data'>
					            <INPUT type=submit id=submit name=save value=Update class=btn>
					            <br><br>
					            <?php
						            echo 'Total Records: '.$rows;
					            ?>
					            <table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
						            <thead class='userhead navbar-default'>
							            <tr>
								            <th class=header>Recipe Name</th>
								            <th class=header>Deleted By</th>
								            <th class=header>Visible</th>
								            <th class=header>Delete</th>
							            </tr>
						            </thead>
						            <tbody class=userbody>
							            <?php
								            $lt=0;
								            foreach($rsresult as $row) {
									            $lt++;
                                                if($client=='wrm') {
									                $pos=strpos($row[2],'_');
									                if ($pos) {
										                if (substr($row[2],0,$pos)==$owner) {
											                $sdbuser=substr($row[2],$pos + 1);
										                }
									                } else {
                                                        $sdbuser=$row[2];
                                                    }
                                                } else {
                                                    $sdbuser=$row[2];
                                                }
									            print("
									            <tr>
										            <td>
											            $row[1]
											            <input type=hidden value='$row[1]' name=ing[$lt] class=smrecipe>
										            </td>
										            <td>
											            $sdbuser
											            <input type=hidden value='$row[2]' name=owner[$lt] class=owner>
										            </td>
										            <td>");
											            if ($row[3]) {
												            print("<INPUT name=vis[$lt] class=chk type=checkbox checked>");
											            } else {
												            print("<INPUT name=vis[$lt] class=chk type=checkbox>");
											            }
										            print("</td>
										            <td>
											            <INPUT name=dbox[$lt] class=chk type=checkbox>
										            </td>
										            <td style='display:none;'>
											            <input type=text value='$row[0]' name=id[$lt]>
										            </td>
									            </tr>
									            ");
								            }
							            ?>
						            </tbody>
					            </table>
					            <INPUT type=submit id=submit name=save value=Update class=btn>
					            <INPUT type=hidden name=ings value=<?php echo $rows; ?>>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
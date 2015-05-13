<?php
        require_once('includes/top.php');
?>
        <title>Manage Excluded Ingredients</title>
        <meta name="description" content="Manage your list of ingredients to be excluded from shopping lists.">
	<script src="js/my.excl.js"></script>
	<script src="js/decode.min.js"></script>
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
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>manage <strong>ingredient exclusion </strong>list</h3>
				            <form name='form1' method=post>
					            
					            <br>
					            <div>
						            <div class=dib id=inglist>
							            <INPUT type=submit id=add name=add value=Add class=btn>
							            <br>
							            <h4>Ingredients to exclude</h4>
							            <?php
								            $sql = "$call query_owner_nexcl_ingredients_ids_no_hdr(:uid)";
                                            $rsing = $rdb->prepare($sql);
                                            $rsing->bindValue(':uid', $uid);
                                            $rsing->execute();
                                            $err=$rdb->errorInfo();

                                            $opti = '';
								            foreach ($rsing as $row) {
									            $rowid=$row[0];
									            $rowing=$row[1];
									            $opti .= '<option value='.$rowid.'>'.$rowing.'</option>';
								            }
                                            $rsing->closeCursor();
								            $opti .= '</select>';
				            
								            print("<select class='excl form-control' size=20 name=ing multiple id=ing>");
								            echo $opti;
								            $sql = "$call query_owner_excl_ingredients(:uid)";
                                            $dbexcl = $rdb->prepare($sql);
                                            $dbexcl->bindValue(':uid', $uid);
                                            $dbexcl->execute();
                                            $err=$rdb->errorInfo();

								            $exclusions=$dbexcl->rowCount();
                                            $rsexcl = $dbexcl->fetchAll(PDO::FETCH_BOTH);
                                            $dbexcl->closeCursor();
							            ?>
							            <input id='exclnum' type=hidden name='exclnum' value=<?php echo $exclusions; ?>><br>
							            <br>
							            <INPUT type=submit id=add name=add value=Add class=btn>	
						            </div>
						            <div class=dib>
							            <div>
								            <div class=dib>
									            <INPUT type=submit name=save value=Save class="btn save">
								            </div>
								            <div class=dib>
									            <INPUT type=submit name=clear value=Clear class="btn clear">
								            </div>
							            </div>
							            <div>
								            <h4>Excluded Ingredients</h4>
								            <div id=list>
									            <?php
										            for ($lt = 0; $lt < $exclusions; $lt++) {
											            $ingid=$rsexcl[$lt][0];
											            $ing=$rsexcl[$lt][1];
											            print("<div id=div$lt><input type=checkbox id=chk$lt name=chk$lt checked class='chk css-checkbox' onclick='removeUnchecked(this)'>");
											            print("<label for=chk$lt class=css-label>$ing</label>");
                                                        print("<input id='item$lt' type=hidden name='item$lt' value=$ingid></div>");
										            }
									            ?>
								            </div>
							            </div>
							            <div>
								            <div class=dib>
									            <INPUT type=submit name=save value=Save class="btn save">
								            </div>
								            <div class=dib>
									            <INPUT type=submit name=clear value=Clear class="btn clear">
								            </div>
							            </div>
						            </div>
					            </div>
					            
					            <input type=hidden name=menu value=<?php if(isset($_POST['menu'])) {echo $_POST['menu'];}?>>
					            <input type=hidden name=list value=<?php if(isset($_POST['list'])) {echo $_POST['list'];}?>>
				            </FORM>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>      
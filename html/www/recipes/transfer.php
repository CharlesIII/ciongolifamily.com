<?php
	require_once('includes/top.php');
?>
    <title>Transfer DB Ownership</title>
    <meta name="description" content="Transfer ownership of your database to someone else">
</head>
<body>
<div class='ok message_box' style="display:none;"></div>
<?php
	require_once('includes/banner.php');
?>
	<div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
                            <h3>transfer <strong>database ownership</strong></h3>	
                            <form method="post" id="support_form" action="">
			                    <br><br>
			                    <p><strong>NOTE:</strong> If you transfer ownership to someone else you will lose all ownership priveleges</p>
			                    <div>
				                    <div>
					                    <div class=dib>
						                    <strong>Select New Owner:</strong>
					                    </div>
					                    <div class='dib formselect'>
						                    <?php
							                    $sql = "$call query_db_users(:uid)";
                                                $dbusers = $rdb->prepare($sql);
                                                $dbusers->bindValue(':uid', $uid);
                                                $dbusers->execute();
                                                $err=$rdb->errorInfo();
							                    $numu = $dbusers->rowCount();
                                                $rsusers = $dbusers->fetchAll(PDO::FETCH_BOTH);
                                                $dbusers->closeCursor();
                                                
							                    print("<select id=users name=users class=form-control style='min-width:100px;'>");
							                    if (isset($_POST['users']) and $_POST['users']!="") {
								                    $seluid=$_POST['users'];

								                    $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);

								                    for ($lt = 0; $lt < $numu; $lt++) {
									                    if ($seluid==$rsusers[$lt][0]) {
										                    $seluser=$rsusers[$lt][1];
										                    //remove the current owner prefix from the new owner
										                    $nseluser=str_replace($owner."_","",$seluser);

										                    //update the new owners username, dbowner and dboid, and ensure they are an admin
										                    $sql="$call query_upd_user_to_owner(:nseluser,:seluid)";
                                                            $db = $rdb->prepare($sql);
                                                            $db->bindValue(':nseluser', $nseluser);
                                                            $db->bindValue(':seluid', $seluid);
                                                            $db->execute();
                                                            $err=$rdb->errorInfo();
                                                            $db->closeCursor();
                                                            
										                    $data = array( 'nseluser' => "$nseluser", 'seluser' => "$seluser");
										                    $STH = $mdb->prepare("UPDATE users SET username=:nseluser WHERE username=:seluser");
										                    $STH->execute($data);
                                                            $STH->closeCursor();

										                    //change the package owner in AWBS
										                    $data = array( 'nseluser' => "$nseluser", 'owner' => "$owner");
										                    $STH = $mdb->prepare("UPDATE hostinglist SET ownerid=:nseluser WHERE ownerid=:owner");
										                    $STH->execute($data);
                                                            $STH->closeCursor();

										                    //add the prefix for the new owner to the old one
										                    $newouser=$nseluser."_".$owner;
										                    $data = array( 'newouser' => "$newouser", 'owner' => "$owner");
										                    $STH = $mdb->prepare("UPDATE users SET username=:newouser WHERE username=:owner");
										                    $STH->execute($data);
                                                            $STH->closeCursor();
									                    }
								                    }
								                    for ($lt = 0; $lt < $numu; $lt++) {
									                    if ($seluid!=$rsusers[$lt][0]) {
										                    $cuid=$rsusers[$lt][0];
										                    $cuser=$rsusers[$lt][1];
										                    //replace the current owner prefix to the new owner
										                    $ncuser=str_replace($owner."_",$nseluser."_",$cuser);
										                    //update users username, dbowner and dboid to the new owner
										                    $sql="$call query_upd_users_dbowner(:ncuser,:nseluser,:seluid,:cuid)";
                                                            $db = $rdb->prepare($sql);
                                                            $db->bindValue(':ncuser', $ncuser);
                                                            $db->bindValue(':nseluser', $nseluser);
                                                            $db->bindValue(':seluid', $seluid);
                                                            $db->bindValue(':cuid', $cuid);
                                                            $db->execute();
                                                            $err=$rdb->errorInfo();
                                                            $db->closeCursor();
                                                            
										                    $data = array( 'ncuser' => "$ncuser", 'cuser' => "$cuser");
										                    $STH = $mdb->prepare("UPDATE users SET username=:ncuser WHERE username=:cuser");
										                    $STH->execute($data);
                                                            $STH->closeCursor();
									                    }
								                    }
								                    //remove ownership from current owner
								                    $nowner=$nseluser."_".$owner;
								                    $sql="$call query_upd_users_dbowner(:nowner,:nseluser,:seluid,:oid)";
                                                    $db = $rdb->prepare($sql);
                                                    $db->bindValue(':nowner', $nowner);
                                                    $db->bindValue(':nseluser', $nseluser);
                                                    $db->bindValue(':seluid', $seluid);
                                                    $db->bindValue(':oid', $oid);
                                                    $db->execute();
                                                    $err=$rdb->errorInfo();
                                                    $db->closeCursor();                                                    
                                                    
								                    $data = array( 'nowner' => "$nseluser", 'owner' => "$owner");
								                    $STH = $mdb->prepare("UPDATE users SET username=:nowner WHERE username=:owner");
								                    $STH->execute($data);
                                                    $STH->closeCursor();
                                                    
								                    echo "<script type='text/javascript'>
                                                        $('.message_box').addClass('ok');
                                                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Ownership transferred');
                                                        $('.message_box').show();
                                                    </script>";
							                    }
							                    if (isset($seluid)) {
								                    for ($lt = 0; $lt < $numu; $lt++) {
									                    if ($seluid==$rsusers[$lt][0]) {
										                    $seluser=$rsusers[$lt][1];
										                    $pos=strpos($seluser,'_');
										                    if ($pos>=0) {
											                    if (substr($seluser,0,$pos)==$owner) {
												                    $sdbuser=substr($seluser,$pos + 1);
											                    }
										                    }
										                    print("<option value=$seluid SELECTED>$sdbuser</option>");
									                    }
								                    }
							                    } else {
								                    print("<option value=''></option>");
							                    }
							                    for ($lt = 0; $lt < $numu; $lt++) {
								                    $userid = $rsusers[$lt][0];
								                    $dbuser = $rsusers[$lt][1];
								                    if (isset($seluser) && $seluser!=$dbuser) {
									                    $pos=strpos($dbuser,'_');
									                    if ($pos>=0) {
										                    if (substr($dbuser,0,$pos)==$owner) {
											                    $sdbuser=substr($dbuser,$pos + 1);
										                    }
									                    }
									                    print("<option value=$userid>$sdbuser</option>");
								                    }
							                    }
							                    echo '</select>';
						                    ?>
					                    </div>
				                    </div>
			                    </div>
			                    <div>
				                    <div>
					                    <div>
						                    <br>
						                    <input class="btn" type="submit" value="Transfer" name="submit">
						                    <br>
						                    <span id="msgbox" style="display: none"></span>
					                    </div>
				                    </div>
			                    </div>
                            </div>
                        <?php
                            require_once('includes/bottom.php');
                        ?>

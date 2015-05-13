<?php
        require_once('includes/top.php');
?>
        <title>Manage users</title>
        <meta name="description" content="Administrator can modify or delete users here">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/my.table.js"></script>
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
        if($client=='wrm') {
		    $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);
        }
		if (isset($status) && $status=='suspended') {
			echo "<script type='text/javascript'>
                $('.message_box').removeClass('ok');
                $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                $('.message_box').show();
            </script>";
		}
		if (isset($_POST['save']) && $_POST['save']=='Update') {
            echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('Saving updates...');
                $('.message_box').show();
            </script>";
			foreach($_POST['first'] as $key => $var) {
			        $username=$_POST['username'][$key];
                    if($client=='wrm') {
				        $sql="UPDATE users SET fname = '$var' WHERE username='$username'";
                        $rs = $mdb->prepare($sql);
                        $rs->execute();
                        $err=$mdb->errorInfo();
                        $rs->closeCursor();
                    } else {
                        $sql="UPDATE owner SET fname = '$var' WHERE owner='$username'";
                        $rs = $rdb->prepare($sql);
                        $rs->execute();
                        $err=$rdb->errorInfo();
                        $rs->closeCursor();
                    }
			}
			foreach($_POST['last'] as $key => $var) {
			        $username=$_POST['username'][$key];
                    if($client=='wrm') {
				        $sql="UPDATE users SET lname = '$var' WHERE username='$username'";
                        $rs = $mdb->prepare($sql);
                        $rs->execute();
                        $err=$mdb->errorInfo();
                        $rs->closeCursor();
                    } else {
                        $sql="UPDATE owner SET lname = '$var' WHERE owner='$username'";
                        $rs = $rdb->prepare($sql);
                        $rs->execute();
                        $err=$rdb->errorInfo();
                        $rs->closeCursor();
                    }
			}
			foreach($_POST['email'] as $key => $var) {
			        $username=$_POST['username'][$key];
                    if($client=='wrm') {
				        $sql="UPDATE users SET email = '$var' WHERE username='$username'";
                        $rs = $mdb->prepare($sql);
                        $rs->execute();
                        $err=$mdb->errorInfo();
                        $rs->closeCursor();
                    } else {
                        $sql="UPDATE owner SET email = '$var' WHERE owner='$username'";
                        $rs = $rdb->prepare($sql);
                        $rs->execute();
                        $err=$rdb->errorInfo();
                        $rs->closeCursor();
                    }
			}
            if($client=='wrm') {
			    $sql="$call query_upd_user_admin(:oid)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':oid', $oid);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
                
                $sql="$call query_upd_user_guest(:oid)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':oid', $oid);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
            } else {
                $sql="$call query_upd_user_admin()";
                $rs = $rdb->prepare($sql);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
                
                $sql="$call query_upd_user_guest()";
                $rs = $rdb->prepare($sql);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
            }
            
            
			if(isset($_POST['dbox']) && sizeof($_POST['dbox'])) {//means if at least one check box is selected
				foreach($_POST['dbox'] as $var) {
					$sql="$call query_delete_user(:var)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':var', $var);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor();
                    if($client=='wrm') {
                       $sql="DELETE FROM users WHERE username=:var";
                       $rs = $mdb->prepare($sql);
                       $rs->bindValue(':var', $var);
                       $rs->execute();
                       $err=$mdb->errorInfo();
                       $rs->closeCursor(); 
                    }
					
				}
			}
			if(isset($_POST['abox']) && sizeof($_POST['abox'])) {//means if at least one check box is selected
				foreach($_POST['abox'] as $var) {
					$sql="$call query_update_owner_admin(:var)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':var', $var);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor();
				}
			}
            if(isset($_POST['gbox']) && sizeof($_POST['gbox'])) {//means if at least one check box is selected
                foreach($_POST['gbox'] as $var) {
                    $sql="$call query_update_owner_guest(:var)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':var', $var);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor();
                }
            }
            echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Updates saved');
                $('.message_box').show();
            </script>";
		}
        if($client=='wrm') {
		    $str = $owner."%";
		    $STH = $mdb->prepare("SELECT username, fname, lname, email, signup_date from users WHERE username like :str ORDER by username");
		    $STH->bindValue (':str', $str);
		    $STH->execute();
            $err=$mdb->errorInfo();
		    $totusers = $STH->rowCount();
            $rs = $STH->fetchAll(PDO::FETCH_BOTH);
            $STH->closeCursor();
        } else {
            $STH = $rdb->prepare("SELECT owner, fname, lname, email, regdate from owner ORDER by owner");
            $STH->execute();
            $err=$rdb->errorInfo();
            $totusers = $STH->rowCount();
            $rs = $STH->fetchAll(PDO::FETCH_BOTH);
            $STH->closeCursor();
        }
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>manage <strong>users</strong></h3>
				            <?php print("Total users $totusers"); ?><br><br>
				            <strong>Please check users selected for deletion carefully as there will be no confirmation message, and any recipes they own will also be removed. If you wish to retain their recipes then reassign them to another owner on the <a href='recipeownermgmt.php'>Manage Recipe Owners</a> page first</strong><br><br>
				            <form name='form1' method=post enctype='multipart/form-data'>
					            <INPUT type=submit id=submit name=save value=Update class=btn>
                                <div id=wt>
					                <table id=usermaint class='widetablesorter' cellspacing=1 cellpadding=0>
						                <thead class='userhead navbar-default'>
							                <tr>
								                <th>User</th>
								                <th>First Name</th>
								                <th>Surname</th>
								                <th>Email</th>
								                <th>Joined</th>
								                <th>Last Login</th>
								                <th>Admin</th>
                                                <th>Guest</th>
								                <th>Delete</th>
							                </tr>
						                </thead>
						                <tbody class=userbody>
							                <?php
								                foreach($rs as $row) {
									                $sql="$call query_user_extra_details(:user)";
                                                    $userdetails = $rdb->prepare($sql);
                                                    $userdetails->bindValue(':user', $row[0]);
                                                    $userdetails->execute();
                                                    $err=$rdb->errorInfo();

                                                    $rsdetails = $userdetails->fetch(PDO::FETCH_BOTH);
                                                    $userdetails->closeCursor();
                                                    
									                $llogin=$rsdetails[0];
									                $isadmin=$rsdetails[1];
									                $userid=$rsdetails[2];
                                                    $isguest=$rsdetails[3];
                                                    
									                $pos = strpos($row[0], "_");
									                if ($pos>-1) {
										                $duser = substr($row[0],$pos+1);
									                } else {
										                $duser= $row[0];
									                }
									                if (isset($isadmin) && $isadmin) {
										                $row[7]="<INPUT class=form-control name=abox[] class=chk type=checkbox checked value=$userid>";
									                } else {
										                $row[7]="<INPUT class=form-control name=abox[] class=chk type=checkbox value=$userid>";
									                }
                                                    if (isset($isguest) && $isguest) {
                                                        $row[8]="<INPUT class=form-control name=gbox[] class=chk type=checkbox checked value=$userid>";
                                                    } else {
                                                        $row[8]="<INPUT class=form-control name=gbox[] class=chk type=checkbox value=$userid>";
                                                    }
									                if ($row[4]) {
                                                        if($client=='wrm') {
                                                            if (isset($seldate)) {
                                                                if ($seldate==0) {
                                                                    $row[5] = date("d/m/Y", $row[4]);
                                                                } else {
                                                                    $row[5] = date("m/d/Y", $row[4]);
                                                                }
                                                            } else {
                                                                $row[5] = date("m-d-Y", $row[4]);
                                                            }
                                                        } else {
                                                            if (isset($seldate)) {
                                                                if ($seldate==0) {
                                                                    $row[5] = date("d/m/Y", strtotime($row[4]));
                                                                } else {
                                                                    $row[5] = date("m/d/Y", strtotime($row[4]));
                                                                }
                                                            } else {
                                                                $row[5] = date("m-d-Y", strtotime($row[4]));
                                                            }
                                                        }
                                                    }
									                if (isset($llogin)) {
										                if (isset($seldate)) {
                                                            if ($seldate==0) {
                                                                $row[6] = date("d/m/Y", strtotime($llogin));
                                                            } else {
                                                                $row[6] = date("m/d/Y", strtotime($llogin));
                                                            }
                                                        } else {
                                                            $row[6] = date("m-d-Y", strtotime($llogin));
                                                        }
									                }
									                print("
									                <tr>
										                <td>
											                $duser
											                <INPUT class=form-control name=username[] type=hidden value=".$row[0].">
										                </td>
										                <td>
											                <INPUT class=form-control name=first[] type=text value=".$row[1].">
											                
										                </td>
										                <td>
											                <INPUT class=form-control name=last[] type=text value=");
                                                            if(isset($row[2])) {
                                                                echo $row[2];
                                                            }
                                                        print(">
										                </td>
										                <td>
											                <INPUT class=form-control name=email[] type=text value=".$row[3].">
										                </td>
										                <td>");
                                                            if(isset($row[5])) {
											                    echo $row[5];
                                                            }
                                                        
										                print("</td>
										                <td>");
											                if(isset($row[6])) {
                                                                echo $row[6];
                                                            }
										                print("</td>
										                <td>
											                $row[7]
										                </td>
                                                        <td>
                                                            $row[8]
                                                        </td>
										                <td>
											                <INPUT class=form-control name=dbox[] class=chk type=checkbox value=$row[0]>
										                </td>
									                </tr>
									                ");
								                }
						                
							                ?>
						                </tbody>
					                </table>
                                </div>
					            <strong>Tip: </strong>Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header!<br><br>
					            <?php print("Total users $totusers"); ?>
					            <br><br><INPUT type=submit id=submit name=save value=Update class=btn>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
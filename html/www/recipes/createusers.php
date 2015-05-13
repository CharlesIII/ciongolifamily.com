<?php
    require_once('includes/top.php');
        
	$limit=$_SESSION[$client.'limit'];
?>
        <title>Create users</title>
        <meta name="description" content="Administrators can create users here">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/my.table.js"></script>
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
        if($client=='wrm') {
            $status=$_SESSION[$client.'status'];
            if ($status=='inactive' || $status=='suspended') {
                if ($status=='inactive') {
                    $msg='You must purchase a subscription to be able to add more users.';
                    echo "<script type='text/javascript'>
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                            $('.message_box').show();
                        </script>";
                } else if ($status=='suspended') {
                    $msg='You must renew your subscription to be able to add more users.';
                    echo "<script type='text/javascript'>
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                            $('.message_box').show();
                        </script>";
                }
                echo "<script language='javascript'>";
                echo "$(document).ready(function() {
                        $('input').each(function() {
                            $(this).attr('disabled', 'disabled');
                        });
                    });
                    </script>";

            }
		    $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);
        }
		if (isset($_POST['save']) && $_POST['save']=='Create') {
            echo "<script type='text/javascript'>
                    $('.message_box').addClass('ok');
                    $('.message_box').html('Creating Users...');
                    $('.message_box').show();
                </script>";
            $msg=null;
            $nousers=0;
            $nopass=0;
            $nofirst=0;
            $noemail=0;
			foreach ($_POST['user'] as $var) {
				if ($var!='') {
					$nousers++;
				}
			}
			$totusers=$nousers+$users;
			if ($totusers>$limit && $limit!='unlimited') {
				$msg='Adding these users will take you over your user limit';
				echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                    $('.message_box').show();
                </script>";
			} else {
				foreach ($_POST['password'] as $pvar) {
					if ($pvar!='') {
						$nopass++;
					}
				}
				foreach ($_POST['first'] as $fvar) {
					if ($fvar!='') {
						$nofirst++;
					}
				}
				foreach ($_POST['email'] as $evar) {
					if ($evar!='') {
						$noemail++;
					}
				}
				if ($nousers!=$nopass) {
					$msg='Password is a required field...';
					echo "<script type='text/javascript'>
                        $('.message_box').removeClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                        $('.message_box').show();
                    </script>";
				} else if ($nousers!=$nofirst) {
					$msg='First Name is a required field...';
                    echo "<script type='text/javascript'>
                        $('.message_box').removeClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                        $('.message_box').show();
                    </script>";
				} else if ($nousers!=$noemail) {
					$msg='Email is a required field...';
					echo "<script type='text/javascript'>
                        $('.message_box').removeClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                        $('.message_box').show();
                    </script>";
				} else if(isset($nousers)) {//means if at least one user is entered
					for ($lt=0;$lt<$nousers;$lt++) {
                        if($client=='wrm') {
                           $sql="$call query_owner_ids('".$owner."_".$_POST['user'][$lt]."')"; 
                        } else {
                            $sql="$call query_owner_ids('".$_POST['user'][$lt]."')";
                        }
                        $rsuid = $rdb->prepare($sql);
                        $rsuid->execute();
                        $err=$rdb->errorInfo();
                        $rsrows = $rsuid->rowCount();
                        $rsuid->closeCursor();
						
                        if ($rsrows>0) {
							$msg .= $_POST['user'][$lt].' already exists<br>';
						}
                        if($client=='wrm') {
                            $sql = "SELECT id FROM users WHERE email = :email";
                            $rsemail = $mdb->prepare($sql);
                            $rsemail->bindValue(':email',$_POST['email'][$lt]);
                            $rsemail->execute();
                            $err=$rdb->errorInfo();
                            $erows = $rsemail->rowCount();
                            $rsemail->closeCursor();
                            if ($erows>0) {
                               $msg .= $_POST['email'][$lt].' is already in use<br>';
                            }
                        } else {
                            $sql = "$call query_email_in_use(:email)";
                            $rsemail = $rdb->prepare($sql);
                            $rsemail->bindValue(':email',$_POST['email'][$lt]);
                            $rsemail->execute();
$err=$rdb->errorInfo();
                            $erows = $rsemail->rowCount();
                            $rsemail->closeCursor();
                            if ($erows>0) {
                               $msg .= $_POST['email'][$lt].' is already in use<br>';
                            }
                        }
					}
					if (isset($msg)) {
						echo "<script type='text/javascript'>
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                            $('.message_box').show();
                        </script>";
					} else {
						$date=date("Ymd");
						$time=time();
						$namearray = array();
						$emailarray = array();
						$userarray = array();
						$passarray = array();
	
						for ($lt=0;$lt<$nousers;$lt++) {
							if ($_POST['first'][$lt]) {
								$first = $_POST['first'][$lt];
								$namearray[]=$first;
							}
							if (isset($_POST['last'][$lt])) {
								$last = $_POST['last'][$lt];
							} else {
								$last=null;
							}
							if ($_POST['email'][$lt]) {
								$email = $_POST['email'][$lt];
								$emailarray[]=$email;
							}
							$userarray[]=$_POST['user'][$lt];
							$passarray[]=$_POST['password'][$lt];
                            if($client=='wrm') {
							    $newuser=$owner.'_'.$_POST['user'][$lt];
                                require_once('awbs/tools/importfunctions.php');
                                $password=create_encoded_password(md5($_POST['password'][$lt]));
                            } else {
                                $newuser=$_POST['user'][$lt];
                                require('includes/PasswordHash.php');
                                $hasher = new PasswordHash(8, true);
                                $password = $hasher->HashPassword($_POST['password'][$lt]);
                            }
							
	                        if($client=='wrm') {
							    // add user in awbs
							    $data = array( 'username' => "$newuser", 'first' => "$first", 'last' => "$last", 'password' => "$password", 'email' => "$email", 'time' => "$time" );
							    $STH = $mdb->prepare("INSERT INTO users (username, fname, lname, password, email, signup_date, active, mail_type) values(:username, :first, :last, :password, :email, :time, 1, 2)");
							    $STH->execute($data);
                                $err=$mdb->errorInfo();
                                
                            }
	
							//add user in wrm
                            if($client=='wrm') {
							    $sql="$call query_add_user(:newuser, :owner, :oid, :date)";
                                $rsadd = $rdb->prepare($sql);
                                $rsadd->bindValue(':newuser',$newuser);
                                $rsadd->bindValue(':owner',$owner);
                                $rsadd->bindValue(':oid',$oid);
                                $rsadd->bindValue(':date',$date);
                                $rsadd->execute();
                                $err=$rdb->errorInfo();
                                $rsadd->closeCursor();
                            } else {
                                if ($dbsql=='mysql') {
                                        $sql="INSERT INTO owner( owner, fname, lname, password , email, regdate, approved) VALUES (:user, :fname, :lname, :pass, :email, now(), 1)";
                                        $rsadd = $rdb->prepare($sql);
                                        $rsadd->bindValue(':user',$newuser);
                                        $rsadd->bindValue(':fname',$first);
                                        $rsadd->bindValue(':lname',$last);
                                        $rsadd->bindValue(':pass',$password);
                                        $rsadd->bindValue(':email',$email);
                                        $rsadd->execute();
                                        $err=$rdb->errorInfo();
                                        $rsadd->closeCursor();
                                } else {
                                      $sql = "$call query_add_user(:user,:fname,:lname,:pass,:email,:date)";
                                      $rsadd = $rdb->prepare($sql);
                                      $rsadd->bindValue(':user',$newuser);
                                      $rsadd->bindValue(':fname',$first);
                                      if(isset($last) and $last!='') {
                                        $rsadd->bindValue(':lname',$last);
                                      } else {
                                        $rsadd->bindValue(':lname',NULL);  
                                      }               
                                      $rsadd->bindValue(':pass',$password);
                                      $rsadd->bindValue(':email',$email);
                                      $rsadd->bindValue(':date',$date);
                                      $rsadd->execute();
                                      $err=$rdb->errorInfo();
                                      $rsadd->closeCursor();
                                      
                                      $sql="$call query_approve_user(:user)";
                                      $rs = $rdb->prepare($sql);
                                      $rs->bindValue(':user', $newuser);
                                      $rs->execute();
                                      $err=$rdb->errorInfo();
                                      $rs->closeCursor();
                                }
                            }
							if(isset($_POST['abox'][$lt])) {//means if admin is checked
								$sql="$call query_upd_owner_admin(:newuser)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':newuser',$newuser);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}
                            if(isset($_POST['gbox'][$lt])) {//means if guest is checked
                                $sql="$call query_upd_owner_guest(:newuser)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':newuser',$newuser);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            }
							
						}
						foreach ($emailarray as $key => $val) {
							$val=trim($val);
                            if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $val)) {
								if (!isset($emsg)) {
								       $emsg = "The following email addresses are invalid:<br><br>$val";
								} else {
								       $emsg .= '<br>'.$val;
								}
							} else {
								require_once 'includes/swift/lib/swift_required.php';
							
								$starpath='images/';
                                if ($eauthreq=='yes') {
                                      $transport = Swift_SmtpTransport::newInstance("$eserver","$eport")
                                      ->setusername($euser)
                                      ->setPassword($epass);
                                } else {
                                      $transport = Swift_SmtpTransport::newInstance("$eserver","$eport");
                                }
								$mailer = Swift_Mailer::newInstance($transport);
								$message = Swift_Message::newInstance();
								$message->setSubject("$clientname Login Details");
								
                                if($client=='wrm'){
								    $STH = $mdb->prepare("SELECT email, fname, lname FROM users WHERE username = '$owner'");
								    $STH -> execute();
                                    $err=$mdb->errorInfo();
								    $result = $STH -> fetch();
								    $from = $result['email'];
								    $name = $result['fname']." ".$result['lname'];
                                } else {
                                    if($dbsql=='mysql') {
                                        $STH = $rdb->prepare("SELECT email, fname, lname FROM owner WHERE BINARY owner = '$user'");
                                    } else {
                                        $STH = $rdb->prepare("SELECT email, fname, lname FROM owner WHERE owner = '$user'");
                                    }
                                    $STH -> execute();
                                    $err=$rdb->errorInfo();
                                    $result = $STH -> fetch();
                                    $from = $result['email'];
                                    $name = $result['fname']." ".$result['lname'];
                                }
								
								require('includes/email-header.php');
								$body .= "<br><h2 style='font-size:18px;'>Web Recipe Manager Login Details</h2>";
								$body .= "<b>User</b>&nbsp&nbsp $userarray[$key]<br>";
								$body .= "<b>Password</b>&nbsp&nbsp $passarray[$key]<br>";
								$body .= "<br>You can log in here <a href=$emailurl>$clientname</a>";
                                $body .= "<br><br>We suggest you reset your password as soon as possible</a>";
								$body .= "<br><br>Regards,<br>$name<br><br>";
								require('includes/email-footer.php');
								
								$message->setBody(
									'<html>' .
									' <head></head>' .
									' <body>' .
									$body .
									' </body>' .
									'</html>',
									  'text/html'
								);
								$message->addTo($val, $namearray[$key]);
								$message->setFrom(array($from => $name));
								if ($mailer->send($message)){
									if (!isset($sentmsg)) {
										$sentmsg = "Login details were sent to the following users:<br><br>$userarray[$key]";
									} else {
										$sentmsg .= '<br>'.$userarray[$key];
									}
								}
							}
						}
							
						$msg = 'Users created';
                        if (isset($emsg)) {
                            $msg .= "<br><br>$emsg";
                        }
                        if (isset($sentmsg)) {
                            $msg .= "<br><br>$sentmsg";
                        }	
						echo "<script type='text/javascript'>
                            $('.message_box').addClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                            $('.message_box').show();
                        </script>";
					}
				}
			}
		}
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>create <strong>users</strong></h3>
				            <strong>Fields marked with an * are required.</strong><br><br>
				            <form method=post enctype='multipart/form-data'">
					            <INPUT type=submit id=submit name=save value=Create class=btn>
                                <div id=wt>
					                <table id=usermaint class='widetablesorter' cellspacing=1 cellpadding=0>
						                <thead class='userhead navbar-default'>
							                <tr>
								                <th>User *</th>
								                <th>Password *</th>
								                <th>First Name *</th>
								                <th>Surname</th>
								                <th>Email *</th>
								                <th>Admin</th>
                                                <th>Guest</th>
							                </tr>
						                </thead>
						                <tbody class=userbody>
							                <?php
								                for ($lt=0;$lt<21;$lt++) {
									                print("
									                <tr class=dataline>
										                <td  width=110>
											                <INPUT class=form-control name=user[$lt] type=text class=input_1 value=");
                                                            if(isset($_POST['user'][$lt])) {
                                                                echo $_POST['user'][$lt];
                                                            }
                                                            print(">
										                </td>
										                <td  width=110>
											                <INPUT class=form-control name=password[$lt] type=text class=input_1 value=");
                                                            if(isset($_POST['password'][$lt])) {
                                                                echo $_POST['password'][$lt];
                                                            }
                                                            print(">
										                </td>
										                <td  width=110>
											                <INPUT class=form-control name=first[$lt] type=text class=input_1 value=");
                                                            if(isset($_POST['first'][$lt])) {
                                                                echo $_POST['first'][$lt];
                                                            }
                                                            print(">
										                </td>
										                <td  width=110>
											                <INPUT class=form-control name=last[$lt] type=text class=input_1 value=");
                                                            if(isset($_POST['last'][$lt])) {
                                                                echo $_POST['last'][$lt];
                                                            }
                                                            print(">
										                </td>
										                <td  width=110>
											                <INPUT class=form-control name=email[$lt] type=text value=");
                                                            if(isset($_POST['email'][$lt])) {
                                                                echo $_POST['email'][$lt];
                                                            }
                                                            print(">
										                </td>
										                <td   width=20>");
										                if (isset($_POST['abox'][$lt]) && $_POST['abox'][$lt]) {
											                print("<INPUT class=form-control name=abox[$lt] type=checkbox id=admin checked=checked>");
										                } else {
											                print("<INPUT class=form-control name=abox[$lt] type=checkbox id=admin>");
										                }
										                print("</td>
                                                        <td   width=20>");
                                                        if (isset($_POST['gbox'][$lt]) && $_POST['gbox'][$lt]) {
                                                            print("<INPUT class=form-control name=gbox[$lt] type=checkbox id=guest checked=checked>");
                                                        } else {
                                                            print("<INPUT class=form-control name=gbox[$lt] type=checkbox id=guest>");
                                                        }
                                                        print("</td>
									                </tr>
									                ");
								                }
							                ?>
						                </tbody>
					                </table>
                                </div>
					            <strong>Tip: </strong>Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header!<br><br>
					            <INPUT type=submit id=submit name=save value=Create class=btn>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
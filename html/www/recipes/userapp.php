<?php
	require_once('includes/top.php');
?>
    <title>User Approval</title>
    <meta name="description" content="Approve self registered users.">
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
		    if(isset($_POST['abox']) && sizeof($_POST['abox'])) {//means if at least one check box is selected
			    foreach($_POST['abox'] as $key => $var) {
				    $sql="$call query_approve_user(:var)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':var', $var);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor();
				    
				    $email = $_POST['email'][$key];
				    $fname = $_POST['fname'][$key];
				    $lname = $_POST['lname'][$key];
                    $toname = $_POST['fname'][$key]." ".$_POST['lname'][$key];
				    
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
                    $message->setSubject("Web Recipe Manager Account Information");
				      
				    #produce message in html format
                    require_once('includes/email-header.php');
				    $body .= "<br>Hi $fname,<br><br>Your account at My Web Recipe Manager has now been approved.<br><br>";
                    $body .= "<br>You can log in here <a href=$emailurl>$clientname</a> using the user and password you entered when registering.";
				    $body .= "<br><br>Regards,<br>Web Recipe Manager Admin.";
                    require_once('includes/email-footer.php');
					      
                    $message->setBody(
                        '<html>' .
                        ' <head></head>' .
                        ' <body>' .
                        $body .
                        ' </body>' .
                        '</html>',
                          'text/html'
                    );
                    $message->addTo($email, $toname);
                    $message->setFrom($csuppemail, $emailfrom);
                    if ($mailer->send($message)){
                        if (!isset($sentmsg)) {
                            $sentmsg = "Login details were sent to the following users:<br><br>$var";
                        } else {
                            $sentmsg .= '<br>'.$var;
                        }
                    }
			    }
		    }
		    if(isset($_POST['dbox']) && sizeof($_POST['dbox'])) {//means if at least one check box is selected
			    foreach($_POST['dbox'] as $var) {
				    $sql="$call query_delete_user(:var)";
                    $rs = $rdb->prepare($sql);
                    $rs->bindValue(':var', $var);
                    $rs->execute();
                    $err=$rdb->errorInfo();
                    $rs->closeCursor();
			    }
		    }
            $msg = 'Updates saved';
            if (isset($sentmsg)) {
                $msg .= "<br><br>$sentmsg";
            }
		    echo "<script type='text/javascript'>
            $('.message_box').addClass('ok');
            $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>$msg');
            $('.message_box').show();
            </script>";
	    }
	    
	    $sql="$call query_unapproved_users()";
	    $result = $rdb->prepare($sql);
        $result->execute();
        $err=$rdb->errorInfo();
	    $totusers=$result->rowCount();
        $rsresult = $result->fetchAll(PDO::FETCH_BOTH);
        $result->closeCursor();
    ?>
    <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
                            <h3>approve <strong>users</strong></h3>
                            <?php print("Unapproved Users $totusers"); ?><br><br>
                            <form method=post enctype='multipart/form-data'">
	                            <INPUT type=submit id=submit name=save value=Update class=btn>
	                            <table id=usermaint class=tablesorter cellspacing=1 cellpadding=0>
		                            <thead class='userhead navbar-default'>
			                            <tr>
				                            <th>User Name</th>
				                            <th>First Name</th>
				                            <th>Surname</th>
				                            <th>Email Address</th>
				                            <th>Joined</th>
				                            <th>Approve</th>
				                            <th>Delete</th>
			                            </tr>
		                            </thead>
		                            <tbody class=userbody>
	                            <?php
		                            $lt=-1;
		                            foreach($rsresult as $row) {
			                            $lt++;
			                            if ($row[4]) {
				                            if (isset($seldate)) {
                                                if ($seldate==0) {
                                                    $row[4] = date("d/m/Y", strtotime($row[4]));
                                                } else {
                                                    $row[4] = date("d-m-Y", strtotime($row[4]));
                                                }
                                            } else {
                                                $row[4] = date("d-m-Y", strtotime($row[4]));
                                            }
			                            }
			                            Print("
			                            <tr>
				                            <td>
					                            $row[0]
				                            </td>
				                            <td>
					                            $row[1]
					                            <INPUT name=fname[$lt] type=hidden value=$row[1]>
				                            </td>
				                            <td>
					                            $row[2]
					                            <INPUT name=lname[$lt] type=hidden value=$row[2]>
				                            </td>
				                            <td>
					                            $row[3]
					                            <INPUT name=email[$lt] type=hidden value=$row[3]>
				                            </td>
				                            <td>
					                            $row[4]
				                            </td>
				                            <td>
					                            <INPUT name=abox[] class=chk type=checkbox value=$row[0]>
				                            </td>
				                            <td>
					                            <INPUT name=dbox[] class=chk type=checkbox value=$row[0]>
				                            </td>
			                            </tr>
			                            ");
		                            }
		                            
	                            ?>
		                            </tbody>
	                            </table>
	                            <strong>Tip: </strong>Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header!<br><br>
	                            <?php print("Unapproved Users $totusers"); ?>
	                            <br><br><INPUT type=submit id=submit name=save value=Update class=btn>
                            </form>
                        </div>
                        <?php
                            require_once('includes/bottom.php');
                        ?>	
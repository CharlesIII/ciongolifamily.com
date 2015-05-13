<?php
	require_once('includes/top.php');
    if(isset($_GET['action'])) {
        $action=$_GET['action'];
    }
?>
<title>Update My Profile</title>
<meta name="description" content="Update your name or email address or reset your password.">
</head>
<body>
<?php
	require_once('includes/banner.php');
	
	$sql="$call query_owner(:uid)";
    $result = $rdb->prepare($sql);
    $result->bindValue(':uid', $uid);
    $result->execute();
$err=$rdb->errorInfo();
    $rsresult = $result->fetch(PDO::FETCH_BOTH);
    $result->closeCursor();
	
	$selemail=$rsresult[0];
	$selfname=$rsresult[1];
	$sellname=$rsresult[2];
?>
<div id="sb-site" class="sb-slide">
    <div class=container>
        <div class="row">
            <!-- content start -->
            <div class="col-xs-12 col-sm-12">
                <?php
                if (isset($action)) {
                    print("<h3>Change my <strong>Password</strong></h3>");
                } else {
                    print("<h3>Update my <strong>Profile</strong></h3>");
                }
                ?>
                <form name=enq method="post" id="support_form" action="" class="form-horizontal top-margin" role="form">
                    <div>
                           <div class="success" style="display:none;">
                                       <div class="success_txt">
                                            <?php
                                                if(isset($action)) {
                                                    echo'<strong>Changing your password...</strong>';
                                                } else {
                                                    echo'<strong>Updating your profile...</strong>';
                                                }
                                            ?>                                               
                                       </div>
                           </div>
                           <div id="contact-fname" class="form-group">
                                       <div class="col-xs-12">
                                                <?php
                                                    if (!isset($action)) {
                                                        if (isset($_POST['fname'])) {
                                                            echo "<input id='input-fname' name='fname' type='text' class='form-control' value='".$_POST['fname']."'>";
                                                        } else if (isset($selfname)) {
                                                            print("<input id='input-fname' name='fname' type='text' class='form-control' value='$selfname'>");
                                                        } else {
                                                            echo '<input id="input-fname" name="fname" type="text" class="form-control" placeholder="Your First Name">';
                                                        }
                                                    }
                                                ?>
                                       </div>
                           </div>
                           <div id="contact-lname" class="form-group">
                                       <div class="col-xs-12">
                                               <?php
                                                    if (!isset($action)) {
                                                        if (isset($_POST['lname'])) {
                                                            echo "<input id='input-lname' name='lname' type='text' class='form-control' value='".$_POST['lname']."'>";
                                                        } else if (isset($sellname)) {
                                                            print("<input id='input-lname' name='lname' type='text' class='form-control' value='$sellname'>");
                                                        } else {
                                                            echo '<input id="input-lname" name="lname" type="text" class="form-control" placeholder="Your Last Name">';
                                                        }
                                                    }
                                                ?>
                                       </div>
                           </div>
                           <?php
                               if (isset($action)) {
                                   echo '
                                   <div id="contact-pword" class="form-group">
                                               <div class="col-xs-12">
                                                       <input id="input-pword" name="pword" type="password" class="form-control" placeholder="Your New Password">
                                               </div>
                                   </div>
                                   <div id="contact-cpword" class="form-group">
                                               <div class="col-xs-12">
                                                       <input id="input-cpword" name="cpword" type="password" class="form-control" placeholder="Confirm Your New Password">
                                               </div>
                                   </div>';
                               }
                           ?>
                           <div id="contact-email" class="form-group">
                                       <div class="col-xs-12">
                                            <?php
                                                if (!isset($action)) {
                                                    if (isset($_POST['email'])) {
                                                        echo '<input id="input-email" name="email" class="form-control" value="',ltrim($_POST['email']),'">';
                                                    } else if (isset($selemail)) {
                                                        echo '<input id="input-email" name="email" class="form-control" value="',ltrim($selemail),'">';
                                                    } else {
                                                        echo '<input id="input-email" name="email" class="form-control" placeholder="Your Email">';
                                                    }
                                                }
                                            ?>
                                               
                                       </div>
                           </div>
                           <div class="form-group">
                                       <div class="col-xs-12">
                                               <button id=submit name="submit" type="submit" class="btn btn-default">Update</button>
                                       </div>
                           </div>
                    </div>
                    <input type=hidden id=action value=<?php if(isset($action)) {echo $action;} ?>>
               </form>
	        </div>
            <?php
                require_once('includes/bottom.php');
            ?>

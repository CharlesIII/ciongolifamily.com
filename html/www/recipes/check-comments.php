<?php
        require_once('includes/top.php');
        
?>
        <title>Check Comments</title>
        <meta name="description" content="Administrator can delete or approve comments here">
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
        $msg=null;
		if(isset($_POST['abox']) && sizeof($_POST['abox'])) {//means if at least one check box is selected
            echo "<script type='text/javascript'>
                $('.message_box').addClass('ok');
                $('.message_box').html('Approving comments...');
                $('.message_box').show();
            </script>";
			foreach($_POST['abox'] as $var) {
				$sql="$call query_comment_checked(:var)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':var', $var);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
			}
		}
		if (isset($_POST['abox']) && sizeof($_POST['abox'])==1) {
			$msg .= sizeof($_POST['abox']).' Comment Approved';
		} else if (isset($_POST['abox']) && sizeof($_POST['abox'])) {
			$msg .= sizeof($_POST['abox']).' Comments Approved';
		}
		if(isset($_POST['cbox']) && sizeof($_POST['cbox'])) {//means if at least one check box is selected
			foreach($_POST['cbox'] as $var) {
				$sql="$call query_delete_comment(:var)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':var', $var);
                $rs->execute();
                $err=$rdb->errorInfo();
                $rs->closeCursor();
			}
		}
		if (isset($_POST['cbox']) && sizeof($_POST['cbox'])==1) {
			if (sizeof($_POST['abox'])) {
				$msg .= '<br>';
			}
			$msg .= sizeof($_POST['cbox']).' Comment Deleted';
		} else if (isset($_POST['cbox']) && sizeof($_POST['cbox'])) {
			if (isset($_POST['abox']) && sizeof($_POST['abox'])) {
				$msg .= '<br>';
			}
			$msg .= sizeof($_POST['cbox']).' Comments Deleted';
		}
		if(isset($_POST['ecbox']) && sizeof($_POST['ecbox'])) {//means if at least one check box is selected
			foreach($_POST['ecbox'] as $var) {
				$poster=$var;
				require("includes/warningemail.php");
			}
		}
		if(isset($good)) {
			if (isset($_POST['cbox']) && sizeof($_POST['cbox']) || sizeof($_POST['abox'])) {
				$msg .= '<br>';
			}
			if ($good==1) {
				$msg .= $good.' Warning Email Sent';
			} else {
				$msg .= $good.' Warning Emails Sent';
			}
		}
		if(isset($bad)) {
			if (isset($_POST['cbox']) && sizeof($_POST['cbox']) || sizeof($_POST['abox'])) {
				$msg .= '<br>';
			}
			if ($bad==1) {
				$msg .= $bad.' Warning Email Failed To Send';
			} else {
				$msg .= $bad.' Warning Emails Failed To Send';
			}
		}
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3>check <strong>comments</strong></h3>
				            <form method=post enctype='multipart/form-data'">
					            <?php
						            require_once('includes/comment.php');
						            if (isset($msg)) {
							            echo "<script type='text/javascript'>
                                            $('.message_box').addClass('ok');
                                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                                            $('.message_box').show();
                                        </script>";
						            }
                                    /*if(isset($id)) {
						                getComments($id,$uid,$client,$seldate,$call,$rdb);
                                    } else {*/
                                        getComments($uid,$client,$seldate,$call,$rdb);
                                    //}
					            ?>
				            </FORM>
			            
			<?php
				require_once('includes/bottom.php');
			?>
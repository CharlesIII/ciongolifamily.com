<?php
        require_once('includes/top.php');
?>
        <title>Upload images</title>
        <meta name="description" content="Upload images specified in any csv file to be imported prior to import.">
        <link rel="stylesheet" href="css/jquery.ui.plupload.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" />
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/plupload.full.min.js"></script>
		<script src="js/jquery.ui.plupload.min.js"></script>
		<script src="js/my.multi.image.upload.js"></script>
		<script src="js/my.back.from.info.js"></script>
		
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
				            <h3><strong>upload </strong>images prior to import</h3>
				            <br>
				            <form id="form" method="post" action="includes/import.php">
					            <div id="uploader">
						            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
					            </div>
					            <br>
					            <INPUT type=button class='back btn' value='Back To Import'>
					            <INPUT type=hidden id=client value='<?php echo $client ?>'>
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
                
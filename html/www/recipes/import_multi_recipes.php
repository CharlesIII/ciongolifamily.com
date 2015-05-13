<?php
        require_once('includes/top.php');
?>
        <title>Import recipes</title>
        <meta charset="utf-8">
        <meta name="description" content="Import multiple recipes in csv or mmf format.">
        <link rel="stylesheet" href="css/jquery.ui.plupload.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" />
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/plupload.full.min.js"></script>
		<script src="js/jquery.ui.plupload.min.js"></script>
		<script src="js/my.multi.import.js"></script>
		
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
		@set_time_limit(36000);
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
				            <h3><strong>import </strong>recipes</h3>
				            <br>
				            <strong>If you want any images, PDF documents or videos</strong> defined in your CSV file to be added to your recipes <a id=uploadlink class=link href="upload_multi_images.php">upload them </a> before you import. Check out the <a class=link href=import_format.php>required format for any CSV file</a> to be imported.
				            <br><br>
				            <form id="form" method="post" action="includes/import.php" accept-charset="utf-8">
					            <br>
				                <input type=checkbox class='chk css-checkbox' id=ow name=ow>
                                <label for=ow class=css-label> Overwite existing recipes with the same name</label>
					            <br>
					            <div id="uploader">
						            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
					            </div>
					            <br>
				                <input type=hidden id=rapp value='<?php echo $rapp?>' >
				                <input type=hidden id=admin value='<?php echo $admin?>' >
				            </form>
			            </div>
			            <?php
				            require_once('includes/bottom.php');
			            ?>
                
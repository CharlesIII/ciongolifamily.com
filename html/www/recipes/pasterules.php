<?php
        require_once('includes/top.php');
?>
        <title>Copy & Paste Recipe - Rules & Asssumptions</title>
        <meta name="description" content="Copy & Paste Recipe - Rules & Asssumptions.">
		<script src="js/my.back.from.info.js"></script>
		
</head>
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
				            <h3>copy & paste <strong>rules & asssumptions</strong></h3>
				            <br>
				            <INPUT type=button class='back btn' value='Back To Copy & Paste'>
				            <br><br>
				            <strong>General:</strong>
				            <br><br>
				            1) Any double quotes (") will be replaced by "inch".<br>
				            2) Any less than (<) or greater than (>) symbols will be replaced by "lt" or "gt".<br>
				            3) Any section titles (e.g. "Directions:") included in selections will be removed.<br>
				            <br><br>
				            <strong>Yield:</strong>
				            <br><br>
				            The following words will be removed from the selection:<br>
				            About
				            <br>Approximately (and it's common abbreviation)
				            <br><br>
				            Where a range is specified e.g. 4-6 servings, only the lower amount (4 in this example) will be used.<br>
				            <br><br>
				            <strong>Directions & Notes:</strong>
				            <br><br>
				            If there are more than one set of directions or notes (e.g. where there is a sauce recipe included within another recipe)<br>
				            they can all be selected separately. They will then be shown together in the recipe with a title to separate them.<br>
				            An attempt will be made to ascertain the titles from elsewhere in the recipe
				            <br><br>
				            <strong>Recipe Types & Categories:</strong>
				            <br><br>
				            Only the first 4 of each will be added.
				            <br><br>
				            <strong>Diet/s:</strong>
				            <br><br>
				            Only the first 5 will be added.
				            <br><br>
				            <strong>Ingredients:</strong>
				            <br><br>
				            1) There is allowance for up to 45 ingredients.<br>
				            2) Anything in brackets, containing numbers is assumed to be alternate amounts e.g. 250 g (1 cup) Flour<br>
				            3) Anything after a comma is assumed to be prepreparation steps or notes.<br>
				            4) If there is a quantity containing a range (i.e 4-6 Tomatoes), then only the lower amount will be used.<br>
				            This is required so that recipe resizing will work.
				            <br><br>
				            <strong>Rating:</strong>
				            <br><br>
				            The rating can be one of the following:
				            <br><br>
				            1 Star<br>
				            2 Stars<br>
				            3 Stars<br>
				            4 Stars<br>
				            5 Stars
				            <br><br>
				            <INPUT type=button class='back btn' value='Back To Copy & Paste'>
				            <INPUT type=hidden id=client value='<?php echo $client ?>'>
			            </div>
                            <?php
                                    require_once('includes/bottom.php');
                            ?>      
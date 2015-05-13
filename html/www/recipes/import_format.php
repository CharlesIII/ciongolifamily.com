<?php
        require_once('includes/top.php');
?>
        <title>CSV Import format</title>
        <meta name="description" content="Specification for csv files for import.">
		<script src="js/my.back.from.info.js"></script>
		
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
				            <h3><strong>csv import </strong>format</h3>
				            <br>
				            <INPUT type=button class='back btn' value='Back To Import'>
				            <br><br>
				            <strong>File Specification Notes:</strong>
				            Files in this format can be created in Microsoft Excel, by using 'Save as' and selecting 'CSV(Comma Delimited)(.csv)'. Any fields that contain a comma must be enlosed within double quotes ("). See Directions below.
				            <br><br>Any double quotes (") within values will be removed prior to import, try using the word inch/inches instead.<br><br>
				            The only required lines are Name, Category(at least one), Ingredient(at least one) and Directions.<br>
				            The other lines can be ommited if not required.<br><br>
				            You can include multiple Diets and Related Recipes on a single line (see below).<br><br>
				            A category line represents a category-subcategory pair. You may have a maximum of 4 of these. Only 2 are shown below<br><br>
				            Each ingredient has 7 possible values - quantity, unit, qty2, unit2  and ingredient name followed by up to 2 preparation steps/notes (i.e. chopped, diced).<br><br>
				            Rating can be either: 1 star, 2 stars, 3 stars, 4 stars or 5 stars
				            
				            <br><br>
				            <strong>File Specification: </strong>This is what a CSV file should look like<br><br>
				            Name:,Taco Soup
				            <br>Rating:,5 stars
				            <br>Image:,123462.jpg,image2.jpg
				            <br>PDF:,12345.pdf
				            <br>Measure:,Metric (AU)
				            <br>Note:,Great way to use up leftover taco meat
				            <br>Tried:,TRUE
				            <br>Preptime:,20mins
				            <br>Cooktime:,40mins
				            <br>Yield:,2
				            <br>Yield Unit:,Servings
				            <br>Cuisine:,Mexican
				            <br>Source:,My Invention
				            <br>Added:,2009-01-10
				            <br>Added By:,demo
				            <br>Last Modified:,2009-10-21
				            <br>Directions:,"Saute onion, garlic in oil.
				            <br>
				            <br>Add all other ingredients. Simmer 30mins.
				            <br>"
				            <br>Diet:,Low Carb,Low GI
				            <br>Related Recipe:,Taco Seasoning,Twice Cooked Potatoes
				            <br>Category:,Main Meal,Soup
				            <br>Category:,Main Meal,Beef
				            <br>Ingredient:,500,g,1,lb,Lamb Mince,Leftover From Tacos,
				            <br>Ingredient:,1,,,,Carrot,Grated,
				            <br>Ingredient:,1,,,,Onion,Chopped,
				            <br>Ingredient:,2,,,clove,Garlic,Sliced,
				            <br>Ingredient:,1,tb,,,Mint Leaves,Chopped,
				            <br>Ingredient:,1,,,,Beef Stock,,
				            <br>Ingredient:,1/4,c,,,Basmati Rice,,
				            <br>Ingredient:,1,tb,20,ml,Olive Oil,,
				            <br>Recipe End
				            <br><br>
				            <INPUT type=button class='back btn' value='Back To Import'>
				            <INPUT type=hidden id=client value='<?php echo $client ?>'>
			            </div>
                            <?php
                                    require_once('includes/bottom.php');
                            ?>
                
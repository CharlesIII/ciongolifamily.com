<?php
        require_once('includes/top.php');
?>
        <title>Copy & paste recipes</title>
        <meta name="description" content="Add recipes by copying and pasting.">
		<script src="js/my.paste.recipe.js"></script>
		<script src="js/jquery.a-tools-1.2.js"></script> 
		<script src="js/jquery-ui.min.js">
		</script><link rel="stylesheet" href="css/jquery-ui.css">
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
				<h3><strong>copy & paste </strong>new recipe</h3>
				<form action='add-recipe.php' method='post' name=form1 id=pasterecipe>
					<br>
					<div class=pr><input type=submit class=btn name="add" value="Add Recipe"></div>
					<br>
					<div id=paste>
						<div class=dib id=rparts>
							<strong>Recipe Sections:</strong>
                            <br><br>
							<div class=pdib>
								<input type=button id=prname class=btn value='Name'><br>
								<input type=button id=ping class=btn value=Ingredients><br>
								<input type=button id=pdirections class=btn value=Directions><br>
								<input type=button id=pyield class=btn value=Yield><br>
							</div>
							<div class=pdib>
								<input type=button id=pnote class=btn value=Notes><br>
								<input type=button id=pcuisine class=btn value=Cuisine><br>
								<input type=button id=pcooktime class=btn value='Cook Time'><br>
								<input type=button id=ppreptime class=btn value='Prep Time'><br>
							</div>
							<div class=pdib>
								<input type=button id=pdiet class=btn value=Diet><br>
								<input type=button id=psource class=btn value=Source>
							</div>
							
						</div>
						<div class=dib>
							<TEXTAREA class="form-control" id=recipe name=recipe></TEXTAREA>
						</div>
					</div>
					<br>
					<div class=pr><input type=submit class=btn name="add" value="Add Recipe"></div>
		
					<input type=hidden name="client" id=client value="<?php echo $client; ?>">
					<input type=hidden name="user" id=user value="<?php echo $user; ?>">
					<input type=hidden name="name" id=hname value="">
					<input type=hidden name="note"  id=hnote value="">
					<input type=hidden name="directions" id=hdirections value="">
					<input type=hidden name="preptime" id=hpreptime value="">
					<input type=hidden name="cooktime" id=hcooktime value="">
					<input type=hidden name="yield" id=hyield value="">
					<input type=hidden name="yield_unit" id=hyieldunit value="">
					<input type=hidden name="source" id=hsource value="">
					<input type=hidden name="cuisine" id=hcuisine value="">
					<input type=hidden name="ing" id=hingredients value="">
					
					<?php
					for ($lt1 = 0; $lt1 < 5; $lt1++) {
						print("<input type=hidden name=diet$lt1 id=hdiet$lt1 value=''>");
					}
					for ($lt1 = 0; $lt1 < 4; $lt1++) {
						echo "<input type=hidden name=cat",$lt1," id=hcat",$lt1," value=''>";
						echo "<input type=hidden name=scat",$lt1," id=hscat",$lt1," value=''>";
					}
					?>
				</form>
			</div>
                <?php
                        require_once('includes/bottom.php');
                ?>
       
                
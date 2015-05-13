<?php
        require_once('includes/top.php');
?>
        <title>Delete recipes</title>
        <meta name="description" content="Delete multiple recipes.">
        <script src="js/my.delete.js"></script>
		<script src="js/jquery.selectboxes.pack.js"></script>
		
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
        require_once('includes/banner.php');
        
        if (isset($_POST['delete'])) {
            if (!$_POST['related_recipe']) {
                $msgtxt="No Recipes Have Been Selected";
                echo "<script type='text/javascript'>
                        $('.message_box').removeClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msgtxt');
                        $('.message_box').show();
                    </script>";
            } else {
                ini_set('max_execution_time', 600);
                echo "<script type='text/javascript'>
                        $('.message_box').addClass('ok');
                        $('.message_box').html('Deleting recipes...');
                        $('.message_box').show();
                    </script>";
                $rec=0;
                foreach ($_POST['related_recipe'] as $val) {
                    $oldid=$val;
                    if (isset($admin)) {
                        $rec++;
                        require('includes/delrecipe.php');
                    } else {
                        $rec++;
                        $sql="$call query_hide_recipe(:oldid)";
                        $rshide = $rdb->prepare($sql);
                        $rshide->bindValue(':oldid', $oldid);
                        $rshide->execute();
    $err=$rdb->errorInfo();
                        $rshide->closeCursor();
                    }
                }
                require_once('includes/get_latest_recipe.php');
                if ($recrows>0) {
                    $id=$result[0];
                    require_once('includes/get_recipe_owner.php');
                     echo "<script type='text/javascript'>
                        $.cookie('rid',$id, { path: '/' });
                        $.cookie('rowner',$rowner, { path: '/' });
                    </script>";
                }
                if ($rec==1) {
                    echo "<script type='text/javascript'>
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >1 Recipe Deleted');
                        $('.message_box').show();
                    </script>";
                }  else {
                     echo "<script type='text/javascript'>
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$rec Recipes Deleted');
                        $('.message_box').show();
                    </script>";
                }
            }
        }
        
		if ($client=='wrm' && isset($admin)) {
            $sql = "$call query_owner_recipes_with_name_id(:oid)";  //return all recipes from db
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
        } else if (isset($admin)) {
            $sql = "$call query_recipes_with_name_id()";
            $dbrecipe = $rdb->prepare($sql);
        } else {
            $sql = "$call query_user_recipes_with_name_id(:uid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':uid', $uid);
        }
        $dbrecipe->execute();
        $err=$rdb->errorInfo();

        $numr = $dbrecipe->rowCount();
        $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
		$dbrecipe->closeCursor();						
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				<h3><strong>delete </strong>recipes</h3>
				<br>
				<form action="" name=form1 enctype="multipart/form-data" method="POST">
					<input type=submit class=btn name="delete" value="Delete" class=button><br><br>
					<div>
						<div class=dib>
							<strong class=rheader>Recipes</strong>
							<br><br>
							<select class=form-control id=erecipelist name=recipe[] size=<?php echo $numr;?> multiple>
							<?PHP
								for ($lt = 0; $lt < $numr; $lt++) {
									$recipeid = $rsrecipe[$lt][0];
									$recipeval = $rsrecipe[$lt][1];
									print("<option VALUE=$recipeid>$recipeval</option>");
								}
							?>
							</select>
						</div>
						<div id=centre class=dib>
							<div class=mdib><input id="add" type="button" class=btn value=">"></div>
							<div class=mdib><input id="addAll" type="button" class=btn value=">>"></div>
							<div class=mdib><input id="remove" type="button" class=btn value="<"></div>
							<div class=mdib><input id="removeAll"type="button" class=btn value="<<"></div>
						</div>
						<div class=dib>
							<strong class=rheader>Recipes To Delete</strong>
							<br><br>
							<select class=form-control id=erelated_recipe name=related_recipe[] size=<?php echo $numr;?> multiple>
							</select>
						</div>
					</div>
					<br><br>
					<input type=submit class=btn name="delete" value="Delete" class=button>
				</form>
			</div>
			<?php
				require_once('includes/bottom.php');
			?>
			
                
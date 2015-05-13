<?php
        require_once('includes/top.php');
?>
        <title>Order Shopping Aisles</title>
        <meta name="description" content="Change the order of your shopping aisles to match your supermarket.">
	    <script src="js/jquery-ui.min.js"></script>
	    <script src="js/jquery.ui.touch-punch.min.js"></script>
	    <script src="js/my.order.aisles.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.css">
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
				            <h3><strong>order </strong>my aisles</h3>
				            <br><br>
                            			                
					                <?php
						                $sql = "$call query_owner_aisles(:uid)";  //return all aisles from db
                                        $dbaisle= $rdb->prepare($sql);
                                        $dbaisle->bindValue(':uid', $uid);
                                        $dbaisle->execute();
                                        $err=$rdb->errorInfo();

                                        $numa = $dbaisle->rowCount();
                                        
                                        $rsaisle = $dbaisle->fetchAll(PDO::FETCH_BOTH);
                                        $dbaisle->closeCursor();
                                        
                                        if($numa>0) {
                                            echo '<div id=aisles><ul id="sortme">';
                                            for ($lt = 0; $lt < $numa; $lt++) {
                                                $id = $rsaisle[$lt][0];
                                                $aisle = $rsaisle[$lt][1];
                                                print ("<li class='ui-state-default' id=aisle_$id><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>$aisle</li>");
                                            }
                                            echo'</ul></div>';
                                        } else {
                                            echo'<h3>You have no aisles yet. You can create them on the shopping list page.</h3>';
                                        }						                
					                ?>				                
				            <br>
			            </div>
                <?php
                        require_once('includes/bottom.php');
                ?>
        
                
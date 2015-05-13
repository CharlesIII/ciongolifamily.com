<?php
        require_once('includes/top.php');
?>
                <title>Delivery & Refund Policy</title>
                <meta name="description" content="Web Recipe Manager delivery and refund policy.">
                <link rel="stylesheet" href="css/jquery-ui.css">
                <script src="js/jquery-ui.min.js"></script>
		        <script src="js/jquery.ui.totop.min.js"></script>
                <script>
                        $(function() {
                                $( "#accordion" ).accordion({collapsible : true, active : 'none'});
                        });
                        $(window).load(function(){
                                  $().UItoTop({ easingType: 'easeOutQuart' });
                        })
                </script>
        </head>
<body>
        <?php
                require_once('includes/banner.php');
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                                <h3><strong>delivery & refund </strong>policy</h3>
                                <br>
                                <div id="accordion">
                                        <h3>subscriptions:</h3>
                                        <div>
                                                <p>
                                                On completion of your purchase of a subscription for Web Recipe Manager, you will be able to log into your personal recipe database using the user name and password you chose during the registration process. You should have received confirmation of these details via the email address you have registered with us. If not then please <a href="contact-us.php">contact us</a>
                                                </p>
                                        </div>
                                        <h3>subscription upgrades/downgrades:</h3>
                                        <div>
                                                <p>
                                                As the database owner you may upgrade/downgrade your subscription any time by selecting 'Account Home' in the 'Account' menu, then selecting 'Upgrade My Subscription' in the 'My Subscription' menu. Here you may upgrade or downgrade your subscription. A pro-rata cost for the time until your next renewal will be calculated automatically if applicable. Once completed the new user limit will take effect the next time you log in or refresh any page in the recipe area.
                                                </p>
                                        </div>
                                        <h3>subscription renewals:</h3>
                                        <div>
                                                <p>
                                                If you store your credit card or Paypal details with us, then your subcriptions will automatically be renewed using those details on the renewal date. Otherwise an invoice will be sent to remind you when payment is due.
                                                </p>
                                                If payment is not received on the due date, you will be given 30 days to pay. You may bring your subscription up to date during this period by selecting 'Account Home' in the "Account" menu and paying your open invoice by clicking on 'View/Pay Invoices'. If payment is not received during this time, your subscription will be cancelled and all recipes and users will be removed from your database.
                                                <p>
                                                Please <a href=contact-us.php>contact us</a> if you feel your account has been suspended/cancelled without reason.
                                                </p>
                                        </div>
                                        <h3>subscription cancellations:</h3>
                                        <div>
                                                <p>
                                                If you choose to cancel your subscription for any reason, you can do so by by selecting 'Remove My Account' in the "Account" menu. <strong>Please be aware</strong> that no pro-rata refund will be issued if you choose to cancel prior to the next renewal date, and all recipes will be deleted.
                                                </p>
                                        </div>
                                </div>
                                <br>
                                <br>
                                We would appreciate feedback <a href="contact-us.php">here</a> if you cancelled due to any concerns with Web Recipe Manager's functionality, services, etc.
                        </div> 
        <?php
                require_once('includes/bottom.php');
        ?>
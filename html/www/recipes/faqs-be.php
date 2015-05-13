<?php
        require_once('includes/top.php');
?>
                <title>FAQ</title>
                <meta name="description" content="Frequently asked questions">
                <script src="js/my.login.js"></script>
                <script src="js/jquery.leanModal.min.js"></script>
                <script src="js/leanmobile.js"></script>
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
                                <h3>frequently asked <strong>Questions</strong></h3>
                                <div id="accordion">
                                        <h3>1:  Is this just another recipe portal?</h3>
                                        <div>
                                                <p>
                                                No, definitely not. Web Recipe Manager is your own private recipe web site. No one else has access to it unless they have your user name and password. You have total control of the recipes in your database and can add, import, edit or delete them at your will.
                                                </p>
                                        </div>
                                        <h3>2:  What does Web Recipe Manager do?</h3>
                                        <div>
                                                <p>
                                                WRM is a web based application that allows you to manage all your recipes anywhere you have access online. You can create recipes one by one through the recipe editor, where you can either enter ingredients one at a time, or cut and paste them all in one hit. You can also import your recipes in bulk, using Meal Master or CSV format.
                                                </p>
                                        </div>
                                        <h3>3:  Why does this website cost when others are free?</h3>
                                        <div>
                                                <p>
                                                There is no annoying advertising on WRM so the cost needs to be covered by you the subscribers, in return you get something unique a place to store and share your recipes with only those people you want to see them. No one else will be able to see your recipes. You also get a heap of functionality and control that you don't get on other recipe websites.
                                                </p>
                                        </div>
                                        <h3>4:  Can I Import recipes from other recipe databases?</h3>
                                        <div>
                                                <p>
                                                You can import recipes from other systems if they have an export function. Meal Master and CSV formats (see specification <a href=import_format.php>here</a>) are supported.
                                                </p>
                                        </div>
                                        <h3>5:  Can I import my recipes into other recipe software?</h3>
                                        <div>
                                                <p>
                                                Web Recipe Manager allows you to export recipes in Meal Master, Microsoft Word or CSV format. So you can import your recipes into any recipe software that supports imports in these formats. Please let us know <a href='contact-us.php'>here</a> if there are any other formats you would like us to consider.
                                                </p>
                                        </div>
                                        <h3>6:  How do I backup my recipes?</h3>
                                        <div>
                                                <p>
                                                You can backup your recipes by either exporting them in Meal Master, Microsoft Word or CSV format, or creating an eBook. Please let us know <a href='contact-us.php'>here</a> if there are any other formats you would like us to consider.
                                                </p>
                                        </div>
                                        <h3>7:  What can I do to help make improvements?</h3>
                                        <div>
                                                <p>
                                                We appreciate any <a href='contact-us.php'>feedback</a> that will help us make this recipe software work better, more efficiently or smarter. <?php if($client=='wrm') { echo "If you are an existing customer you should visit our <a href='".$scpath."helpdesk.php'>helpdesk</a>.";} ?>
                                                </p>
                                        </div>
                                        <h3>8:  Do you have plans for the future?</h3>
                                        <div>
                                                <p>
                                                Web Recipe Manager will continue to evolve, we will continue to make improvements, add new functionality and generally make the system work better in every little way.
                                                </p>
                                        </div>
                                </div>
                        </div>
        <?php
                require_once('includes/bottom.php');
        ?>
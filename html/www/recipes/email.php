<?php
        require_once('includes/top.php');
?>
                <script src="js/jquery-ui.min.js"></script>
                <script src="js/my.email.js"></script>
                <link href="css/jquery-ui.css" rel="stylesheet"> 
                <title>Email recipe</title>
                <meta name="description" content="Email a recipe to friends.">
        </head>
        <?php
                require_once('includes/banner.php');
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                                <h3><strong>email </strong>recipe to friends</h3>
                                <form name="enq" id="support_form" method="post" class="form-horizontal top-margin" role="form">
                                        <div>
                                                <div class="success" style="display:none;">
                                                        <div class="success_txt">
                                                                <strong>Sending email...</strong>
                                                        </div>
                                                </div>
                                                <?php
                                                    if(isset($guest)) {
                                                        echo '
                                                        <div id="my-name" class="form-group">
                                                                <div class="col-xs-12">
                                                                        <input id="myname" name="my-name" class="form-control" placeholder="Your Name">
                                                                </div>
                                                        </div>
                                                        <div id="my-email" class="form-group">
                                                                <div class="col-xs-12">
                                                                        <input id="myemail" name="my-email" class="form-control" placeholder="Your Email">
                                                                </div>
                                                        </div>';
                                                    }
                                                ?>
                                                
                                                <div id="contact-name" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-name" name="name" type="text" class="form-control" placeholder="Friend's Name/s">
                                                        </div>
                                                </div>
                                                
                                                <div id="contact-email" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-email" name="email" class="form-control" placeholder="Friend's Email/s">
                                                        </div>
                                                </div>
                                                
                                                <div id="contact-message" class="form-group">
                                                        <div class="col-xs-12">
                                                                <textarea id="input-message" name="message" class="form-control" rows="5" placeholder="Message"></textarea>
                                                        </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                        <div class="col-xs-12">
                                                                <button id=submit name="submit" type="submit" class="btn btn-default">Submit</button>
                                                                <button id=back class=btn>Back To Recipe</button>
                                                        </div>
                                                </div>
                                        </div>
                                        <input type=HIDDEN name=user id=user value=<?php echo $user;?>>
                                        <input type=HIDDEN name=client id=client value=<?php echo $client;?>>
                                        <?php
                                        if(isset($guest)) {
                                            print("<input type=HIDDEN name=guest id=guest value=$guest>");
                                        }
                                        ?>
                                </form>                                                                         
                        </div>
        <?php
                require_once('includes/bottom.php');
        ?>
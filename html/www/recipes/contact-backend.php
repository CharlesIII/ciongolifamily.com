<?php
        require_once('includes/top.php');
?>
                <title>Contact Web Recipe Manager</title>
                <meta name="description" content="Contact Web Recipe Manager with any questions or feedback.">
                <script src="js/my.login.js"></script>
                <script src="js/jquery.leanModal.min.js"></script>
                <script src="js/leanmobile.js"></script>
        </head>
<body>
        <?php
                require_once('includes/banner.php');
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                                <h3><strong>contact </strong>us</h3>
                                <?php
                                    if ($client=='wrm'){
                                        echo "
                                        <div class='dib blog'>
                                        <img src=images/001-small.jpg alt=Web Recipe Manager Developer and owner><br>
                                        Barbara McLennan<br>
                                        38 Meridian Circuit<br>
                                        Berwick 3806<br>
                                        Australia<br>
                                        ABN 59870200775
                                        </div><div class='dib blog'>
                                        <strong>Blog</strong><br>
                                        <a href='http://webrecipemanager.blogspot.com' target=_BLANK title='Web Recipe Manager Blog'><img id=blog src='images/blog.jpg' alt='Web Recipe Manager blog'></a>
                                        </div>
                                        <br><br>
                                        <strong>Email</strong>";
                                    }
                                ?>
                                        
                                <p>If you have a question, comment, suggestion or just need some help, get in touch. Please fill in the form below.</p>
                                <form name="enq" id="support_form" method="post" class="form-horizontal top-margin" role="form">
                                        <div>
                                                <div class="success" style="display:none;">
                                                        <div class="success_txt">
                                                                <strong>Sending email...</strong>
                                                        </div>
                                                </div>
                                                <div id="contact-name" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-name" name="name" type="text" class="form-control" placeholder="Your Name">
                                                        </div>
                                                </div>
                                                
                                                <div id="contact-email" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-email" name="email" class="form-control" placeholder="Your Email">
                                                        </div>
                                                </div>
                                                
                                                <div id="contact-message" class="form-group">
                                                        <div class="col-xs-12">
                                                                <textarea id="input-message" name="message" class="form-control" rows="5" placeholder="Your Enquiry"></textarea>
                                                        </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                        <div class="col-xs-12">
                                                                <button id=submit name="submit" type="submit" class="btn btn-default">Submit</button>
                                                        </div>
                                                </div>
                                        </div>
                                </form>
                        </div>  
        <?php
                require_once('includes/bottom.php');
        ?>
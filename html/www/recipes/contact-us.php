<?php
        require_once('includes/htop.php');
?>
          <title>Contact Web Recipe Manager</title>
          <meta name="description" content="Contact Web Recipe Manager with any questions or feedback.">
          <script src="js/my.login.js"></script>
          <script src="js/jquery.leanModal.min.js"></script>
          <script src="js/jquery_cookie.js"></script>
           <script src="js/leanmobile.js"></script>
        </head>
         <div class="loginmodal" style="display:none;">
                <h3>
                 <span>user Login</span>
                </h3>
                <a class="modal_close" href="#"></a>
                <form id="mlogin_form" method="post">
                        <br>
                        <input id="muser" class=form-control type="text" name="user" value="User...">
                        <input id="mpassword-clear" type="text" class=form-control autocomplete="off" value="Password...">
                        <input id="mpassword" class=form-control type="password" name="password" style="display: none;">
                        <br>
                        <div id="mmsgbox"></div>
                        <div class=upgrade><strong>Web Recipe Manager is currently being updated - we apologise for any inconvenience</strong><br></div>
                        <br>
                        <button id=msubmit name="submit" type="submit" class="btn btn-default">Log In</button>
                        <br>
                        <div class="login">
                                <?php
                                    if($client=='wrm') {
                                        echo '<a href="sign-up.php">Not a Member yet? Sign up</a>
                                        <br>
                                        <a href="http://webrecipemanager.com/awbs/LostPassword.php">Forgotten Password</a>';
                                    } else {
                                        echo '<a href="create-account.php">Not a Member yet? Sign up</a>
                                        <br>
                                        <a href="passwordreset.php">Forgotten Password</a>';
                                    }
                                ?>
                        </div>
                </form>
        </div>
        <div class="demomodal" style="display:none;">
                <h3>
                 <span>demo Login</span>
                </h3>
                <a class="modal_close" href="#"></a>
                <form id="dlogin_form" method="post">
                        <br>
                        <input id="duser" class=form-control type="text" name="user" value="demo">
                        <input id="dpassword-clear" class=form-control type="text" autocomplete="off" value="demo99">
                        <input id="dpassword" class=form-control type="password" name="password" style="display: none;" value="demo99">
                        <br>
                        <div id="dmsgbox"></div>
                        <div class=upgrade><strong>Web Recipe Manager is currently being updated - we apologise for any inconvenience</strong><br></div>
                        <br>
                        <button id=dsubmit name="submit" type="submit" class="btn btn-default">Log In</button>
                        <br>
                </form>
        </div>
        <?php
                require_once('includes/hbanner.php');
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                                <h1><strong>contact </strong>us</h1>
                                <?php
                                    if ($client=='wrm'){
                                        echo "
                                        <div class='dib blog'>
                                        Barbara McLennan<br>
                                        Melbourne<br>
                                        Australia<br>
                                        ABN 59870200775
                                        </div>
                                        <div class='dib blog'>
                                        <strong>Blog</strong><br>
                                        <a href='http://webrecipemanager.blogspot.com' target=_BLANK title='Web Recipe Manager Blog'><img id=blog src='images/blog.jpg' alt='Web Recipe Manager blog'></a>
                                        </div>
                                        <br><br>
                                        <strong>Email</strong>";
                                    }
                                ?>
                                        
                                <h2>If you have a question, comment, suggestion or just need some help. Please contact us using the form below.</h2>
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
                                                
                                                <div id="contact-captcha" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-captcha" name="captcha" class="form-control" placeholder="Enter the code below:">
                                                                <br>
                                                                <img src="includes/captcha_code_file.php?rand=<?php echo rand(); ?>" id="captchaimg" alt="captcha image">
                                                                <br>
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
                require_once('includes/hbottom.php');
        ?>
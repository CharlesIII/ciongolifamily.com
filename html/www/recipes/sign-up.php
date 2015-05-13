<?php
        require_once('includes/htop.php');
?>
        <title>Web Recipe Manager - Sign Up</title>
        <meta name="description" content="Sign up for Web Recipe Manager on a monthly/yearly basis from $1 and start adding and managing your recipes today.">
        <script src="js/my.login.js"></script>
        <script src="js/jquery.leanModal.min.js"></script>
        <script src="js/jquery_cookie.js"></script>
        <script src="js/leanmobile.js"></script>
</head>
        <div class="demomodal" style="display:none;">
                <h1>
                 <span>demo Login</span>
                </h1>
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
                                        <h3><strong>sign up</strong> Options</h3>
                                        <?php
                                                if (isset($msgtxt)) {
                                                   print("<span>$msgtxt</span>");
                                                }
                                        ?>
                                        <br><br>
                                </div>
                                <br><br>
                                
                                <div class="box subox col-xs-12 col-sm-9">
                                        <div class="container_12">
                                                <div class="grid_4 span3">
                                                        <div class="block">
                                                                <strong></strong>
                                                                <div class="inner">
                                                                     <span>Free</span><br>
                                                                     <em>Demo</em><br>
                                                                     <p>Try the online version of Web Recipe Manager, before you sign up (fully functional).</p>
                                                                     <br>
                                                                     <br>
                                                                     <br>
                                                                     <br>
                                                                     <br>
                                                                     <div class="div-button">
                                                                       <a class="modaltrigger ctabuttons" href=".demomodal">Login</a>
                                                                     </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="grid_4 span3">
                                                    <div class="block">
                                                       <strong></strong>
                                                       <div class="inner">
                                                            <span>Bronze</span><br>
                                                            <em>Up to 2 users</em><br><br>
                                                            <em>Monthly</em><br><em>AU$1.00</em><br><br><em>Yearly</em><br><em>AU$10.00</em>
                                                            <div class="div-button">
                                                              <a id=bbutton class=ctabuttons href="<?php echo $sscpath;?>hsignup.php?pt=&plan=Bronze">Sign Up</a>
                                                            </div>
                                                       </div>
                                                    </div>
                                                </div>
                                                <div class="grid_4 span3">
                                                    <div class="block">
                                                       <strong></strong>
                                                       <div class="inner">
                                                            <span>Silver</span><br>
                                                            <em>Up to 20 users</em><br><br>
                                                            <em>Monthly</em><br><em>AU$2.50</em><br><br><em>Yearly</em><br><em>AU$20.00</em>
                                                            <div class="div-button">
                                                              <a id=sbutton class=ctabuttons href="<?php echo $sscpath;?>hsignup.php?pt=&plan=Silver">Sign Up</a>
                                                            </div>
                                                       </div>
                                                    </div>
                                                </div>                
                                                <div class="grid_4 span3">
                                                    <div class="block">
                                                       <strong></strong>
                                                       <div class="inner">
                                                            <span>Gold</span><br>
                                                            <em>Up to 200 users</em><br><br>
                                                            <em>Monthly</em><br><em>AU$5.00</em><br><br><em>Yearly</em><br><em>AU$40.00</em>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <div class="div-button">
                                                              <a id=gbutton class = ctabuttons href="<?php echo $sscpath;?>hsignup.php?pt=&plan=Gold">Sign Up</a>
                                                            </div>
                                                       </div>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                        </div>
                                        
                                </div>
                                
                                <div class="col-xs-12 col-sm-9">
                                        <br><br>
                                        <span>
                                        If you have more than 200 users, please <a href="contact-us.php"><strong>contact us</strong></a>. To discuss other options.
                                        </span>
                                        <br><br>
                                </div>

        <?php
                require_once('includes/hbottom.php');
        ?>
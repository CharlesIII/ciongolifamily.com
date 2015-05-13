<?php
        require_once('includes/htop.php');
?>
           <title>Web Recipe Manager - Store and manage your recipes online</title>
           <meta name="description" content="Web Recipe Manager, the smarter place to store and manage your recipes online, with a menu planner and shopping lists.">
           <script src="js/my.login.js"></script>
           <script src="js/jquery.leanModal.min.js"></script>
           <script src="js/leanmobile.js"></script>
           <script src="js/jquery_cookie.js"></script>
           <script src="//rk.revolvermaps.com/0/0/2.js?i=axv4zzzctac&amp;m=0&amp;s=70&amp;c=fff600&amp;t=1" async="async"></script>
		   <meta name="google-site-verification" content="RlUsYdJZFcnn7Met4rWaCzhuUcdSRXU37JeRYSqE_dE" />
           <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53eaec592d00eb42"></script>
        </head>
        <?php
                if (isset($_GET['timeout'])) {
                    //$lastpage=$_GET['lastpage'];
                    $msgtxt="Your session has expired. Please log in to continue.";
                    echo "<script type='text/javascript'>
                        $('.message_box').removeClass('ok');
                        $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Note: $msgtxt');
                        $('.message_box').show();
                        </script>";
                }
                if (isset($_GET['deleted']) || (isset($_GET['status']) && $_GET['status']=='cancelled')) {
                    $msgtxt="Your account has been removed. You will no longer be able to log in.";
                    echo "<script type='text/javascript'>
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\' src=\'images/ok.png\'>Note: $msgtxt');
                        $('.message_box').show();
                        </script>";
                }
                require_once('includes/hbanner.php');
        ?>
        
        
        <div class="demomodal" style="display:none;">
                <h3>
                 <span>demo login</span>
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
        <div id="sb-site" class="sb-slide">
                <div class="container">
                        <div class="row">
                                <div class="box col-xs-12 col-sm-9">
                                        <div class="container_12">
						                    <div class="grid_4">
                                                    <div class="block-2">
                                                       <div class="inner">
                                                            <span>Log In</span><br>
                                                            <form id="login_form" method="post" role=form>
                                                                <br><input value="User..." class="form-control" name="user" id="user" type="text"><br>
                                                                <input class="form-control" id="password-clear" value="Password..." autocomplete="off" type="text">
                                                                <input style="display: none;" class="form-control" name="password" id="password" type="password"><br>
                                                                <div id="msgbox"></div><br>
								                                <div class=upgrade><strong>Web Recipe Manager is currently being updated - we apologise for any inconvenience</strong><br><br></div>
                                                                <?php
                                                                if($client=='wrm') {
                                                                    echo '<a href="sign-up.php">Not a Member yet? Sign up</a>
                                                                    <br><br>
                                                                    <a href="http://webrecipemanager.com/awbs/LostPassword.php">Forgotten Password</a>
                                                                    <br><br>';
                                                                } else {
                                                                    echo '<a href="create-account.php">Not a Member yet? Sign up</a>
                                                                    <br><br>
                                                                    <a href="passwordreset.php">Forgotten Password</a>
                                                                    <br><br><br>';
                                                                }
                                                                ?>
                                                            </form>
							                                <div class="div-button">
                                                                <?php
                                                                if($client=='wrm') {
                                                                    echo'<a id=lbutton class="mlogin ctabuttons" href="#">Log In</a>';
                                                                } else {
                                                                    echo'<a id=mlbutton class="mlogin ctabuttons" href="#">Log In</a>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid_4">
                                                    <div class="block">
                                                       <div class="inner">
                                                            <span>Sign</span><br>
                                                            <em>Up</em><br>
                                                            <?php
                                                                if($client=='wrm') {
                                                                    echo '<p>For a small fee, you can start adding and managing your own recipes today. Scan them in from paper, recipe books, etc. Copy and paste them from the internet, or just type them in. They will be accessible on any device, to be seen only by those you choose to share them with.</p><br>';
                                                                } else {
                                                                    echo '<p>Start adding and managing your own recipes today.</p><br>';
                                                                }
                                                            ?>
                                                            <div class="div-button">
                                                            <?php
                                                            if($client=='wrm'){
                                                                echo '<a id=subutton class=ctabuttons href="sign-up.php">Sign Up</a>';
                                                            } else  {
                                                                echo '<a id=msubutton class=ctabuttons href="create-account.php">Sign Up</a>'; 
                                                            }
                                                            ?>
                                                            </div>
                                                       </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if($client=='wrm') {
                                                    echo '<div class="grid_4">
                                                        <div class="block">
                                                           <div class="inner">
                                                                <span>Purchase</span><br>
                                                                <em>A copy to run on your own server</em>
                                                                <p>Have your very own copy of Web Recipe Manager with automatic updates, automatic enhancements and reliable and responsive support. All this for a nominal yearly fee. Free 14 day free trial. Installation service available.</p>
                                                                <div class="div-button">
                                                                  <a class=ctabuttons id=pbox href="purchase.php">Plans</a>
                                                                </div>
                                                           </div>
                                                        </div>
                                                    </div>';
        
                                                    echo '<div class="grid_4">
                                                        <div class="block">
                                                           <div class="inner">
                                                                <span>Free</span><br>
                                                                <em>Demo</em><br>
                                                                <p>Log in and try the online version of Web Recipe Manager, before you sign up.</p>
                                                                <div class="div-button">
                                                                  <a id=fdbutton class="modaltrigger ctabuttons" href=".demomodal">Login</a>
                                                                </div>
                                                           </div>
                                                        </div>
                                                    </div>';
                                                }               
                                                ?>
                                                <div class="clear"></div>
                                        </div>                                                     
                                </div>
                                <div class="content dib">
                                        <h1>The Web <strong>Recipe</strong> Manager <strong>Advantage</strong></h1>
                                        <br>
                                        <p><strong>Save precious family recipes</strong> that have been handed down from grandmother to granddaughter, father to son, etc for generations to come. Share them with family whether they are located next door or half way around the world.</p>
                                        <!--<p><strong>Document your recipes using any media you choose</strong> by adding a movie, a pdf document or up to 10 images</p>-->
                                        <!--<p>That's amazing, we know food is what holds families together, and we understand that online is the way to go. Save those recipes for prosperity and share the love!</p>-->
                                        <p><strong>Stop having recipes all over the place</strong> some in recipe books, others written on paper, some collected from the internet - organise them in one place where you can access them anywhere, any time.</p>
                                        <!--<p>We have the perfect solution.</p>-->
                                        <p><strong>Choose who has access to your recipes.</strong> There are so many recipe sites out there where you can save your recipes online, and share them with the world - on Web Recipe Manager, only you and those you choose to share your recipes with have access.</p>
                                        <!--<p>We hear you! </p>-->
                                        <p><strong>Organise your recipes your way by assigning recipe types (e.g. Entree) and categories (e.g. Chicken) that make sense to you.</strong> Web Recipe Manager gives you 4 recipe types and 4 categories to use for each recipe. Not only that but they are completely customizable without any setup. Just add recipes with whatever recipe types and categories you wish.</p>
                                        <!--<p>So do we. That's why </p>-->
                                        <p><strong>Web Recipe Manager allows you to enter and organize your recipes in any language you want.</strong></p>
                                        <p>Add up to <strong>10 images</strong> a <strong>pdf </strong>and a <strong>video</strong> to each recipe</p>
                                        <p>See the full list of <a href=features.php>features</a></p>
                                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                </div>
                                <div class=dib>
                                  <img class="img-responsive" alt="Web Recipe Manager Logo" src="images/aubergine.jpg">
                                </div>
                                <div class="addthis_sharing_toolbox"></div>
                                
                                <?php
                                    /*if(isset($lastpage)) {
                                        print("<input id=lastpage value='$lastpage' type='hidden'>");
                                    }*/
                                    print("<input type=hidden id='client' value=$client>")
                                ?>
        <?php
                require_once('includes/hbottom.php');
        ?>
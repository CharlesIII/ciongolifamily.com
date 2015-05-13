                        </div>
                                <footer>
                                        <div class="row">
                                                <div class="col-xs-12">
                                                        <small>
                                                        <?php
                                                        $now= date('Y');
                                                        if($client=='wrm')  {
                                                            echo '<p>
                                                                        Web Recipe Manager &copy; 2009 - '.$now.'<br>
                                                                        <a href="privacy-policy.php">Privacy Policy</a>  |  <a href="delivery-refund-policy.php">Delivery &amp; Refund Policy</a>  |  <a href="sitemap.php">Site Map</a>
                                                                </p>';
                                                        } else {
                                                            echo '<p>
                                                                        My Web Recipe Manager &copy; 2010 - '.$now.'<br>
                                                                        <a href="sitemap.php">Site Map</a> | <a href="licence.php">End User License Agreement</a>
                                                                </p>';
                                                        }
                                                        ?>
                                                                
                                                        </small>
                                                </div>
                                        </div>
                                </footer>
                        </div>
                </div>
                <div class="sb-slidebar sb-left">
                        <nav>
                                <ul class="sb-menu">
                                        <li>
                                        <img width="200" height="40" alt="Slidebars" src="images/slidebars-logo-white@2x.png">
                                        </li>
                                        <li>
                                                <a href="index.php">Home</a>
                                        </li>
                                        <?php if($client=='wrm') {
                                            echo '
                                                <li>
                                                       <a href="sign-up.php">Sign Up</a> 
                                                </li>
                                                <li>
                                                       <a href="purchase.php">Buy</a> 
                                                </li>
                                                <li>
                                                        <a href="features.php">Features</a>
                                                </li>
                                                <li>
                                                        <a href="screenshot-gallery.php">Gallery</a>
                                                </li>
                                                <li>
                                                        <a href="customer-testimonials.php">Testimonials</a>
                                                </li>
                                                <li>
                                                        <a href="contact-us.php">Contact</a>
                                                </li>
                                                ';
                                        } else {
                                             echo '
                                                <li>
                                                    <a href="create-account.php">Create Account</a>        
                                                </li>
                                                <li>
                                                        <a href="passwordreset.php">Password Reset</a>
                                                </li>
                                                <li>
                                                        <a href="contact-us.php">Contact Us</a>
                                                </li>';
                                        }
                                        ?>
                                        <li>
                                                <a href="frequently-asked-questions.php">FAQ</a>
                                        </li>
                                        <?php
                                            if($client=='wrm') {
                                                echo '<li>
                                                <a href="privacy-policy.php">Privacy Policy</a>
                                                </li>
                                                <li>
                                                        <a href="delivery-refund-policy.php">Delivery &amp; Refund Policy</a>
                                                </li>
                                                <li>
                                                        <a href="sitemap.php">Site Map</a>
                                                </li>';
                                            }
                                        ?>
                                </ul>
                        </nav>
                </div>
                <script>
                        (function($) {
                                $(document).ready(function() {
                                        // Initiate Slidebars
                                        $.slidebars();
                                        // Slidebars Submenus
                                        $('.sb-toggle-submenu').off('click') // Stop submenu toggle from closing Slidebars.
                                                .on('click', function() {
                                                $submenu = $(this).parent().children('.sb-submenu');
                                                $(this).add($submenu).toggleClass('sb-submenu-active'); // Toggle active class.
                                                if ($submenu.hasClass('sb-submenu-active')) {
                                                        $submenu.slideDown(200);
                                                } else {
                                                        $submenu.slideUp(200);
                                                }
                                        });
                                });
                        }) (jQuery);
                </script>
                <?php
                if(curPageName()== 'contact-us.php') {
                    echo '<script src="js/form_validation.js"></script>';
                } else if(curPageName()== 'create-account.php') {
                    echo '<script src="js/regn_form_validation.js"></script>';       
                } else if(curPageName()== 'passwordreset.php') {
                    echo '<script src="js/pw_form_validation.js"></script>';       
                }  
                ?>           
                
        </body>
</html>
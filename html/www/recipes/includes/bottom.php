                                </div>
                                <footer>
                                        <div class="row nofs">
                                                <div class="col-xs-12">
                                                        <small>
                                                              Web Recipe Manager &copy; 2009 - <?php echo date('Y');?> <br class=noprint>
                                                              <a href='pp-backend.php'>Privacy Policy</a>
                                                              <a href='sitemap-backend.php'> | Site Map</a>
                                                              <a href='drp-backend.php'> | Delivery & Refund Policy</a>
                                                        </small>
                                                </div>
                                        </div>
                                </footer>
                        </div>
                </div>
                <div class="sb-slidebar sb-left noprint">
                        <?php
                        require_once('left-sidebar.php');
                        ?>
                </div>
                <div class="sb-slidebar sb-right noprint">
                        <h3 class=noprint><strong>page help</strong></h3>
                        <?php
                        require_once('right-sidebar.php');
                        ?>
                </div>
                <script>
                        (function($) {
                                $(document).ready(function() {
                                        // Initiate Slidebars
                                        $.slidebars({
                                            siteClose: false
                                        });
                                        
                                        // Slidebars Submenus
                                        $(document).on('click', '.sb-toggle-submenu', function() {
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
                if(curPageName()== 'contact-backend.php') {
                    echo '<script src="js/be_form_validation.js"></script>';
                } else if(curPageName()== 'email.php') {
                    echo '<script src="js/email_validation.js"></script>';       
                } else if(curPageName()== 'profmaint.php') {
                    echo '<script src="js/prof_validation.js"></script>';       
                } 
                ?>
        </body>
</html>
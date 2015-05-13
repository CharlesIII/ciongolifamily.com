<body id="top" data-twttr-rendered="true">
                <div class='ok message_box' style="display:none;"></div>
                <nav class="navbar navbar-default navbar-fixed-top sb-slide" role="navigation">
                        <div class="sb-toggle-left navbar-left">
                                <div class="navicon-line"></div>
                                <div class="navicon-line"></div>
                                <div class="navicon-line"></div>
                        </div>
                        <div class="container">
                                <div id="logo" class="navbar-left">
                                        <a href="index.php">
                                        <img width="200" height="40" alt="Web Recipe Manager Logo" src="images/slidebars-logo@2x.png">
                                        </a>
                                </div>
                                <ul class="hnav">
                                        <li>
                                                <a href="index.php">Home</a>
                                        </li>
                                        
                                <?php if($client=='wrm') {
                                    echo '
                                        <li>
                                               <a href="sign-up.php">Sign-Up</a> 
                                        </li>
                                        <li>
                                               <a href="purchase.php">Buy</a> 
                                        </li>
                                        <li>
                                                <a href="features.php">Features</a>
                                        </li>
                                        <li>
                                                <a href="customer-testimonials.php">Testimonials</a>
                                        </li>
                                        <li>
                                                <a href="contact-us.php">Contact</a>
                                        </li>'
                                        ;
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
                                        <li>
                                                <a id="top-arrow" href="#top">^</a>
                                        </li>
                                </ul>
                        </div>
                </nav>
                
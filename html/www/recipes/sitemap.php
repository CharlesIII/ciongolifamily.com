<?php
        require_once('includes/htop.php');
?>
                <title>Web Recipe Manager - Site map</title>
                <meta name="description" content="Web Recipe Manager site map.">
        </head>
<body>
        <?php
                require_once('includes/hbanner.php');
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                                <h1><strong>site </strong>map</h1>
                                <br>
                                <h4 class="bg-h2">Home Pages</h4>						
                                <div id=splist>
                                    <?php
                                        if($client=='wrm') {
                                            print("
                                            <a href='index.php'>Home</a><br>
                                            <a href='sign-up.php'>Sign Up</a><br>
                                            <a href='screenshot-gallery.php'>Gallery</a><br>
                                            <a href='features.php'>Features</a><br>
                                            <a href='contact-us.php'>Contact Us</a><br>
                                            <a href='frequently-asked-questions.php'>FAQS</a><br>
                                            <a href='privacy-policy.php'>Privacy Policy</a><br>
                                            <a href='delivery-refund-policy.php'>Delivery & Refund Policy</a><br>"); 
                                        } else {
                                            print("
                                            <a href='index.php'>Home</a><br>
                                            <a href='create-account.php'>Create Account</a><br>
                                            <a href='passwordreset.php'>Password Reset</a><br>
                                            <a href='contact-us.php'>Contact Us</a><br>
                                            <a href='frequently-asked-questions.php'>FAQS</a><br>");
                                        }
                                    ?>
                                </div>
                                <br>
                                <h4 class="bg-h2">Members area</h4>
                                <div class='smdiv dib'>
                                                        <strong>Recipes</strong><br><br>
                                                        <span>Delete</span><br><br>
                                                        <span>Edit</span><br><br>
                                                        <span>Copy</span><br><br>
                                                        <span>Print</span><br><br>
                                                        <span>Email</span><br><br>
                                                        <span>Add to Favorites</span><br><br>
                                                        <span>Remove from Favorites</span><br><br>
                                                        <span>Fullscreen View</span>
                                </div>
                                <div class='smdiv dib' id=smdiv2>
                                                        <strong>Menu Planning</strong><br><br>
                                                        <span>Meal Planner</span><br><br>
                                                        <span>Shopping Lists</span><br><br>
                                                        <span>Manage Ingredient Exclusion List</span><br><br>
                                                        <span>Manage Aisle Order</span><br>
                                                        <br>
                                                        <strong>Tools</strong><br><br>
                                                        <span>Copy & Paste</span><br><br>
                                                        <span>Add Manually</span><br><br>
                                                        <span>Import</span><br><br>
                                                        <span>Export</span><br><br>
                                                        <span>Create eBook</span>
                                </div>
                                <div class='smdiv dib' id=smdiv3>
                                                        <strong>Search</strong><br><br>
                                                        <strong>Account</strong><br><br>
                                                        <span>Preferences</span><br><br>
                                                        <span>Manage My Data</span><br><br>
                                                        <ul>
                                                        <li>Manage Ingredients</li>
                                                        <li>Manage Units Of Measure</li>
                                                        <li>Manage Preprepartion/Notes</li>
                                                        <li>Manage Recipe Names</li>
                                                        <li>Manage Yield Units</li>
                                                        </ul>
                                                        <span>Logout</span>
                                </div>
                                <div class='smdiv dib' id=smdiv4>
                                    <?php
                                        if($client=='wrm') {
                                            print("
                                            <strong>Help</strong><br><br>
                                            <a href='".$scpath."kb.php'>Knowledgebase</a><br><br>
                                            <span>Support</span><br><br>
                                            <a href='".$scpath."news.php'>News</a><br><br>
                                            <span>International Volume Measures</span>");    
                                        } else {
                                            print("
                                            <strong>Help</strong><br><br>
                                            <a href='frequently-asked-questions.php'>FAQs</a><br><br>
                                            <a href='contact-us.php'>Support</a><br><br>
                                            <a href='contact-us.php'>Contact-us</a><br><br>
                                            <a href='sitemap.php'>Site Map</a><br><br>");
                                        }
                                    ?>
                                                        
        
                                </div>
                        </div> 
        <?php
                require_once('includes/hbottom.php');
        ?>
<?php
        require_once('includes/htop.php');
?>
                <title>Web Recipe Manager - Features</title>
                <meta name="description" content="See the full list of Web Recipe Manager features.">
                <script src="js/my.login.js"></script>
                <script src="js/jquery.leanModal.min.js"></script>
                <script src="js/leanmobile.js"></script>        
                <link rel="stylesheet" href="css/jquery-ui.css">
                <script src="js/jquery-ui.min.js"></script>
                <script src="js/jquery_cookie.js"></script>
                <script>
                        $(function() {
                                $( ".accordion" )
                                .accordion({
                                    collapsible : true, 
                                    active : false,
                                    autoHeight : false,
                                    activate: function(event, ui) {
                                        $("#sb-site").show()[0].scrollIntoView(true);
                                    }
                                 });
                                 
                        });
                        $(window).load(function(){
                            $("#sb-site").show()[0].scrollIntoView(true);
                        })
                </script>
        </head>
        <div class="demomodal" style="display:none;">
                <h3>
                 <span>Demo Login</span>
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
                                                        <a id=lbutton class='mlogin ctabuttons' href="#">Log In</a>
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
                                                        echo '<a class=ctabuttons href="create-account.php">Sign Up</a>'; 
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
                        <div class="col-xs-12 col-sm-9">
                                <h3><strong>Features</strong></h3>
                                <p>Web Recipe Manager is a database driven, online recipe management system that allows you to store and manage all your personal recipes, create menu plans and shopping lists from them. This gives you access to your recipes, menu plans and shopping lists anywhere, on any device and anytime.</p> 
                                <br>
                                <p>Click on an item to see more.</p>
                                <div class="accordion">
                                     <h3 class=myacc>Recipe Management</h3>
                                        <div class="accordion myacc">
                                            <h3 class=myacc>Text Size Selection</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Select from 3 different text sizes to suit your needs when viewing and managing your recipes.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Resize Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Resize a recipe by specifying a new number of serves, or whatever the yield unit is for the recipe. There is also an option to resize any related recipes at the same time. You can save the resized recipe if you like, or revert to the original recipe.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Convert Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Convert a recipe that has a different measurement system than the one you use. For example convert from Metric to US units of measure.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Edit Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Edit your own recipes unless you are an administrator, in this case you can edit any recipe.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Choose your Own Recipe Types or Categories</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Each recipe can have four recipe types (e.g. Entree, Side Dish) and four categories (e.g. Chicken, Beef) each. These are not pre-defined and can be whatever you want them to be. This makes your recipes easier to find.
                                                    </p>
                                                    <p>
                                                    Recipes can be moved from one recipe type or category to another just using drag and drop in the recipe menu.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Password Protection</h3>
                                            <div class=myacc>
                                                    <p>
                                                    A user name and password are required to access your shared recipes.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Add Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Recipes can be copied from anywhere on the internet, or wherever you may have them stored on your computer and pasted in.
                                                    </p>
                                                    <p>
                                                    Recipes can be added manually using the recipe editor. Items which already exist in your database can be selected from dropdown lists as you type to make finding specific items easier. 
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Import Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    Recipes can be imported in bulk from other recipe databases or programs in Meal Master or CSV format.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Copy Recipes</h3>
                                            <div class=myacc>
                                                    <p>
                                                    This is very useful if you wish to create a new recipe based on a similar one.
                                                    </p>
                                            </div>
                                            <h3 class=myacc>Add Images, a video/movie or a PDF document</h3>
                                            <div class=myacc>
                                                <p>
                                                Ten images and a PDF document can be stored with each recipe. These can be uploaded from your PC. Any image uploaded will be automatically resized. Images can be displayed or hidden while displaying a recipe to increase/decrease screen area as desired.
                                                </p>
                                             </div>
                                             <h3 class=myacc>Rate and comment on recipes</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Each user can rate a recipe from 0 to 5 stars or comment on it.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Dynamic Databse Driven Menu</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Access to your recipes is via a menu which is dynamically built and based on the recipe types and categories you have chosen for your recipes. This menu can be displayed or hidden while displaying a recipe.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Favorites</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Recipes can be designated as favorites, so they appear at the top of the menu, and are easily accessed.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Related Recipes</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Recipes can be linked to a related recipe, related recipes will then be displayed along with the recipe.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Print Recipes</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Recipes can be printed out individually if required.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Create an eBook</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Just select the recipes you wish to include, click "create" and a pdf file will be created which you can download to your PC. Then you can print it so you have a copy of your recipes on paper, or publish it on the web. It's up to you. Your eBook has optional table of contents and category title pages and includes any images/pdfs you have stored with your recipes.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Email Recipes</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Recipes can be emailed to the address/addresses of your choice.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Recipe Search</h3>
                                             <div class=myacc>
                                                     <p>
                                                     There are seven methods for searching your recipes:
                                                     </p>
                                                     <ul class=list>
                                                             <li>Via keyword/s.</li>
                                                             <li>Enter a list of ingredients you have at hand. You may enter as many ingredients as you wish and specify whether all or any of them must appear in the list of recipes returned.</li>
                                                             <li>By rating.</li>
                                                             <li>Select the recipe from a list of recipes in your database.</li>
                                                             <li>By Diet.</li>
                                                             <li>By cuisine.</li>
                                                             <li>By source.</li>
                                                     </ul>
                                             </div>
                                             <h3 class=myacc>Export Recipes</h3>
                                             <div class=myacc>
                                                     <p>
                                                     Recipes may be exported in Meal Master, Microsoft Word or Excel(CSV) format. You can select to export as many recipes as you wish from a list of recipes in your shared database.
                                                     </p>
                                             </div>
                                             <h3 class=myacc>Full Screen View</h3>
                                            <div class=myacc>
                                                    <p>
                                                    View a recipe in fullscreen mode, for optimal use of screen space.
                                                    </p>
                                                    
                                            </div>
                                        </div>
                                        <h3 class=myacc>User Management</h3>
                                        <div class="accordion myacc">
                                            <h3 class=myacc>Four Levels of User Access</h3>
                                            <div class=myacc>
                                                    <p>Guest (read only), User, Administrator, Owner. See the Account Area section below for more details.</p>
                                            </div>
                                            <h3 class=myacc>Account Area</h3>
                                            <div class=myacc>
                                                    <p>Here you can:</p>
                                                    <ul class=list>
                                                            <li>Change/reset your password.</li>
                                                            <li>Edit your personal details.</li>
                                                            <li>Contact us.</li>
                                                            <li>View our policies.</li>
                                                            <li>Search our knowledgebase.</li>
                                                            <li>Request support.</li>
                                                            <li>Manage your preferences/defaults.</li>
                                                            <li>Manage your recipe data
                                                                    <ul>
                                                                            <li>Recipe names</li>
                                                                            <li>Ingredients</li>
                                                                            <li>Units of measure</li>
                                                                            <li>Preparation/notes</li>
                                                                            <li>Yield Units</li>
                                                                    </ul>
                                                            </li>
                                                            <li>Log Out</li>
                                                    </ul>
                                                    <p>If you are an administrator you can also:</p>
                                                    <ul class=list>
                                                            <li>Manage existing users.</li>
                                                            <li>Create users.</li>
                                                            <li>Permanently delete recipes.</li>
                                                            <li>Monitor and manage recipe comments.</li>
                                                            <li>Approve recipes if this is a requirement of the database owner.</li>
                                                            <li>Manage recipe types and categories for your shared database</li>
                                                    </ul>
                                                    <p>If you are owner of the shared database you can also:</p>
                                                    <ul class=list>
                                                            <li>Remove your account</li>
                                                            <li>Transfer ownership of your shared database</li>
                                                            <li>Determine whether recipe approval is required for your shared database</li>
                                                            <li>View your subscriptions, orders, support tickets, correspondence or invoices.</li>
                                                            <li>Order/Upgrade subscriptions.</li>
                                                            <li>Edit/update your credit card details to enable automated payment of your subscriptions when due.</li>
                                                    </ul>
                                            </div>
                                        </div>
                                        <h3 class=myacc>Responsive Design</h3>
                                        <div class=myacc>
                                                <p>
                                                Displays correctly on any device - Desktop, Laptop, Tablet or Phone
                                                </p>
                                        </div>
                                        
                                        <h3 class=myacc>Menu Planner</h3>
                                        <div class=myacc>
                                                <p>
                                                Plan up to a week of meals. You can simply drag recipes from the menu to add them to your menu. Menus can be saved, deleted or edited.
                                                </p>
                                        </div>
                                        <h3 class=myacc>Shopping Lists</h3>
                                        <div class=myacc>
                                                <p>
                                                Shopping lists can be generated from your weekly menu.</p><p>Recipes can also be dragged from the menu to add the ingredients to your list.</p><p>All ingredients will have either the image of the recipe(if stored with the recipe) or it's name so you can identify where the ingredient came from.</p><p>To remove all the ingredients for a recipe from the list just click on the image or name.</p><p>Extra items can be added or items removed before printing or viewing in shopping mode at your supermarket.</p><p>Ingredients can be organised into Aisles which you can order as you wish to match those in your local supermarket.</p><p>There is also a built in exclusion list where you can select ingredients that you don't want to be added to your shopping lists. Things like water, pepper and salt, or other things you always have on hand.</p><p>Shopping lists can be saved for future use.
                                                </p>
                                        </div>                                        
                                </div>
                        </div>  
        <?php
                require_once('includes/hbottom.php');
        ?>
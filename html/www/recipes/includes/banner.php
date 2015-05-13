<body id="top" data-twttr-rendered="true">
        <nav class="navbar navbar-default navbar-fixed-top sb-slide nofs" role="navigation">
                <?php
			        if (!isset($public)) {
                            echo '
                            <div class="sb-toggle-left navbar-left">
                                    <div class="navicon-line"></div>
                                    <div class="navicon-line"></div>
                                    <div class="navicon-line"></div>
                            </div>';
                    }
                    if (curPageName() != 'export.php' && curPageName() != 'delete.php' && curPageName() != 'pasterules.php'
			            && curPageName() != 'check-comments.php' && curPageName() != 'transfer.php' && curPageName() != 'pp-backend.php' && curPageName() != 'drp-backend.php'
			            && curPageName() != 'sitemap-backend.php' && curPageName()!='input_format.php' && curPageName()!='pasterules.php'
                                        && curPageName()!='upload_multi_images.php'&& curPageName()!='import_format.php'
			            && curPageName()!='measures.php') {
                            echo '
                            <div class="sb-toggle-right navbar-right">
                                    <img alt="Page Help" src="images/qm.png">
                            </div>';
			        }
                ?>
                <div class="container">
                        <div id="logo" class="navbar-left">
                                <a href="index.php">
                                <img width="200" height="40" alt="Web Recipe Manager Logo" src="images/slidebars-logo@2x.png">
                                </a>
                        </div>
                        <?php
					if (!isset($public)) {
						echo '<ul class="nav">';
						if (curPageName()!='display.php') {
								print("
								<li><a href='display.php'>Recipes</a></li>
								");
						} else {
                            if(isset($_COOKIE['welcome'])) {
                                $welcome=$_COOKIE['welcome'];
                            }
							if ((isset($welcome) && $welcome) || $recipes==0) {
								print("
								<li id=toprhdr><a href='javascript:void(0);'>Welcome</a></li>");
							} else {
								print("
								<li><a href='javascript:void(0);'>Recipe</a>
									<ul class=recopt>");
										if (isset($admin) and isset($unapproved)) {
											print("<li><a href='javascript:void(0);' class=approve>Approve</a></li>
											<li><a href='javascript:void(0);' onclick=document.form1.action='add-recipe.php?edit=Edit';document.form1.submit()>Edit</a></li>
											<li><a href='javascript:void(0);' class=delrecipe >Delete</a></li>
											<li><a href='display.php'>Display Approved Recipes</a></li>");
										} else {
                                            if(isset($guest)) {
                                                print("
                                                        <li><a href='javascript:void(0);' class=rsrecipe >Resize</a></li>
                                                        <li><a href='javascript:void(0);'>Convert</a>
                                                            <ul>");
                                                $numfmt=$_COOKIE['numfmt'];
                                                $fracdec=$_COOKIE['fracdec'];
                                                $myregion=$_COOKIE['region'];
                                                $groroz=$_COOKIE['groroz'];
                                                if ($myregion=='notset' || $fracdec=='notset' || $numfmt=='notset' || $groroz=='notset') {
                                                    echo "<li><a href='userpref.php'>You must set all preferences for recipe conversion before you can convert a recipe. Click to update your preferences.</a></li>";
                                                } else {                                                                                                                    
                                                    if ($myregion!='Australia') {
                                                        print("<li><a href='javascript:void(0);' class=convertau>Australia to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='Canada') {
                                                        print("<li><a href='javascript:void(0);' class=convertca>Canada to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='Metric') {
                                                        print("<li><a href='javascript:void(0);' class=converteu>Metric to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='New Zealand') {
                                                        print("<li><a href='javascript:void(0);' class=convertnz>New Zealand to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='UK') {
                                                        print("<li><a href='javascript:void(0);' class=convertuk>UK to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='USA') {
                                                        print("<li><a href='javascript:void(0);' class=convertus>USA to $myregion</a></li>");
                                                    }
                                                }
                                                print("</ul>
                                                        </li>
                                                        <li><a href='javascript:void(0);' onclick='window.print()'>Print</a></li>
                                                        <li><a href='email.php'>Email</a></li>
                                                        <li><a href='export.php?indv=yes'>Export</a></li>
                                                        <li><a href='ebook.php?indv=yes'>Create eBook</a></li>
                                                        <li><a href='javascript:void(0);' class=addfav>Add to Favorites</a></li>
                                                        <li><a href='javascript:void(0);' class=delfav>Remove from Favorites</a></li> 
                                                        <li><a href='javascript:void(0);' class=fs>Fullscreen View</a></li>");
                                            } else {
											    print("
													    <li><a href='javascript:void(0);' class=delrecipe >Delete</a></li>
													    <li><a href='javascript:void(0);' class=editrecipe >Edit</a></li>
													    <li><a href='javascript:void(0);' class=rsrecipe >Resize</a></li>
                                                        <li><a href='javascript:void(0);'>Convert</a>
                                                            <ul>");
                                                $numfmt=$_COOKIE['numfmt'];
                                                $fracdec=$_COOKIE['fracdec'];
                                                $myregion=$_COOKIE['region'];
                                                $groroz=$_COOKIE['groroz'];
                                                if ($myregion=='notset' || $fracdec=='notset' || $numfmt=='notset' || $groroz=='notset') {
                                                    echo "<li><a href='userpref.php'>You must set all preferences for recipe conversion before you can convert a recipe. Click to update your preferences.</a></li>";
                                                } else {
                                                    if ($myregion!='Australia') {
                                                        print("<li><a href='javascript:void(0);' class=convertau>Australia to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='Canada') {
                                                        print("<li><a href='javascript:void(0);' class=convertca>Canada to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='Metric') {
                                                        print("<li><a href='javascript:void(0);' class=converteu>Metric to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='New Zealand') {
                                                        print("<li><a href='javascript:void(0);' class=convertnz>New Zealand to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='UK') {
                                                        print("<li><a href='javascript:void(0);' class=convertuk>UK to $myregion</a></li>");
                                                    }
                                                    if ($myregion!='USA') {
                                                        print("<li><a href='javascript:void(0);' class=convertus>USA to $myregion</a></li>");
                                                    }
                                                }
                                                print("</ul>
                                                        </li>
													    <li><a href='javascript:void(0);' class=copyrec>Copy</a></li>
													    <li><a href='javascript:void(0);' onclick='window.print()'>Print</a></li>
                                                        <li><a href='email.php'>Email</a></li>
                                                        <li><a href='export.php?indv=yes'>Export</a></li>
                                                        <li><a href='ebook.php?indv=yes'>Create eBook</a></li> 
													    <li><a href='javascript:void(0);' class=addfav>Add to Favorites</a></li>
													    <li><a href='javascript:void(0);' class=delfav>Remove from Favorites</a></li>
													    <li><a href='javascript:void(0);' class=fs>Fullscreen View</a></li>
                                                        ");
                                            }
										}
									print("</ul>
								</li>
								");
							}
						}
                        if(isset($guest)) {
                            print("<li><a href='javascript:void(0);'>Tools</a>
                                    <ul>
                                        <li><a href='export.php'>Export</a></li>
                                        <li><a href='ebook.php'>Create eBook</a></li>
                                    </ul>
                                </li>");
                        } else {
						    print("<li><a href='javascript:void(0);'>Tools</a>
								    <ul>
									    <li><a href='javascript:void(0);'>Add Recipe</a>
										    <ul>
											    <li><a href='pasterecipe.php'>Copy & Paste</a></li>
											    <li><a href='add-recipe.php'>Enter Manually</a></li>
										    </ul>
									    </li>
									    <li><a href='import_multi_recipes.php'>Import</a></li>
									    <li><a href='export.php'>Export</a></li>
									    <li><a href='ebook.php'>Create eBook</a></li>
									    <li><a href='delete.php'>Delete Recipes</a></li>
								    </ul>
							    </li>");
                        }
                        if(!isset($guest)) {
						    print("<li><a href='javascript:void(0);'>Menu Planning</a>
								    <ul>
									    <li><a href='menuplanner.php'>Meal Planner</a></li>
									    <li><a href='shopping-list.php'>Shopping Lists</a></li>
									    <li><a href='excl-list.php'>Manage Ingredient Exclusion List</a></li>
									    <li><a href='orderaisles.php'>Manage Aisle Order</a></li>
								    </ul>
							    </li>");
                        }
						print("<li><a href='search.php'>Search</a></li>
							<li><a href='javascript:void(0);'>Account</a>
								<ul>");
                            print("<li><a href='userpref.php'>Preferences</a></li>");
                            if($client!='wrm') {
                                print("<li><a href='profmaint.php?action=pw'>Change Password</a></li>
                                        <li><a href='profmaint.php'>Update Profile</a></li>");
                            }
							if ($client=='wrm' && ($user!='demo' && substr($user,0,5)!='demo_' && !isset($guest))) {
								echo '<li><a href="'.$scpath.'aLogIn.php?als='.$sendstr.'" target=_BLANK>Account Home</a></li>';
							}
							if ($client=='wrm' && ($user!='demo' && substr($user,0,5)!='demo_' && $user==$owner)) {
								print("
									<li><a href='transfer.php'>Transfer DB Ownership</a></li>
                                    <li><a href='javascript:void(0);' class=deldb id='".$owner."' >Cancel My Account</a></li>
								");
							}

							if (isset($admin)) {
								print("<li><a href='javascript:void(0);'>Admin</a>
									<ul>
										<li><a href='check-comments.php'>Check Comments</a></li>
										<li><a href='usermgmt.php'>Manage Users</a></li>
										<li><a href='recipeownermgmt.php'>Manage Recipe Owners</a></li>");
								if (isset($rapp)) {
									print("<li><a href='display.php?unapproved=yes'>Approve Recipes</a></li>");
								}
								print("<li><a href='createusers.php'>Create Users</a></li>
										<li><a href='javascript:void(0);'>Manage Recipe Types & Categories</a>
											<ul>
												<li><a href='normalise-cat.php'>Manage Recipe Types</a></li>
												<li><a href='normalise-subcat.php'>Manage Categories</a></li>
											</ul>
										</li>
										<li><a href='manage-deleted-recipes.php'>Manage Deleted Recipes</a></li>");
                                if($client!='wrm') {
                                    echo "<li><a href='userapp.php'>Approve Users</a></li>";
                                }
                                    
								echo'</ul>
								  </li>';
							}
                            if (!isset($guest)) {							
                                print("
							    <li><a href='javascript:void(0);'>Manage Data</a>
								    <ul>
									    <li><a href='normalise.php'>Manage Ingredients</a></li>
									    <li><a href='normalise-unit.php'>Manage Units of Measure</a></li>
									    <li><a href='normalise-preprep.php'>Manage Prepreparation/Notes</a></li>
									    <li><a href='normalise-recipe.php'>Manage Recipe Names</a></li>
									    <li><a href='normalise-yu.php'>Manage Yield Units</a></li>
								    </ul>
							    </li>");
                            }
							print("<li><a href='display.php?logout=yes'>Logout</a></li>
						</ul>
					</li>
					<li><a href='javascript:void(0);'>Help</a>
						<ul>");

						if ($client=='wrm' && ($user=='demo' || substr($user,0,5) == 'demo_')){
							print("
								<li><a href='contact-backend.php' target=_blank>Support & Feedback</a></li>
								<li><a href='".$scpath."news.php' target=_BLANK>News</a></li>
								<li><a href='measures.php' target=_blank>International volume measures</a></li>
							");
						} else if ($client=='wrm') {
							print("
								<li><a href='".$scpath."kb.php' target=_BLANK>Knowledge Base</a></li>
								<li><a href='".$sscpath."aLogIn.php?als=".$sendstr."&subaction=helpdesk.php' target=_BLANK>Support</a></li>
								<li><a href='".$scpath."news.php' target=_BLANK>News</a></li>
								<li><a href='measures.php' target=_blank>International volume measures</a></li>
							");
						} else {
                             print("
                                    <li><a href='faqs-be.php'>FAQs</a></li>
                                    <li><a href='contact-backend.php'>Support</a></li>
                                    <li><a href='contact-backend.php'>Contact Us</a></li>
                                    <li><a href='sitemap-backend.php'>Sitemap</a></li>
                                    <li><a href='measures.php' target=_blank>International volume measures</a></li>
                                ");
                        }
						print("
					            </ul>
				        </li>
                    <li>
                        <a id='top-arrow' href='#top'>^</a>
                    </li>
			</ul>");
					}
					?>
                </div>
        </nav> 
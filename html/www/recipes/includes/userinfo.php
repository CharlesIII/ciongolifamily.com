<?php
	echo '<div class="p10 bb"><strong>welcome </strong><span id=curruser>',$suser,'</span><br class=noprint>';
	
	if (isset($admin)) {
		if (isset($recipes)) {
			if ($recipes==1) {
				echo '<strong>You have: </strong><span id=numrec>',$recipes,'</span> recipe<br class=noprint>';
			} else {
				echo '<strong>You have: </strong><span id=numrec>',$recipes,'</span> recipes<br class=noprint>';
			}
		}
        if (isset($hidden) && $hidden>0) {
            if ($hidden==1) {
                echo '<strong>Hidden Recipes: </strong><span id=numhidden>',$hidden,'</span><br class=noprint>';
            } else {
                echo '<strong>Hidden Recipes: </strong><span id=numhidden>',$hidden,'</span><br class=noprint>';
            }
        }
		if (isset($rapp)) {
			echo '<strong>Approved Recipes: </strong><span id=numapp>'.$appct.'</span><br class=noprint>';
			echo '<strong>Unapproved Recipes: </strong><span id=numunapp>'.$unapprec.'</span><br class=noprint><br class=noprint>';
		}
		if (isset($users)) {
            if($client=='wrm') {
			    if ($users==1) {
				    echo '<strong>You have: </strong>',$users,' user<br class=noprint>';
			    } else {
				    echo '<strong>You have: </strong>',$users,' users<br class=noprint>';
			    }
            } else {
                if ($users==1) {
                    echo '<strong>You have: </strong>',$users,' approved user<br class=noprint>';
                } else {
                    echo '<strong>You have: </strong>',$users,' approved users<br class=noprint>';
                }
                if($uausers>0) {
                    if ($uausers==1) {
                        echo '<strong>You have: </strong>',$uausers,' unapproved user<br class=noprint>';
                    } else {
                       echo '<strong>You have: </strong>',$uausers,' unapproved users<br class=noprint>';
                    }
                    
                }
            }
		}
		echo '<strong>Your user Limit is: </strong>';
		echo $limit;
	} else {
		if (isset($recipes)) {
			if ($recipes==1) {
				echo '<strong>You have: </strong>',$recipes,' shared recipe<br class=noprint>';
			} else {
				echo '<strong>You have: </strong>',$recipes,' shared recipes<br class=noprint>';
			}
		}
		if (isset($urecipes) && $urecipes>0) {
			if ($urecipes==1) {
				echo '<strong>Of those recipes: </strong>',$urecipes,' is yours<br class=noprint>';
			} else {
				echo '<strong>Of those recipes: </strong>',$urecipes,' are yours<br class=noprint>';
			}
		}
	}
	echo '</div>';
	if (!isset($public)) {
		echo '<div id=sidenav>';
		echo '<h3 class=p10><strong>navigation</strong></h3>';
		echo '<nav><ul class="sb-menu">';
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
				<li id=siderhdr><a class='sb-toggle-submenu' >Welcome</a></li>
				");
			} else {
				print("
				<li class='siderhdr'><a class='sb-toggle-submenu' >Recipe<span class='sb-caret'></span></a>
					<ul class='recopt sb-submenu'>");
						if (isset($admin) and isset($unapproved)) {
							print("<li><a class=approve>Approve</a></li>
							<li><a onclick=document.form1.action='add-recipe.php?edit=Edit';document.form1.submit()>Edit</a></li>
							<li><a class=delrecipe >Delete</a></li>
							<li><a href='display.php'>Display Approved Recipes</a></li>");
						} else {
                            if(isset($guest)) {
                                print("
                                        <li><a class=rsrecipe>Resize</a></li>
                                        <li><a class='sb-toggle-submenu' >Convert<span class='sb-caret'></span></a>
                                            <ul class='sb-submenu'>");
                                        $numfmt=$_COOKIE['numfmt'];
                                        $fracdec=$_COOKIE['fracdec'];
                                        $myregion=$_COOKIE['region'];
                                        $groroz=$_COOKIE['groroz'];
                                        if ($myregion=='notset' || $fracdec=='notset' || $numfmt=='notset' || $groroz=='notset') {
                                            echo "<li><a href='userpref.php'>You must set all preferences for recipe conversion before you can convert a recipe. Click to update your preferences</a></li>";
                                        } else {
                                            if ($myregion!='Australia') {
                                                print("<li><a class=convertau>Australia to $myregion</a></li>");
                                            }
                                            if ($myregion!='Canada') {
                                                print("<li><a class=convertca>Canada to $myregion</a></li>");
                                            }
                                            if ($myregion!='Metric') {
                                                print("<li><a class=converteu>Metric to $myregion</a></li>");
                                            }
                                            if ($myregion!='New Zealand') {
                                                print("<li><a class=convertnz>New Zealand to $myregion</a></li>");
                                            }
                                            if ($myregion!='UK') {
                                                print("<li><a class=convertuk>UK to $myregion</a></li>");
                                            }
                                            if ($myregion!='USA') {
                                                print("<li><a class=convertus>USA to $myregion</a></li>");
                                            }
                                        }
                                        print("</ul>
                                                </li>
                                        <li><a onclick='window.print()'>Print</a></li>
                                        <li><a href='email.php'>Email</a></li>
                                        <li><a href='export.php?indv=yes'>Export</a></li>
                                        <li><a href='ebook.php?indv=yes'>Create eBook</a></li> 
                                        <li><a class=addfav>Add to Favorites</a></li>
                                        <li><a class=delfav>Remove from Favorites</a></li>
                                        <li><a class='fs sb-close'>Fullscreen View</a></li>");
                            } else {
							    print("
								<li><a class=delrecipe>Delete</a></li>
								<li><a class=editrecipe>Edit</a></li>
								<li><a class=rsrecipe>Resize</a></li>
                                <li><a class='sb-toggle-submenu' >Convert<span class='sb-caret'></span></a>
                                            <ul class='sb-submenu'>");
                                $numfmt=$_COOKIE['numfmt'];
                                $fracdec=$_COOKIE['fracdec'];
                                $myregion=$_COOKIE['region'];
                                $groroz=$_COOKIE['groroz'];
                                if ($myregion=='notset' || $fracdec=='notset' || $numfmt=='notset' || $groroz=='notset') {
                                    echo "<li><a href='userpref.php'>You must set all preferences for recipe conversion before you can convert a recipe. Click to update your preferences</a></li>";
                                } else {
                                    if ($myregion!='Australia') {
                                        print("<li><a class=convertau>Australia to $myregion</a></li>");
                                    }
                                    if ($myregion!='Canada') {
                                        print("<li><a class=convertca>Canada to $myregion</a></li>");
                                    }
                                    if ($myregion!='Metric') {
                                        print("<li><a class=converteu>Metric to $myregion</a></li>");
                                    }
                                    if ($myregion!='New Zealand') {
                                        print("<li><a class=convertnz>New Zealand to $myregion</a></li>");
                                    }
                                    if ($myregion!='UK') {
                                        print("<li><a class=convertuk>UK to $myregion</a></li>");
                                    }
                                    if ($myregion!='USA') {
                                        print("<li><a class=convertus>USA to $myregion</a></li>");
                                    }
                                }
                                print("</ul>
                                        </li>
								        <li><a class=copyrec>Copy</a></li>
								        <li><a onclick='window.print()'>Print</a></li>
                                        <li><a href='email.php'>Email</a></li>
                                        <li><a href='export.php?indv=yes'>Export</a></li>
                                        <li><a href='ebook.php?indv=yes'>Create eBook</a></li> 
                                        <li><a class=addfav>Add to Favorites</a></li>
								        <li><a class=delfav>Remove from Favorites</a></li>
								        <li><a class='fs sb-close'>Fullscreen View</a></li>");
                            }
						}
					print("</ul>
				</li>
				");
			}
		}
        if(isset($guest)) {
            print("<li><a href='javascript:void(0);' class='sb-toggle-submenu' >Tools<span class='sb-caret'></span></a>
                    <ul class='sb-submenu'>
                        <li><a href='export.php'>Export Recipes</a></li>
                        <li><a href='ebook.php'>Create eBook</a></li>
                    </ul>
                </li>");
        } else {
		    print("<li><a href='javascript:void(0);' class='sb-toggle-submenu' >Tools<span class='sb-caret'></span></a>
				    <ul class='sb-submenu'>
					    <li><a href='javascript:void(0);' class='sb-toggle-submenu' >Add Recipe<span class='sb-caret'></span></a>
						    <ul class='sb-submenu'>
							    <li><a href='pasterecipe.php'>Copy & Paste</a></li>
							    <li><a href='add-recipe.php'>Enter Manually</a></li>
						    </ul>
					    </li>
					    <li><a href='import_multi_recipes.php?'>Import Recipes</a></li>
					    <li><a href='export.php'>Export Recipes</a></li>
					    <li><a href='ebook.php'>Create eBook</a></li>
					    <li><a href='delete.php'>Delete Recipes</a></li>
				    </ul>
			    </li>");
        }
        if(!isset($guest)) {
		    print("<li><a class='sb-toggle-submenu' >Menu Planning<span class='sb-caret'></span></a>
				    <ul class='sb-submenu'>
					    <li><a href='menuplanner.php'>Meal Planner</a></li>
					    <li><a href='shopping-list.php'>Shopping Lists</a></li>
					    <li><a href='excl-list.php'>Manage Ingredient Exclusion List</a></li>
					    <li><a href='orderaisles.php'>Manage Aisle Order</a></li>
				    </ul>
			    </li>");
        }
		print("<li><a href='search.php'>Search</a></li>
			<li><a href='javascript:void(0);' class='sb-toggle-submenu' >Account<span class='sb-caret'></span></a>
				<ul class='sb-submenu'>");
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
					<li><a href='transfer.php>Transfer Ownership</a></li>
                    <li><a href='javascript:void(0);' class=deldb id='$owner' >Cancel My Account</a></li>
				");
			}

			if (isset($admin)) {
				print("<li><a href='javascript:void(0);' class='sb-toggle-submenu' >Admin<span class='sb-caret'></span></a>
					<ul class='sb-submenu'>
						<li><a href='check-comments.php'>Check Comments</a></li>
						<li><a href='usermgmt.php'>Manage Users</a></li>");
				if (isset($rapp)) {
					print("<li><a href='display.php?unapproved=yes'>Recipe Approval</a></li>");
				}
				print("<li><a href='createusers.php'>Create Users</a></li>
						<li><a class='sb-toggle-submenu' >Manage Recipe Types & Categories<span class='sb-caret'></span></a>
							<ul class='sb-submenu'>
								<li><a href='normalise-cat.php'>Manage Recipe Types</a></li>
								<li><a href='normalise-subcat.php'>Manage Categories</a></li>
							</ul>
						</li>
						<li><a href='manage-deleted-recipes.php'>Manage Deleted Recipes</a></li>
					</ul>
				  </li>");
			}
            if (!isset($guest)) {
			    print("
			    <li><a href='javascript:void(0);' class='sb-toggle-submenu' >Manage My Data<span class='sb-caret'></span></a>
				    <ul class='sb-submenu'>
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
	<li><a class='sb-toggle-submenu' >Help<span class='sb-caret'></span></a>
		<ul class='sb-submenu'>");

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
                ");
        }
		print("</ul></li></ul></nav></div>");
	}
?>
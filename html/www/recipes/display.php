<?php
    require_once('includes/top.php');
    
    if (!isset($user) && !isset($public)) {
            exit;
    }                       
    if (isset($_GET['unapproved'])) {
        $unapproved=$_GET['unapproved'];
        if($client=='wrm') {
            $sql = "$call query_latest_unapproved(:oid)";  //return all recipes from db
            $result = $rdb->prepare($sql);
            $result->bindValue(':oid', $oid);
            $result->execute();
            $err=$rdb->errorInfo();
        } else {
            $sql = "$call query_latest_unapproved()";  //return all recipes from db
            $result = $rdb->prepare($sql);
            $result->execute();
            $err=$rdb->errorInfo();
        }
        $recrows=$result->rowCount();
        $rsresult = $result->fetch(PDO::FETCH_BOTH);
        $result->closeCursor();
        $id=$rsresult[0];
    }
?>
        <title>Display Recipes</title>
        <meta name="description" content="View your recipes any time anywhere on any device.">
        <script src="js/my.image.js"></script>
        <script src="js/my.display.js"></script>
        <script src="js/decode.min.js"></script>
        <script src="js/jquery.rating.pack.js"></script>
        <script src="js/my.rating.js"></script>
        <script src="js/my.comment.js"></script>
        <script src="js/jquery.leanModal.min.js"></script>
        <script src="js/leanmobile.js"></script>
        <script src="js/my.quantities.js"></script>
        <script src="galleria/galleria-1.4.2.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <link href="css/printrecipe.css" rel="stylesheet" type="text/css" media="print">
</head>
    <div class='ok message_box' style="display:none;"></div>
    <?php
    
    if (isset($_GET['suspended'])) {
            $susmsg=$_GET['susmsg'];
            echo "<script type='text/javascript'>
                $('.message_box').removeClass('ok');
                $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                $('.message_box').show();
            </script>";
    }
    ?>
    <div class="loginmodal int" style="display:none;">
        <h3>
         <span>International Measures</span>
        </h3>
        <a class="modal_close" href="#"></a>
        <table border=1 cellpadding=4 style="text-align:center;border-collapse:collapse;">
        <tr>
        <th style="text-align: left">Measure</th>
        <th style="text-align: center;color:#A15883;">Australia</th>
        <th style="text-align: center;color:#A15883;">Canada</th>
        <th style="text-align: center;color:#A15883;">UK</th>
        <th style="text-align: center;color:#A15883;">USA</th>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Teaspoon</td>
        <td colspan="3">5 mL</td>
        <td>4.93 mL</td>
        </tr>
        <tr>

        <td align="left" style="color:#A15883;">Dessertspoon</td>
        <td colspan="3">10 mL</td>
        <td></td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Tablespoon</td>
        <td>20 mL</td>
        <td colspan="2">15 mL</td>
        <td>14.79 mL</td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Fluid ounce</td>
        <td colspan="3">28.41 mL</td>
        <td>29.57 mL</td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Cup</td>
        <td colspan="2" align="center">250 mL</td>
        <td>284.1 mL</td>
        <td>236.59 mL</td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Pint</td>
        <td colspan="3">568.26 mL</td>
        <td>473.18 mL</td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Quart</td>
        <td colspan="3">1136.52 mL</td>
        <td>946.35 mL</td>
        </tr>
        <tr>
        <td align="left" style="color:#A15883;">Gallon</td>
        <td colspan="3">4546.09 mL</td>
        <td>3785.41 mL</td>
        </tr>
        </table>
    </div>
    <?php
        require_once('includes/banner.php');
    ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
                                
                                <form id=form1 name='form1' method='post' enctype='multipart/form-data'>
                                    <div id=wscreen style='display:none'>
                                        <h1><strong>Welcome To Web Recipe Manager</strong></h1>
                                        <p id=view>To view a recipe, click on the menu icon at the top left of the page and select it from the menu</p>
                                        <img id=welcomeimg src=images/purple-sweet-potato-soup-2013.jpg>
                                    </div>
                                    <div id=norecipes style='display:none'>
                                        <?php 
                                            if (isset($unapproved)) {
                                               echo '<h3>There are no recipes requiring approval</h3>
                                               <br>
                                               <INPUT type=button value="Display Approved Recipes" class="btn dispapproved">';
                                            } else {
                                               echo '<h3>There are no recipes to display, go to the "Tools" menu to start adding recipes</h3>'; 
                                            }
                                        ?>                                        
                                    </div>
                                    
                                        <div id=title style='display:none;'>
                                            <h3></h3>
                                            <input type=hidden name='name' value=''>
                                            <br class=noprint>
                                            <input name='star2' type='radio' class='star star_1' title='1 Star'>
                                            <input name='star2' type='radio' class='star star_2' title='2 Stars'>
                                            <input name='star2' type='radio' class='star star_3' title='3 Stars'>
                                            <input name='star2' type='radio' class='star star_4' title='4 Stars'>
                                            <input name='star2' type='radio' class='star star_5' title='5 Stars'>
                                            <span class=noprint><b id=rnum></b></span>
                                            <input type=hidden name='rating' value=>
                                        </div>
                                        <?php
                                            echo'<div id=demolinks style="display:none;">';
                                            if ($client=='wrm' && ($user=='demo' || substr($user,0,5) == 'demo_' || isset($public))) {
                                                echo'<a id=link_image href="sign-up.php" style="margin-right:10px;"><div id=sutext>Sign Up </div><div class="arrow-right"></div></a><a id=link_image href="purchase.php"><div id=sutext>Buy </div><div class="arrow-right"></div></a><br class=noprint>';
                                            }
                                            print("</div>");
    
                                            if (isset($admin) and isset($unapproved)) {
                                                    print("<div class=appbuttons style='display:none'><br class=noprint><br class=noprint>
                                                        <div>
                                                            <div class='dib'>
                                                                <INPUT type=button value='Approve' class='btn approve'>
                                                            </div>
                                                            <div class='dib'>
                                                                <INPUT type=button value='Delete' class='btn delrecipe'>
                                                            </div>
                                                            <div class='dib'>
                                                                <INPUT type=button value='Display Approved Recipes' class='btn dispapproved'>
                                                            </div>
                                                        </div>
                                                    </div>");
                                            } else {
                                                    //echo '<div id=commentlink style="display:none;"><br class=noprint><a href="#comment">Add A Comment</a><br class=noprint></div>';
                                            }
                                        ?>
                                        <INPUT type=button class="nm btn" value="Normal View">
                                        <br class=noprint><br class=noprint>
                                        <div>
                                            <div class='imagedisp image1' style='display:none'>
                                                <br>
                                                <a href='#' id=hideimg>Hide images</a>
                                                <br><br>
                                                <input type=hidden name='image0' value=''>
                                            </div>
                                            <div id=ingdisp style='display:none'>
                                            </div>
                                        </div>
                                        <div id=showimg style='display:none'>
                                            <br class=noprint>
                                            <span>
                                                <a href="#" >Show Images</a>
                                                <br><br>
                                            </span>
                                        </div>
                                        <div id=revertmsg style='display:none'>
                                            <?php
                                                if (isset($guest)) {
                                                    echo '<strong>The quantities in the original recipe have not been changed. Resizing is temporary.</strong>';
                                                } else {
                                                    echo '<strong>The quantities in your original recipe have not been changed. Resizing is temporary. If you wish to save the recipe with the new quantities, select edit from the "Recipe" menu, make any adjustments required and save the recipe.</strong>';
                                                }
                                            ?>
                                            <br><br>
                                            <a class='btn' id=revert>Revert to Original Recipe</a>
                                            <br><br>
                                        </div>
                                        <div id=convertmsg style='display:none'>
                                            <?php
                                                if (isset($guest)) {
                                                    echo '<strong>The quantities in the original recipe have not been changed. Conversion is temporary.</strong>';
                                                } else {
                                                    echo '<strong>The quantities in your original recipe have not been changed. Conversion is temporary. If you wish to save the recipe with the new quantities, select edit from the "Recipe" menu, make any adjustments required and save the recipe.</strong>';
                                                }
                                            ?>
                                            <br><br>
                                            <a class='btn' id=convertrevert>Revert to Original Recipe</a>
                                            <br><br>
                                        </div>
                                        <div id=video style='display:none'>
                                        </div>
                                        <div id=note style='display:none;'>
                                            <input type=hidden name=note value="">
                                            <strong class=rheader>Notes</strong>
                                            <br><br>
                                        </div>
                                        <div id=directions style='display:none;'>
                                            <input type=hidden name=directions value="">
                                            <strong class=rheader>Directions</strong>
                                            <br><br>
                                        </div>
                                        <div id=pdf style='display:none;'>    
                                            <br>
                                            <a href="#" class=hidepdf>Hide PDF Image</a><br>
                                            <span style="display:none" id=showpdf><a href="#" >Show PDF Image</a></span>
                                            <img class=pdf src="">
                                            <br>
                                            <a href="#" class=hidepdf>Hide PDF Image</a><br>
                                            <br>
                                            <span><strong>Link to Original PDF Document:</strong><a href="" target=_BLANK></a></span>
                                            <br>
                                            <input type=hidden name='pdf' value=''>
                                            <br>
                                        </div>
                                        <div id=yielddiv style='display:none;'>
                                            <input type=hidden name='yield' id=yield value=''>
                                            <input type=hidden name='oldyield' id=oldyield value=''>
                                            <strong>Makes:</strong>                                            
                                        </div>
                                        <div id=measure style='display:none;'>
                                            <input type=hidden name='measure' value=''>
                                            <input type=hidden name='oldmeasure' value=''>
                                            <strong>Measurement System:</strong>
                                            <a class="modaltrigger" href=".loginmodal">See Details</a>
                                        </div>
                                        <div id=tried style='display:none;'>
                                            <input type=hidden name='tried' value=''>
                                            <strong>Tried:</strong>
                                        </div>
                                        <div id=preptime style='display:none;'>
                                            <input type=hidden name='preptime' value=''>
                                            <strong>Preparation Time:</strong>
                                        </div>
                                        <div id=cooktime style='display:none;'>
                                            <input type=hidden name='cooktime' value=''>
                                            <strong>Cooking Time:</strong>
                                        </div>
                                        <div id=cuisine style='display:none;'>
                                            <input type=hidden name='cuisine' value=''>    
                                            <strong>Cuisine:</strong>
                                        </div>
                                        <div id=diet style='display:none;'>
                                        </div>
                                        <div id=cat style='display:none;'>
                                        </div>
                                        <div id=source style='display:none;'>
                                            <input type=hidden name='source' value=''>
                                            <strong>Source:</strong>
                                        </div>
                                        <div id=otherinfo>
                                            <br>
                                            <div id=addedby style='display:none;'>
                                                <input type=hidden id=addedby name='addedby' value=''>
                                                <strong>Added By:</strong>
                                            </div>
                                            <div id=added style='display:none;'>
                                                <input type=hidden name='added' value=''>
                                                <strong>Added:</strong>
                                            </div>
                                            <div id=updated style='display:none;'>
                                                <strong>Last Modified:</strong>
                                            </div>
                                        </div>
                                        <div id=rrecipe style='display:none;'>
                                            <hr>
                                            <br>
                                            <input type=hidden name='related' id=related value=''>
                                            <h3><strong></strong></h3>
									    </div>
                                        <?php
                                            if (isset($admin) and isset($unapproved)) {
                                                print("<div class=appbuttons style='display:none'><br class=noprint><br class=noprint>
                                                            <div>
                                                                <div class='dib'>
                                                                    <INPUT type=button value='Approve' class='btn approve'>
                                                                </div>
                                                                <div class='dib'>
                                                                    <INPUT type=button value='Delete' class='btn delrecipe'>
                                                                </div>
                                                                <div class='dib'>
                                                                    <INPUT type=button value='Display Approved Recipes' class='btn dispapproved'>
                                                                </div>
                                                            </div>
                                                    </div>");
                                            }
                                            if(isset($seldate)) {
                                                print("<input type=hidden id=seldate name=seldate value=$seldate>");
                                            }
                                            if(isset($admin)) {
                                                    print("<input type=hidden id=admin name=admin value=$admin>");
                                            }
                                            if(isset($guest)) {
                                                    print("<input type=hidden id=admin name=admin value=$guest>");
                                            }
                                            if(isset($unapproved)) {
                                                    print("<input type=hidden id=unapproved name=unapproved value=$unapproved>");
                                            }
                                            if(isset($id)) {
                                                print("<input type=hidden name='id' id=id value=$id>");
                                            } else {
                                                echo "<input type=hidden name='id' id=id value=>";
                                            }
                                            if(isset($guest)) {
                                                print("<input type=HIDDEN name=guest id=guest value=$guest>");
                                            }
                                        ?>
                                        
                                        <input type=hidden name=rowner id='rowner' value=>
                                        <input type="hidden" name="cbut_val" value="">
                                        <br>
                                        <INPUT type=button class='nm btn' value='Normal View'>
                                    </FORM>
                                    <?php
                                        if (!isset($unapproved) and !isset($public)) {
                                                echo '<div id=comments>
                                                        <div id="currentcomments" class="submitcomment" style="display:none">
                                                            <hr class="nofs noprint">
                                                            <h3 class="nofs">Comments</h3>
                                                            <span id="ccnum"></span>
                                                            <br class="noprint">
                                                            <br class="noprint">
                                                            <div id="newcom"></div>
                                                        </div>';
                                                require_once('includes/comment.php');
                                                submitComments($suser,$uid,$client);
                                                echo '</div>';
                                        }       
                                    ?>
                                </div>
                                <?php
                                    require_once('includes/bottom.php');
                                ?>
                
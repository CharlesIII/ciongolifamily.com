<?php

    require_once('rdb.php');
    
    if(isset($_POST['id'])) {
        $id=$_POST['id'];
    }
    if(isset($_POST['seldate'])) {
        $seldate=$_POST['seldate'];
    }

    function BBCode($Text){
        // Replace any html brackets with HTML Entities to prevent executing HTML or script
        // Don't use strip_tags here because it breaks [url] search by replacing & with amp
        $Text = str_replace("<", "&lt;", $Text);
        $Text = str_replace(">", "&gt;", $Text);

        // Set up the parameters for a URL search string
        $URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
        // Set up the parameters for a MAIL search string
        $MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";

        //Non BB URL Search
        if (substr($Text,0, 7) == "http://"){
        $Text = preg_replace("/([[:alnum:]]+):\/\/([^[:space:]]*)([[:alnum:]#?/&=])/i", "<a href=\"\\1://\\2\\3\">\\1://\\2\\3</a>", $Text);
         // Convert new line chars to html <br /> tags
        $Text = nl2br($Text);
        } else {
        // Perform URL Search
        $Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="javascript:go(\'$1\',\'new\')">$1</a>', $Text);
        $Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="javascript:go(\'$1\',\'new\')">$2</a>', $Text);
        //$Text = preg_replace("(\[url\=([$URLSearchString]*)\]([$URLSearchString]*)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text);
         // Convert new line chars to html <br /> tags
        $Text = nl2br($Text);
        }
        // Perform MAIL Search
        $Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
        $Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);

        // Check for bold text
        $Text = preg_replace("(\[b\](.+?)\[\/b])is",'<span class="bold">$1</span>',$Text);

        // Check for Italics text
        $Text = preg_replace("(\[i\](.+?)\[\/i\])is",'<span class="italics">$1</span>',$Text);

        // Check for Underline text
        $Text = preg_replace("(\[u\](.+?)\[\/u\])is",'<span class="underline">$1</span>',$Text);

        // Check for strike-through text
        $Text = preg_replace("(\[s\](.+?)\[\/s\])is",'<span class="strikethrough">$1</span>',$Text);

        // Check for over-line text
        $Text = preg_replace("(\[o\](.+?)\[\/o\])is",'<span class="overline">$1</span>',$Text);

        // Check for colored text
        $Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);

        // Check for sized text
        $Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$Text);

        // Check for list text
        $Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>' ,$Text);
        $Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>' ,$Text);
        $Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>' ,$Text);
        $Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>' ,$Text);
        $Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>' ,$Text);
        $Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>' ,$Text);
        $Text = str_replace("[*]", "<li>", $Text);

        // Check for font change text
        $Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])","<span style=\"font-family: $1;\">$2</span>",$Text);

        // Declare the format for [code] layout
        $CodeLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="quotecodeheader"> Code:</div>
                            </tr>
                            <tr>
                                <td class="codebody">$1</div>
                            </tr>
                       </table>';
        // Check for [code] text
        $Text = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $Text);

        // Declare the format for [quote] layout
        $QuoteLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="quotecodeheader"> Quote:</div>
                            </tr>
                            <tr>
                                <td class="quotebody">$1</div>
                            </tr>
                       </table>';

        // Check for [code] text
        $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is","$QuoteLayout", $Text);

        // Images
        // [img]pathtoimage[/img]
        $Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text);

        // [img=widthxheight]image source[/img]
        $Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $Text);

        return $Text;
    }
    function formatDate($val,$seldate) {
        list($date, $time) = explode(" ", $val);
        list($year, $month, $day) = explode("-", $date);
        list($hour, $minute, $second) = explode (":", $time);
        if (isset($seldate)) {
            if ($seldate==0) {
                return date("l, j.m.y @ H:ia", mktime($hour, $minute, $second, $month, $day, $year));
            }  else {
                return date("l, m.j.y @ H:ia", mktime($hour, $minute, $second, $month, $day, $year));
            }
        }  else {
            return date("l, m.j.y @ H:ia", mktime($hour, $minute, $second, $month, $day, $year));
        }
    }

    $sql = "$call query_recipe(:id)";
    $dbrecipe = $rdb->prepare($sql);
    $dbrecipe->bindValue(':id', $id);
    $dbrecipe->execute();
    $err=$rdb->errorInfo();
    $rsrecipe = $dbrecipe->fetch(PDO::FETCH_BOTH);
    $dbrecipe->closeCursor();
    
    $name = stripslashes($rsrecipe[0]);
    $directions=stripslashes(nl2br(trim($rsrecipe[1])));
    $note = stripslashes(nl2br(trim($rsrecipe[2])));
    $source = $rsrecipe[3];
    $cuisine = $rsrecipe[4];
    $rating = $rsrecipe[5];
    $updated = $rsrecipe[6];
    
    if(isset($updated)) {
        if (isset($seldate) && $seldate==0) {
                $udate=date("d/m/Y", strtotime($updated));
        } else {
                $udate=date("m/d/Y", strtotime($updated));
        }
    }
    $yield = rtrim(trim($rsrecipe[7], '0'), '.');
    $tried = $rsrecipe[8];
    $preptime = $rsrecipe[9];
    $yield_unit = $rsrecipe[10];
    $measure = $rsrecipe[11];            
    $added = $rsrecipe[12];
    if(isset($added)) {
        if (isset($seldate) && $seldate==0) {
                $adate=date("d/m/Y", strtotime($added));
        } else {
                $adate=date("m/d/Y", strtotime($added));
        }
    }
    $total_ratings = $rsrecipe[13];
    $pdf = $rsrecipe[14];
    $addedby = $rsrecipe[15];
    $cooktime = $rsrecipe[16];
    $video = $rsrecipe[17];
    
    $recipe[1] = array('id' => $id, 'name' => $name);
    if(isset($directions)) {
        $recipe[1]['directions'] = $directions;               
    } else {
        $recipe[1]['directions'] = null;
    }
    if(isset($note)) {
        $recipe[1]['note'] = $note;               
    } else {
        $recipe[1]['note'] = null;
    }
    if(isset($source)) {
        $recipe[1]['source'] = $source;               
    } else {
        $recipe[1]['source'] = null;
    }
    if(isset($cuisine)) {
        $recipe[1]['cuisine'] = $cuisine;               
    } else {
        $recipe[1]['cuisine'] = null;
    }
    if(isset($rating)) {
        $recipe[1]['rating'] = $rating;               
    } else {
        $recipe[1]['rating'] = null;
    }
    if(isset($updated)) {
        $recipe[1]['updated'] = $updated;               
    } else {
        $recipe[1]['updated'] = null;
    }
    if(isset($yield)) {
        $recipe[1]['yield'] = $yield;               
    } else {
        $recipe[1]['yield'] = null;
    }
    if(isset($tried)) {
        $recipe[1]['tried'] = $tried;               
    } else {
        $recipe[1]['tried'] = null;
    }
    if(isset($preptime)) {
        $recipe[1]['preptime'] = $preptime;               
    } else {
        $recipe[1]['preptime'] = null;
    }
    if(isset($yield_unit)) {
        $recipe[1]['yield_unit'] = $yield_unit;               
    } else {
        $recipe[1]['yield_unit'] = null;
    }
    if(isset($measure)) {
        $recipe[1]['measure'] = $measure;               
    } else {
        $recipe[1]['measure'] = null;
    }
    if(isset($added)) {
        $recipe[1]['added'] = $added;               
    } else {
        $recipe[1]['added'] = null;
    }
    if(isset($total_ratings)) {
        $recipe[1]['total_ratings'] = $total_ratings;               
    } else {
        $recipe[1]['total_ratings'] = null;
    }
    if(isset($addedby)) {
        $recipe[1]['addedby'] = $addedby;               
    } else {
        $recipe[1]['addedby'] = null;
    }
    if(isset($cooktime)) {
        $recipe[1]['cooktime'] = $cooktime;               
    } else {
        $recipe[1]['cooktime'] = null;
    }
    if(isset($video)) {
        $recipe[1]['video'] = $video;               
    } else {
        $recipe[1]['video'] = null;
    }
    if(isset($pdf)) {
        $recipe[1]['pdf'] = $pdf;               
    } else {
        $recipe[1]['pdf'] = null;
    }
    if(isset($adate)) {
        $recipe[1]['adate'] = $adate;               
    } else {
        $recipe[1]['adate'] = null;
    }
    if(isset($udate)) {
        $recipe[1]['udate'] = $udate;               
    } else {
        $recipe[1]['udate'] = null;
    }
    
    $sql="$call query_recipe_ings(:id)";
    $dbing = $rdb->prepare($sql);
    $dbing->bindValue(':id', $id);
    $dbing->execute();
    $err=$rdb->errorInfo();
    $irows = $dbing->rowCount();
    $rsing = $dbing->fetchAll(PDO::FETCH_BOTH);
    $dbing->closeCursor();
    
    for ($lt=0;$lt < $irows;$lt++) {
        $quantity = $rsing[$lt][0];
        $qtydec=$rsing[$lt][7];
        $unit = $rsing[$lt][1];
        $quantity2 = $rsing[$lt][5];
        $eunit = $rsing[$lt][6];
        $ing = $rsing[$lt][2];
        $pp = $rsing[$lt][3];
        $pp1 = $rsing[$lt][4];
        
        $ings[$lt] = array('ing' => $ing);
        if(isset($quantity)) {
            $ings[$lt]['quantity'] = $quantity;               
        } else {
            $ings[$lt]['quantity'] = null;
        }
        if(isset($qtydec)) {
            $ings[$lt]['qtydec'] = $qtydec;               
        } else {
            $ings[$lt]['qtydec'] = null;
        }
        if(isset($unit)) {
            $ings[$lt]['unit'] = $unit;               
        } else {
            $ings[$lt]['unit'] = null;
        }
        if(isset($quantity2)) {
            $ings[$lt]['quantity2'] = $quantity2;               
        } else {
            $ings[$lt]['quantity2'] = null;
        }
        if(isset($eunit)) {
            $ings[$lt]['eunit'] = $eunit;               
        } else {
            $ings[$lt]['eunit'] = null;
        }
        if(isset($pp)) {
            $ings[$lt]['pp'] = $pp;               
        } else {
            $ings[$lt]['pp'] = null;
        }
        if(isset($pp1)) {
            $ings[$lt]['pp1'] = $pp1;               
        } else {
            $ings[$lt]['pp1'] = null;
        }
    }
    
    if(isset($ings)) {
        $response['ings'] = $ings;
    }
    
    $sql="$call query_recipe_images(:id)";
    $dbimg = $rdb->prepare($sql);
    $dbimg->bindValue(':id', $id);
    $dbimg->execute();
    $err=$rdb->errorInfo();
    $imgrows = $dbimg->rowCount();
    $rsimg = $dbimg->fetchAll(PDO::FETCH_BOTH);
    $dbimg->closeCursor();
    
    for ($lt = 0; $lt < $imgrows; $lt++) {
        $image=$rsimg[$lt][1];
        $imgs[$lt] = array('image' => $image);    
    }
    
    if(isset($imgs)) {
        $response['imgs'] = $imgs;
    }
    
    $sql="$call query_related_recipes(:id)";
    $dbrel = $rdb->prepare($sql);
    $dbrel->bindValue(':id', $id);
    $dbrel->execute();
    $err=$rdb->errorInfo();
    $rrrows = $dbrel->rowCount();
    $rsrel = $dbrel->fetchAll(PDO::FETCH_BOTH);
    $dbrel->closeCursor();
    
    if($rrrows>0) {
        $rel='yes';
    }
    if(isset($rel)) {
        $recipe[1]['related'] = $rel;               
    } else {
        $recipe[1]['related'] = null;
    }
    $response['recipe'] = $recipe;
    
    for ($lt = 0; $lt < $rrrows; $lt++) {
       $relid = $rsrel[$lt][1];
       $relname= $rsrel[$lt][3];
       $related[$lt] = array('relid' => $relid, 'relname' => $relname);
    }
    
    if(isset($related)) {
        $response['related'] = $related;
    }
    
    $sql="$call query_recipe_diets(:id)";
    $dbdiet = $rdb->prepare($sql);
    $dbdiet->bindValue(':id', $id);
    $dbdiet->execute();
    $err=$rdb->errorInfo();
    $drows = $dbdiet->rowCount();
    $rsdiet = $dbdiet->fetchAll(PDO::FETCH_BOTH);
    $dbdiet->closeCursor();
    
    for ($lt = 0; $lt < $drows; $lt++) {
        $diet = $rsdiet[$lt][0];
        $diets[$lt] = array('diet' => $diet);            
    }
    
    if(isset($diets)) {
        $response['diets'] = $diets;
    }
    
    $sql="$call query_recipe_cats(:id)";
    $dbcat = $rdb->prepare($sql);
    $dbcat->bindValue(':id', $id);
    $dbcat->execute();
    $err=$rdb->errorInfo();
    $srows = $dbcat->rowCount();
    $rscat = $dbcat->fetchAll(PDO::FETCH_BOTH);
    $dbcat->closeCursor();
    
    for ($lt = 0; $lt < $srows; $lt++) {
        $cat = $rscat[$lt][0];
        $subcat = $rscat[$lt][1];
        $cats[$lt] = array('cat' => $cat, 'subcat' => $subcat);
    }
    
    if(isset($cats)) {     
        $response['cats'] = $cats;
    }
    
    $sql = "$call query_recipe_comments(:id)";
    $commentquery = $rdb->prepare($sql);
    $commentquery->bindValue(':id', $id);
    $commentquery->execute();
    $err=$rdb->errorInfo();
    $crows = $commentquery->rowCount();
    $comment = $commentquery->fetchAll(PDO::FETCH_BOTH);
    $commentquery->closeCursor();
    
    for ($lt = 0; $lt < $crows; $lt++) {
        $commentid = $comment[$lt][0];
        $commentbb = BBCode($comment[$lt][1]);
        $commentDate = formatDate($comment[$lt][2],$seldate);
        if (is_null($comment[$lt][3])) {
            $duser='guest';
        } else {
            $pos = strpos($comment[$lt][3], "_");
            if ($pos>-1) {
                $duser = substr($comment[$lt][3],$pos+1);
            } else {
                $duser= $comment[$lt][3];
            }
        }
        $comments[$lt] = array('commentid' => $commentid, 'commentbb' => $commentbb, 'commentDate' => $commentDate, 'duser' => $duser);
    }
    if(isset($comments)) {     
        $response['comments'] = $comments;
    }
    
    echo json_encode($response);
?>

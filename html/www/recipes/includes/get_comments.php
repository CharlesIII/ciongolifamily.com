<?php
    require_once('rdb.php');
    
    $id=$_POST['id'];
    $seldate=$_POST['seldate'];

    //create a headline
    $html = "<div id=currentcomments class=submitcomment>";
    if ($crows>0) {
        $html .= "<h3 class='nofs'>Comments</h3>";
    }
    if ($crows==1){
        $html .= "<span id=ccnum>There is currently 1 comment for this recipe</span>";
    } else {
        $html .= "<span id=ccnum>There are currently ".$crows ." comments for this recipe</span>";
    }
    
    $html .= '<br class=noprint><br class=noprint><div id=newcom></div>';
     //for each comment in the database in the right category number...
     $rc=0;
    for ($clt = 0; $clt < $crows; $clt++) {
        $rc++;
        //if admin mark comment as checked
        $commentid=$commentquery[$clt][0];
        //for security, parse through the bbcode script
        $commentbb = $commentquery[$clt][1];
        
        //create the right date format
        $commentDate = $commentquery[$clt][2],$seldate);
        if ($rc>5) {
            $html .= "<div style='display:none' class=commentbody id=$commentid><br class=noprint>";
        } else {
            $html .= "<div class=commentbody id=$commentid><br class=noprint>";
        }
        $html .= "<p>Comment: $commentbb</p><br class=noprint>";
        $html .= "<p class=postedby>Posted by ";
        if (is_null($commentquery[$clt][3])) {
            $duser='guest';
        } else {
            $pos = strpos($commentquery[$clt][3], "_");
            if ($pos>-1) {
                $duser = substr($commentquery[$clt][3],$pos+1);
            } else {
                $duser= $commentquery[$clt][3];
            }
        }
        $html .= "$duser ";
        $html .= "on $commentDate</p>";
        $html .= "</div>";
    }
    if ($crows>5) {
            $html .= "<a id=more href='#'>Show all comments</a><br class=noprint>";
    }
    $html .= "</div>";
    echo $html;
?>

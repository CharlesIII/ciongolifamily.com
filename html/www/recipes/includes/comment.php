<?php
function BBCode($Text)
{
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

//quick script to make the data look nice
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



function getComments($oid,$client,$seldate,$call,$rdb){
	//creates a function that can easily be called from any page
    //fetch all comments from database for this recipe
	if($client=='wrm') {
	    $sql = "$call query_comments(:oid)";
        $commentq = $rdb->prepare($sql);
        $commentq->bindValue(':oid', $oid);
        $commentq->execute();
        $err=$rdb->errorInfo();
        $crows = $commentq->rowCount();
        $commentquery = $commentq->fetchAll(PDO::FETCH_BOTH);
    } else {
        $sql = "$call query_comments()";
        $commentq = $rdb->prepare($sql);
        $commentq->execute();
$err=$rdb->errorInfo();
        $crows = $commentq->rowCount();
        $commentquery = $commentq->fetchAll(PDO::FETCH_BOTH);
    }
    $commentq->closeCursor();
    
	if ($crows>0) {
	    echo '<br><INPUT type=submit id=submit name=save value=Process class=btn>';
	}
    //create a headline
    echo '<div id=comments>';
	echo "<div id=currentcomments class=submitcomment>";
	if ($crows==1){
		echo "<span id=ccnum>There is 1 new comment</span>";
	} else {
		echo "<span id=ccnum>There are ".$crows." new comments";
	}
    echo '<br class=noprint><br class=noprint><div id=newcom></div>';
	 //for each comment in the database in the right category number...
    for ($clt = 0; $clt < $crows; $clt++) {
		//if admin mark comment as checked
		$commentid=$commentquery[$clt][0];
        //for security, parse through the bbcode script
		$commentbb = $commentquery[$clt][1];
        //create the right date format
		$commentDate = formatDate($commentquery[$clt][2],$seldate);
		print("<div class=commentbody id=$commentid><br class=noprint>");
		echo "<p>Comment: $commentbb</p><br class=noprint>";
		echo "<p class=postedby>Posted by ";
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
        echo "$duser ";
		echo "on $commentDate</p>";
		echo"</div>";
		print("
				<input id=abox$clt type=checkbox class='chk css-checkbox' name=abox[] value=$commentid>
                <label for=abox$clt class=css-label><strong> Approve Comment</strong></label>
                <br>
                <input id=cbox$clt type=checkbox class='chk css-checkbox' name=cbox[] value=$commentid>
                <label for=cbox$clt class=css-label><strong> Delete Comment</strong></label>
                <br>
                <input id=ecbox$clt type=checkbox class='chk css-checkbox' name=ecbox[] value=$duser>
                <label for=ecbox$clt class=css-label><strong> Send Warning Email To Poster</strong></label>
		");
	}
	echo "</div>";
	if ($crows>0) {
	    echo '<br class=noprint><INPUT type=submit id=submit name=save value=Process class=btn>';
	}
}

function submitComments($user,$uid,$client){
    //create the form to submit comments
	 print("
	<hr class='nofs noprint'>
    <div id='submitcomment' class='submitcomment nofs'>
		<form id=comment name=submitcomment>
			<strong class=rheader>Make a comment or suggest variations:</strong><br><br>
			<strong>Username: </strong>$user
                        <br class=noprint>
			<strong>Comments: </strong>
                        <br class=noprint>
			<textarea class='form-control' tabindex='3' id='message' name='message' rows='10' cols='50' onkeydown='checkLen(this, 300)' onkeypress='checkLen(this, 300)' onkeyup='checkLen(this, 300)' onchange='checkLen(this, 300)'></textarea>
			<br class=noprint>
			<span id=commlimit>Limit of 300 Characters. </span><span id=tanote></span>
            <br class=noprint>
            <p>Please keep comments relevant. Any inappropriate comments will be removed by the administrator.</p>
			<br class=noprint>
			<input type=submit name=post class='btn nofs' value='Submit Comment'>
			

			<input type=hidden id='uid' name=uid value=$uid>
			<input type=hidden id='client' name=client value=$client>
		</form>
    </div>
	");
}
?>

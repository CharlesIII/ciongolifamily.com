<?php

require_once('rdb.php');

@set_time_limit(36000);

function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

$toname=$_POST['name'];
$email=$_POST['email'];
if(isset($_POST['message'])) {
   $mess=$_POST['message']; 
}
if(isset($_POST['myemail'])) {
   $from=$_POST['myemail']; 
}
if(isset($_POST['myname'])) {
   $fromname=$_POST['myname']; 
}
$id=$_COOKIE['rid'];

$toname = rtrim($toname, ',');
$email = rtrim($email, ',');
$namearray=explode(',',$toname);
$emailarray=explode(',',$email);
foreach ($emailarray as $key => $val) {
   $val=trim($val);
   if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $val)) {
	  if (!isset($emsg)) {
		 $emsg = "The following email addresses are invalid<br>$val";
	  } else {
		 $emsg .= '<br>'.$val;
	  }
   }
}
if (!$toname) {
   echo 'At least one name must be entered';
} else if (isset($emsg)) {
   echo $emsg;

} else if (count($namearray) != count($emailarray)) {
   echo 'There must be the same number of names and email addresses';

} else {
   require_once 'swift/lib/swift_required.php';

   $starpath='../images/';
   $imagepath='../images/recipe/';
   if ($eauthreq=='yes') {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport")
         ->setusername($euser)
         ->setPassword($epass);
   } else {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport");
   }
   $mailer = Swift_Mailer::newInstance($transport);
   $message = Swift_Message::newInstance();
   $message->setSubject("A Recipe From $clientname");

   if($client=='wrm') {
       try {
            $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);
       }
       catch(PDOException $e) {
            $msg = $e->getMessage();
       }
       $STH = $mdb->prepare("SELECT email, fname, lname FROM users WHERE username = '$user'");
       $STH -> execute();
       $err=$mdb->errorInfo();
       $result = $STH -> fetch();
       if(!isset($from)) {
            $from = $result['email'];
       }
       if(!isset($fromname)) {
            $fromname = $result['fname']." ".$result['lname'];
       }
   } else {
       if($dbsql=='mysql') {
           $sql = "SELECT email, fname, lname FROM owner WHERE BINARY owner = '$user'";
       }  else {
            $sql = "SELECT email, fname, lname FROM owner WHERE owner = '$user'";
       }
      $results = $rdb->prepare($sql);
      $results->execute();
      $err=$rdb->errorInfo();
      $result = $results->fetch(PDO::FETCH_BOTH);
      $results->closeCursor();
      
      if(!isset($from)) {
            $from = $result['email'];
      }
      if(!isset($fromname)) {
            $fromname = $result['fname']." ".$result['lname'];
      } 
   }

   require_once('getrecipe.php');
   
   if(isset($rating)) {
        $starimage="$rating.png";
   } else {
        $starimage="0.png";
   }

   require_once('email-header.php');
   
   if (isset($mess) && $mess!="") {
	  $body .= "$mess<br><br><hr>";
   }
   $body .= "<br><h3 style='font-size:18px;font-weight:bold;'>$name</h3>";
   $starsrc = $message->embed(Swift_Image::fromPath("$starpath"."$starimage"));
   $body .="<img src='$starsrc'><br><br>";
   
   if ($imgrows>0) {
      $image=$rsimg[0][1];
      $src = $message->embed(Swift_Image::fromPath("$imagepath"."$image"));
      $body .="<img src='$src'>";
   }
   $body .= "<br><br><strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Ingredients</strong><br><br>";

   $body .= '<table>';
   for ($lt = 0; $lt < $irows; $lt++) {
        $body .= '<tr>';
        $quantity = $rsing[$lt][0];
        if (isset($quantity)) {
            $body .= "<td>$quantity</td>";
        }  else {
            $body .= "<td></td>";
        }
        $unit = $rsing[$lt][1];
        $quantity2 = $rsing[$lt][5];
        $eunit = $rsing[$lt][6];
        if (isset($unit)) {
            $body .= "<td>$unit";
            if (isset($quantity2) && isset($eunit)) {
               $body .= "($quantity2 $eunit)"; 
            } else if (isset($quantity2)) {
               $body .= "($quantity2)"; 
            } else if (isset($eunit)) {
               $body .= "($quantity2)";
            }
            $body .= "</td>"; 
        }  else {
            $body .= "<td></td>";
        }
        $ing = $rsing[$lt][2];
        if (isset($ing)) {
           $body .= "<td>$ing";
           $pp = $rsing[$lt][3];
            if ($pp) {
                $body .= ", $pp";
            }
            $pp = $rsing[$lt][4];
            if ($pp) {
                $body .= ", $pp";
            }
            $body .= "</td>"; 
        }  else {
            $body .= "<td></td>";
        }
        
        
        $body .= "</tr>";
   }
   $body .= '</table>';
    
   if(isset($note)) {
       $note = nl2br(stripslashes($note));
       $body .= "<br><strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Notes</strong><br><br>$note<br>";
   }

   if(isset($directions)) {
       $directions = nl2br(stripslashes($directions));
       $body .= "<br><strong style='text-transform: uppercase;border-bottom: 1px solid #666666;color: black;'>Directions</strong><br><br>$directions<br><hr>";
   }

   if (isset($measure)) {
		 $body .= "<strong>Measurement System:</strong> $measure<br>";
   }
   if ($tried) {
		 $tried = "Yes";
   } else {
		 $tried = "No";
   }
   $body .= "<strong>Tried:   </strong> $tried<br>";

   if (isset($preptime)) {
		 $body .= "<strong>Preparation Time:</strong> $preptime<br>";
   }
   if (isset($cooktime)) {
		 $body .= "<strong>Cooking Time:</strong> $cooktime<br>";
   }

   if (isset($yield) && $yield!='') {
		 $body .= "<strong>Makes:</strong> $yield";
         if(isset($yield_unit)) {
             $body .= " $yield_unit";
         }
         $body .= "<br>";
   }

   if (isset($cuisine)) {
		 $body .= "<strong>Cuisine:</strong> $cuisine<br>";
   }

   if ($drows>0) {
	  $body .= "<strong>Diet:</strong>";
	  for ($lt = 0; $lt < $drows; $lt++) {
		 $diet = $rsdiet[$lt][0];
		 if ($lt > 0) {
			$body .= ", $diet";
		 } else {
			$body .= " $diet";
		 }
	  }
      $body .= "<br>";
   }
   for ($lt = 0; $lt < $srows; $lt++) {
		 $cat =$rscat[$lt][0];
		 $subcat = $rscat[$lt][1];
		 if ($lt > 0) {
			if ($subcat) {
			   $body .= ", $cat: $subcat";
			} else {
			   $body .= ", $cat";
			}
		 } else {
			if ($subcat) {
               $body .= "<strong>Recipe Types & Categories:</strong>";
			   $body .= " $cat: $subcat";
			} else {
               $body .= "<strong>Recipe Types:</strong>";
			   $body .= " $cat";
			}
		 }
   }
   $body .= "<br>";
   if (isset($source)) {
	  $body .= "<strong>Source:</strong> $source<br>";
   }
   $extraimages=$imgrows-1;
   if ($extraimages>0) {
       $body .= "<br><br><table><tr>";
       for ($lt = 1; $lt < 4; $lt++) {
		 if ($lt<=$extraimages) {
			$image=$rsimg[$lt][1];
			$src = $message->embed(Swift_Image::fromPath("$imagepath"."$image"));
			$body .="<td valign=top><img src='$src'></td>";
		 }
       }
      $body .= "</tr></table>";
   }
   if ($extraimages>3) {
       $body .= "<br><br><table><tr>";
       for ($lt = 4; $lt < 7; $lt++) {
		 if ($lt<=$extraimages) {
			$image=$rsimg[$lt][1];
			$src = $message->embed(Swift_Image::fromPath("$imagepath"."$image"));
			$body .="<td valign=top><img src='$src'></td>";
		 }
       }
       $body .= "</tr></table>";
   }
   if ($extraimages>6) {
       $body .= "<br><br><table><tr>";
       for ($lt = 7; $lt < 10; $lt++) {
		 if ($lt<=$extraimages) {
           $image=$rsimg[$lt][1];
			$src = $message->embed(Swift_Image::fromPath("$imagepath"."$image"));
			$body .="<td valign=top><img src='$src'></td>";
		 }
       }
       $body .= "</tr></table>";
   }
   $rt=0;
   for ($lt = 0; $lt < $rrrows; $lt++) {
      if ($id == $rsrel[$lt][0]) {
         $relid = $rsrel[$lt][1];
         $relname= $rsrel[$lt][3];
      }
      if ($lt == 0) {
         $body .= "<hr><h3 style='font-size:18px;font-weight:bold;'>Related Recipes</h3>";
      }
      if ($relname) {
         $body .= '<hr>';
         $rt++;
         require('email_related.php');
      }
   }

   $body .= "<br><br>Regards,<br>$fromname";
   
   require_once('email-footer.php');

   $message->setBody(
    '<html>' .
    ' <head></head>' .
    ' <body>' .
    $body .
    ' </body>' .
    '</html>',
      'text/html'
   );
   if(isset($pdf)) {
       $message->attach(Swift_Attachment::fromPath("$imagepath"."$pdf"));
   }
   foreach ($namearray as $key => $nameval) {
      $nameval=trim($nameval);
      foreach ($emailarray as $ikey => $ival) {
        $ival=trim($ival);
        if ($ikey==$key) {
           $message->addTo($ival, $nameval);
           
           if ($user!='demo' && substr($user,0,5) != 'demo_' && $user!='mywrm'){
                $sql="SELECT email from email_history where owner=:uid and email=:email and name=:name";
                $dbemail = $rdb->prepare($sql);
                $dbemail->bindValue(':uid', $uid);
                $dbemail->bindValue(':email', $ival);
                $dbemail->bindValue(':name', $nameval);
                $dbemail->execute();
                $err=$rdb->errorInfo();
                $array = $dbemail->fetchAll(PDO::FETCH_BOTH);
                $erows = $dbemail->rowCount();
                $dbemail->closeCursor();
                
                if ($erows==0) {       
                    $sql="INSERT INTO email_history (email,owner,name) VALUES (:email,:uid,:name)";
                    $dbemail = $rdb->prepare($sql);
                    $dbemail->bindValue(':uid', $uid);
                    $dbemail->bindValue(':email', $ival);
                    $dbemail->bindValue(':name', $nameval);
                    $dbemail->execute();
                    $err=$rdb->errorInfo();
                    $dbemail->closeCursor();
                }
           }
            break;
        }
      }
   }
   $message->setFrom(array($from => $fromname));
   if ($mailer->send($message)){
	  echo 'yes';
   } else {
	  echo "Message failed to send";
   }

}
?>
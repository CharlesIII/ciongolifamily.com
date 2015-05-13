<?php

require_once('rdb.php');

$toname=$_POST['first'];;
$email=$_POST['email'];
$mess=$_POST['mess'];
if(isset($_POST['fromphone'])) {
    $fromphone=$_POST['fromphone'];
}

$namearray=explode(',',$toname);
$emailarray=explode(',',$email);
foreach ($emailarray as $key => $val) {
   $val=trim($val);
   if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $val)) {
	  if (!$emsg) {
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
   if ($eauthreq=='yes') {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport")
         ->setusername($euser)
         ->setPassword($epass);
   } else {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport");
   }

   $mailer = Swift_Mailer::newInstance($transport);
   $message = Swift_Message::newInstance();
   $message->setSubject("A Shopping List From $clientname");

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
       $from = $result['email'];
       $name = $result['fname']." ".$result['lname'];
   } else {
       if($dbsql=='mysql') {
          $sql = "SELECT email, fname, lname FROM owner WHERE BINARY owner = '$user'"; 
       } else {
            $sql = "SELECT email, fname, lname FROM owner WHERE owner = '$user'";
       }
      $results = $rdb->prepare($sql);
      $results->execute();
      $err=$rdb->errorInfo();
      $result = $results->fetch(PDO::FETCH_BOTH);
      $results->closeCursor();
      
      $from = $result['email'];
      $name = $result['fname']." ".$result['lname']; 
   }

   require_once('email-header.php');
   $body .= "$mess<br><br>";
   $body .= "Regards,<br>$name";
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
   foreach ($namearray as $key => $nameval) {
      $nameval=trim($nameval);
      foreach ($emailarray as $ikey => $ival) {
        $ival=trim($ival);
        if ($ikey==$key) {
           $message->addTo($ival, $nameval);
           break;
        }
      }
   }
   $message->setFrom(array($from => $name));
   if ($mailer->send($message)){
	  echo 'yes';
   } else {
	  echo "Message failed to send";
   }
}
?>

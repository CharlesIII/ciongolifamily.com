<?php
    $good=null;
    $bad=null;
   if($client=='wrm') {
       $mdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass);
       
       $STH = $mdb->prepare("select email, fname, lname from users where username='$poster'");
       $STH -> execute();
       $err=$mdb->errorInfo();
       $result = $STH -> fetch();
       $email=$result['email'];
       $fname=$result['fname'];
       $lname=$result['lname'];

       $STH = $mdb->prepare("select email, fname, lname from users where username='$user'");
       $STH -> execute();
       $err=$mdb->errorInfo();
       $oresult = $STH -> fetch();
       $clientemail=$oresult['email'];
       $emailfrom=$oresult['fname'].' '.$oresult['lname'];
   } else {
       $STH = $rdb->prepare("select email, fname, lname from owner where owner='$poster'");
       $STH -> execute();
       $result = $STH -> fetch();
       $email=$result['email'];
       $fname=$result['fname'];
       $lname=$result['lname'];

       $STH = $rdb->prepare("select email, fname, lname from owner where owner='$user'");
       $STH -> execute();
       $oresult = $STH -> fetch();
       $clientemail=$oresult['email'];
       $emailfrom=$oresult['fname'].' '.$oresult['lname'];
   }
       

   require_once 'swift/lib/swift_required.php';

   $starpath='images/';
   if ($eauthreq=='yes') {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport")
         ->setusername($euser)
         ->setPassword($epass);
   } else {
         $transport = Swift_SmtpTransport::newInstance("$eserver","$eport");
   }
   $mailer = Swift_Mailer::newInstance($transport);
   $message = Swift_Message::newInstance();
   $message->setSubject("Comment Removed From $clientname");

   #produce message in html format
   require_once('email-header.php');
   $body .= "<br><br>Hi $fname,<br><br>We have removed your comment at Web Recipe Manager as it was inappropriate.<br><br>";
   $body .= "Regards,<br>$emailfrom<br><br>";
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
   $message->addTo($email,$fname.' '.$lname);
   $message->setFrom(array($clientemail => $emailfrom));

   if ($mailer->send($message)){
	  $good++;
   }else{
	  $bad++;
   }
?>

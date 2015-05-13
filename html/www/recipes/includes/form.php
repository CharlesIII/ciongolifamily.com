<?php
session_start();
//get the posted values
$fname=$_POST['name'];
if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email'])) {
   $email=$_POST['email'];
}
$mess=$_POST['message'];

require_once('dbclient.php');

if($fname) {
	  if(isset($_SESSION['6_letters_code']) && $_SESSION['6_letters_code'] != $_POST['security_code']) {
		 echo 'wrongstr';
		 exit;
	  }
	  if (!$email) {
		  echo 'noemail';
	  } else if (!$mess) {
		  echo 'nomess';
	  } else {
		 $date=date("Ymd");

		 require_once('swift/lib/swift_required.php');
        
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
		 $message->setSubject("Question or Feedback Received");

		#produce message in html format
		 require_once('email-header.php');
		 
		 $body .= "<h3>Question or Feedback Received</h3><br>";
		 $body .= "<b>Name:</b> $fname<br>";
		 $body .= "<b>Email Address:</b> $email<hr>";
		 $body .= "<b>Message:</b> $mess<hr>Someone will get back to you shortly.<br><br>$emailsig<br><br>";
		 
		 
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
		 $message->setTo(array($email, $csuppemail => $fname));
		 $message->setFrom("$csuppemail", "$clientname Support");

		 if ($mailer->send($message)){
			echo 'yes';
		 } else {
			echo "Message failed to send";
		 }
   }
} else {
   echo 'noname';
}
?>

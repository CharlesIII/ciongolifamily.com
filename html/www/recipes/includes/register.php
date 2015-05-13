<?php
session_start();

if($_SESSION['6_letters_code'] != $_POST['captcha']) {
	  echo 'wrongstr';
	  exit;
}
 
//get the posted values
$fname=$_POST['fname'];
$lname=$_POST['lname'];

if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email'])) {
   $email=$_POST['email'];
} 
$user=$_POST['uname'];
$pass=$_POST['pword'];

require_once('dbclient.php');
require_once('dbcalls.php');
require_once('limit.php');
    
   if (!$fname) {
	      echo 'noname';
	      exit;
   } else if (!$user) {
	      echo 'nouname';
	      exit;
   } else if (!$pass) {
	      echo 'nopass';
	      exit;
   } else if ($pass and strlen($pass) < 6) {
	      echo 'shortpass';
	      exit;
   } else if ($pass and strlen($pass) > 72) {
          echo 'longpass';
          exit;
   } else if (!$email) {
	      echo 'noemail';
	      exit;
   } else {
	        $date=date("Ymd");
	        if ($dbsql=='mysql') {
                  $dbtype=$dbsql;
                  $call='CALL';
            } else {
                  $dbtype='pgsql';
                  $call='SELECT';
            }
	        $rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            
            if($limit!='unlimited') {
                $sql = "select owner from owner";
                $users = $rdb->prepare($sql);
                $users->execute();
                $err=$rdb->errorInfo();
                $srows = $users->rowCount();
                $users->closeCursor();
                if ($srows==$limit) {
                    echo 'maxusers';
                    exit;
                }
            }
	        
            $sql = "$call query_owner_ids(:user)";
            $rsuid = $rdb->prepare($sql);
            $rsuid->bindValue(':user',$user);
            $rsuid->execute();
            $err=$rdb->errorInfo();
            $srows = $rsuid->rowCount();
            $rsuid->closeCursor();
            if ($srows>0) {
		       echo 'unameexists';
		       exit;
	        }
            $sql = "$call query_email_in_use(:email)";
            $rsemail = $rdb->prepare($sql);
            $rsemail->bindValue(':email',$email);
            $rsemail->execute();
            $err=$rdb->errorInfo();
            $erows = $rsemail->rowCount();
            $rsemail->closeCursor();
            if ($erows>0) {
               echo 'emailexists';
               exit;
            }
            require('PasswordHash.php');
            $hasher = new PasswordHash(8, true);
            $pass = $hasher->HashPassword($pass);
            if ($dbsql=='mysql') {
                    $sql="INSERT INTO owner( owner, fname, lname, password , email, regdate) VALUES (:user, :fname, :lname, :pass, :email, now())";
                    $rsadd = $rdb->prepare($sql);
                    $rsadd->bindValue(':user',$user);
                    $rsadd->bindValue(':fname',$fname);
                    $rsadd->bindValue(':lname',$lname);
                    $rsadd->bindValue(':pass',$pass);
                    $rsadd->bindValue(':email',$email);
                    $rsadd->execute();
                    $err=$rdb->errorInfo();
                    $rsadd->closeCursor();
            } else {
                  $sql = "$call query_add_user(:user,:fname,:lname,:pass,:email,:date)";
                  $rsadd = $rdb->prepare($sql);
                  $rsadd->bindValue(':user',$user);
                  $rsadd->bindValue(':fname',$fname);
                  $rsadd->bindValue(':lname',$lname);
                  $rsadd->bindValue(':pass',$pass);
                  $rsadd->bindValue(':email',$email);
                  $rsadd->bindValue(':date',$date);
                  $rsadd->execute();
                  $err=$rdb->errorInfo();
                  $rsadd->closeCursor();
            }            
	        
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
		    $message->setSubject("My Web Recipe Manager Account Information");
	    
            require_once('email-header.php');
		    #produce message in html format
		    $body .= "<br>Hi $fname,<br><br>Your account at My Web Recipe Manager has been created.<br>You will be able to log in when an administartor has approved your account.<br><br> Below is your user name for future reference.<hr>";
		    $body .= "User: $user<br><br>";
		    $body .= "Regards,<br>My Web Recipe Manager Admin.";
            
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
            $message->setFrom("$csuppemail", "$clientname");

             if ($mailer->send($message)){
                echo 'yes';
             } else {
                echo "Message failed to send";
             }
		     unset($_SESSION);	  
   }
?>

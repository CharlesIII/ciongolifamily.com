<?php
    session_set_cookie_params(0, '/');
    session_start();

    require_once('dbclient.php');
    require_once('dbcalls.php');
    
    $rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); //connect to database

    if($_SESSION['6_letters_code'] != $_POST['security_code']) {
          echo 'wrongstr';
          exit;
    }

	function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {                                                
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	
	//get the posted values
    if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email'])) {
	   $email=$_POST['email'];
	} 
	$user=$_POST['uname'];
	
	
	if (!$user and !$email) {
		echo 'novalues';
	} else {
		if (isset($user)) {
            $sql= "$call query_email_user(:user)";
            $userchk = $rdb->prepare($sql);
            $userchk->bindValue(':user', $user);
            $userchk->execute();
            $err=$rdb->errorInfo();
            $srows = $userchk->rowCount();
            
		    if ($srows==0) {
			   echo 'nouname';
			   exit;
		    } else {
			   $email = $userchk->fetchColumn();
		    }
            $userchk->closeCursor();		   
		} else if(isset($email)) {
               $sql= "$call query_user_email(:email)";
               $userchk = $rdb->prepare($sql);
               $userchk->bindValue(':email', $email);
               $userchk->execute();
               $err=$rdb->errorInfo();
               $srows = $userchk->rowCount();
               
		       if ($srows==0) {
			      echo 'noemail';
			      exit;
		       } else {
			      $user = $userchk->fetchColumn();
		       }
               $userchk->closeCursor();		   
		}
		$pass=generatePassword(6,0);
        require('PasswordHash.php');
        $hasher = new PasswordHash(8, true);
        $enpass = $hasher->HashPassword($pass);
        if($dbsql=='mysql') {
            $sql="UPDATE owner SET password=:enpass WHERE BINARY owner = :user";
        } else {
            $sql= "$call query_reset_user_pass(:enpass,:user)";
        }
        $updpass = $rdb->prepare($sql);
        $updpass->bindValue(':user', $user);
        $updpass->bindValue(':enpass', $enpass);
        $updpass->execute();
        $err=$rdb->errorInfo();
        $updpass->closeCursor();
		
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
		$body .= "Below is your new password for My Web Recipe Manager.<br><br><hr>";
		$body .= "<b>Username:</b> $user<br>";
		$body .= "<b>New Password:</b> $pass<hr><br>";
		$body .= "We recommend you change this password as soon as possible.<br>";
		$body .= 'You can change it by selecting "Change Password" in the "Account" Menu.<br><br>';
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
        $message->setTo(array($email, $csuppemail));
        $message->setFrom("$csuppemail", "$clientname");

         if ($mailer->send($message)){
            echo 'yes';
         } else {
            echo "Message failed to send";
         }
         unset($_SESSION);
	}
?>

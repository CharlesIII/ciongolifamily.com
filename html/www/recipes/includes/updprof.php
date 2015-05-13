<?php
    require_once('rdb.php');
    
    //get the posted values
    
    if (isset($_POST['action'])) {
       $action=$_POST['action']; 
    }
    
    if(isset($action) && $action=='pw')  {
        $pass=$_POST['pword'];
        if (!$pass) {
             echo 'nopass';
          } else if ($pass and strlen($pass) < 6) {
              echo 'shortpass';
          } else if ($pass and strlen($pass) > 72) {
              echo 'longpass';
          } else {
              require('PasswordHash.php');
                $hasher = new PasswordHash(8, true);
                $pass = $hasher->HashPassword($pass);
                
                $sql="$call query_upd_owner_pass(:pass,:uid)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':pass', $pass);
                $rs->bindValue(':uid', $uid);
                $rs->execute();
    $err=$rdb->errorInfo();
                $rs->closeCursor();
                echo 'yes';
          }
    } else {
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email'])) {
           $email=ltrim($_POST['email']);
        }
          if (!$fname) {
             echo 'noname';
          } else if (!$email) {
              echo 'noemail';
          } else {
              $sql = "$call query_updated_email_in_use(:email,:uid)";
              $rsemail = $rdb->prepare($sql);
              $rsemail->bindValue(':email',$email);
              $rsemail->bindValue(':uid',$uid);
              $rsemail->execute();
              $err=$rdb->errorInfo();
              $erows = $rsemail->rowCount();
              $rsemail->closeCursor();
              
              if ($erows>0) {
                 echo 'emailexists';
                 exit;
              }
              $sql="$call query_upd_owner(:fname,:email,:uid)";
              $rs = $rdb->prepare($sql);
              $rs->bindValue(':fname', $fname);
              $rs->bindValue(':email', $email);
              $rs->bindValue(':uid', $uid);
              $rs->execute();
    $err=$rdb->errorInfo();
              $rs->closeCursor();
              
              if($lname) {
                $sql="$call query_upd_owner_lname(:lname,:uid)";
                $rs = $rdb->prepare($sql);
                $rs->bindValue(':lname', $lname);
                $rs->bindValue(':uid', $uid);
                $rs->execute();
    $err=$rdb->errorInfo();
                $rs->closeCursor();
                
              }
              echo 'yes';
          }
    }


   
?>

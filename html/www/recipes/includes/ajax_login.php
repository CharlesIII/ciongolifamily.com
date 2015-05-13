<?php
session_set_cookie_params(0, '/');
session_start();

//get the posted values
$suser=$_POST['user'];
$pass=$_POST['password'];

require_once('dbclient.php');
require_once('dbcalls.php');
if ($client=='wrm') {
    require_once('dbvars.php');
}
if($client!='wrm') {
    $user=$suser;
}

try {
    if ($client=='wrm') {
        $scdb = new PDO("mysql:host=$dbhost;dbname=$dbawbs", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    $rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e) {
    $msg = $e->getMessage();
}

if (!isset($msg)) {
    if ($client!='wrm') {
        require_once('check.php');
    }
	//select all users with suffix of the user entered
    if ($client=='wrm') {
        $luser= "%_".$suser;
	    $STH = $scdb->prepare('SELECT password, username, active FROM users WHERE username like :luser or username=:suser');
        $STH->bindValue(':luser', $luser);
        $STH->bindValue(':suser', $suser);
        $STH->execute();
        $err=$scdb->errorInfo();
    }  else {
        if($dbsql=='mysql') {
            $STH = $rdb->prepare('SELECT password, approved, id FROM owner WHERE BINARY owner = :user');
        } else {
            $STH = $rdb->prepare('SELECT password, approved, id FROM owner WHERE owner = :user');
        }
        $STH->bindValue(':user', $user);
        $STH->execute();
        $err=$rdb->errorInfo();
    }
	$rows = $STH->rowCount();
    $result=$STH->fetchAll(PDO::FETCH_BOTH);
    $STH->closeCursor();

	//if username exists
	if($rows>0) {
        if($client=='wrm') {
		    require_once('../awbs/tools/importfunctions.php');
            $epass = create_encoded_password(md5($pass));
        } else {
            require('PasswordHash.php');
            $hasher = new PasswordHash(8, true);
        }
		//loop through result to see if there is a matching password
		//if there is logon is successful and owner can be determined
		//otherwise login is unsuccessful
		foreach($result as $row) {
            $password = $row['password'];
            if($client!='wrm') {
                $check = $hasher->CheckPassword($pass, $password);
            }
			if((isset($epass) && $password == $epass)  || $pass==$password || (isset($check) && $check)) {
				//get the owner and user details
				if($client=='wrm') {
                    $user = $row['username'];
                    $sql= "$call query_owner_dbowner_ids(:user)";
                    $details = $rdb->prepare($sql);
                    $details->bindValue(':user', $user);
                    $details->execute();
                    $err=$rdb->errorInfo();
                    $result = $details->fetch(PDO::FETCH_BOTH);
                    $details->closeCursor();
                    
				    $uid=$result[0];
				    $oid=$result[1];
				    $owner=$result[2];
                }  else {
                    $uid=$row[2];
                    $status="active";
                }
				//check the owner is active
				if((isset($row['active']) && $row['active']) || (isset($row['approved']) && $row['approved'])) {
					//check the owners subscription is active
                    $sql="$call query_user_prefs(:uid)";
                    $ownerprefs = $rdb->prepare($sql);
                    $ownerprefs->bindValue(':uid', $uid);
                    $ownerprefs->execute();
                    $err=$rdb->errorInfo();
                    $ownerpref = $ownerprefs->fetch(PDO::FETCH_BOTH);
                    $ownerprefs->closeCursor();
                    
                    $toc=$ownerpref[0];
                    $catt=$ownerpref[1];
                    $seldate=$ownerpref[2];
                    $title=$ownerpref[4];
                    $paper=$ownerpref[5];
                    $dmeasure=$ownerpref[6];
                    $pdf=$ownerpref[7];
                    $numfmt=$ownerpref[9];
                    if (!isset($numfmt)) {
                        $numfmt='notset';
                    } else {
                        if($numfmt==0) {
                            $numfmt="1,000,000.00";
                        } else if($numfmt==1) {
                            $numfmt='1 000 000,000';
                        } else if($numfmt==2) {
                            $numfmt='1 000.000,000';
                        } else if($numfmt==3) {
                            $numfmt='1.000.000,000';
                        }    
                    }
                    $fracdec=$ownerpref[10];
                    if (!isset($fracdec)) {
                        $fracdec='notset';
                    } else {
                        if($fracdec==0) {
                            $fracdec='fraction';
                        } else {
                            $fracdec='decimal';
                        }
                    }
                    $region=$ownerpref[11];                    
                    if (!isset($region)) {
                        $region='notset';
                    } else {
                        $sql="SELECT region from region where id=:region";
                        $regionprefs = $rdb->prepare($sql);
                        $regionprefs->bindValue(':region', $region);
                        $regionprefs->execute();
                        $err=$rdb->errorInfo();
                        $regionpref = $regionprefs->fetch(PDO::FETCH_BOTH);
                        $regionprefs->closeCursor();
                        $region = $regionpref[0];
                    }
                    $groroz=$ownerpref[12];
                    if (!isset($groroz)) {
                        $groroz='notset';
                    } else {
                        if($groroz==0) {
                            $groroz='metric';
                        } else if($groroz==1) {
                            $groroz='imperial';
                        }            
                    }
                    $popovers=$ownerpref[13];
                    if(!$popovers) {
                        $popovers=FALSE; 
                    } else {
                        $popovers=TRUE;
                    }
					require_once('limit.php');
                    
					if ($status!='cancelled' || $row['approved']) {
                        $sql="$call query_user_welcome_pref(:uid)";
                        $welcomeprefs = $rdb->prepare($sql);
                        $welcomeprefs->bindValue(':uid', $uid);
                        $welcomeprefs->execute();
                        $err=$rdb->errorInfo();
                        $welcomepref = $welcomeprefs->fetch(PDO::FETCH_BOTH);
                        $welcomeprefs->closeCursor();
                        
                        $welcome=$welcomepref[0];
                        
                        if(!$welcome) {
                            $welcome=FALSE; 
                        } else {
                            $welcome=TRUE;
                        }
						if ($client=='wrm' && $status=='suspended') {
							$omsg = $status.'|'.$susmsg.'||'.$welcome;
						} else if($client=='wrm'){
							$omsg = $status.'||'.$welcome;
						} else {
                            $omsg = 'yes||'.$welcome;
                        }
                        require_once('get_latest_recipe.php');
                        if ($recrows>0) {
                            $id=$result[0];
                            require_once('get_recipe_owner.php');
                            $omsg .=  '|'.$id.'|'.$rowner;
                        }
                        $omsg .= '|'.$numfmt.'|'.$fracdec.'|'.$region."|".$groroz."|".$popovers;
                        echo $omsg;
                        if($client=='wrm') {
                            $sql="$call query_owner_prefs(:oid)";
                            $crapp = $rdb->prepare($sql);
                            $crapp->bindValue(':oid', $oid);
                        } else {
                            $sql="$call query_owner_prefs()";
                            $crapp = $rdb->prepare($sql);
                        }
                        $crapp->execute();
                        $err=$rdb->errorInfo();
                        if($client=='wrm') {
                            $rapp = $crapp->fetchColumn();
                        } else {
                            $rrows=$crapp->rowCount();
                            if($rrows>0) {
                                $rapp=TRUE;
                            } else {
                                $rapp=FALSE;
                            }
                        }
                        $crapp->closeCursor();
                        
                        $sql="$call query_owner_is_admin(:user)";
                        $dbadmin = $rdb->prepare($sql);
                        $dbadmin->bindValue(':user', $user);
                        $dbadmin->execute();
                        $err=$rdb->errorInfo();
                        $arows = $dbadmin->rowCount();
                        $dbadmin->closeCursor();
                        
                        if ($arows>0) {
                           $admin='yes';
                        }
                        
                        $sql="$call query_owner_is_guest(:user)";
                        $dbguest = $rdb->prepare($sql);
                        $dbguest->bindValue(':user', $user);
                        $dbguest->execute();
                        $err=$rdb->errorInfo();
                        $grows = $dbguest->rowCount();
                        $dbguest->closeCursor();
                        
                        if ($grows>0) {
                           $guest='yes';
                        }         
						//store the user and owner in a session along with thier ids
						//store short version of user for display purposes only
						$_SESSION[$client.'limit'] = $limit;
                        $_SESSION[$client.'uid'] = $uid;
                        $_SESSION[$client.'user'] = $user;
                        $_SESSION[$client.'suser'] = $suser;
                        if (isset($seldate)) {
                            $_SESSION[$client.'datefmt'] = $seldate;
                        }
                        $_SESSION[$client.'numfmt'] = $numfmt;
                        $_SESSION[$client.'fracdec'] = $fracdec;
                        $_SESSION[$client.'region'] = $region; 
                        $_SESSION[$client.'groroz'] = $groroz;
                        if (isset($toc)) {
                            $_SESSION[$client.'toc'] = $toc;
                        }
                        if (isset($catt)) {
                            $_SESSION[$client.'catt'] = $catt;
                        }
                        if (isset($pdf)) {
                            $_SESSION[$client.'pdf'] = $pdf;
                        }
                        if (isset($title)) {
                           $_SESSION[$client.'title'] = $title; 
                        }
                        if (isset($paper)) {
                            $_SESSION[$client.'paper'] = $paper;
                        }
                        if (isset($guest)) {
                            $_SESSION[$client.'guest'] = $guest;
                        }
                        if (isset($admin)) {
                            $_SESSION[$client.'admin'] = $admin;
                        }
                        if (isset($rapp)) {
                            $_SESSION[$client.'rapp'] = $rapp;
                        }
                        if (isset($dmeasure)) {
                            $_SESSION[$client.'dmeasure'] = $dmeasure;
                        }
                        if ($client=='wrm') {
						    $_SESSION[$client.'owner'] = $owner;
						    $_SESSION[$client.'oid'] = $oid;
						    $_SESSION[$client.'status'] = $status;
                        }
						session_write_close();
						//track the logon
						$logdate=date('c');
						$logtime = date("H:i:s");
						if ($client=='wrm' && $user=='demo') {
							$ip=$_SERVER['REMOTE_ADDR'];
                            $sql = $rdb->prepare("$call query_add_demo_login(:logdate, :logtime, :ip)");
                            $sql->bindValue(':logdate', $logdate);
                            $sql->bindValue(':logtime', $logtime);
                            $sql->bindValue(':ip', $ip);
                            $sql->execute();
                            $err=$rdb->errorInfo();
                            $sql->closeCursor();
						} else if($client=='wrm'){
							$logmethod='wrm';
                            $sql="$call query_add_logfrom_to_owner(:logmethod, :user)";
                            $sql = $rdb->prepare($sql);
                            $sql->bindValue(':logmethod', $logmethod);
                            $sql->bindValue(':user', $user);
                            $sql->execute();
                            $err=$rdb->errorInfo();
                            $sql->closeCursor();
                            
							require_once('../../awbsaccess.php');
                            
                            $sql="$call query_add_pass_to_owner(:sendstr, :user)";
                            $sql = $rdb->prepare($sql);
                            $sql->bindValue(':sendstr', $sendstr);
                            $sql->bindValue(':user', $user);
                            $sql->execute();
                            $err=$rdb->errorInfo();
                            $sql->closeCursor();
                            
                            $sql = $rdb->prepare("$call query_add_logdate_to_owner(:logdate, :user)");
                            $sql->bindValue(':logdate', $logdate);
                            $sql->bindValue(':user', $user);
                            $sql->execute();
                            $err=$rdb->errorInfo();
                            $sql->closeCursor();
						} else {
                            $sql = $rdb->prepare("$call query_add_logdate_to_owner(:logdate, :user)");
                            $sql->bindValue(':logdate', $logdate);
                            $sql->bindValue(':user', $user);
                            $sql->execute();
                            $err=$rdb->errorInfo();
                            $sql->closeCursor();    
                        }
                        $sql->closeCursor();                        
					} else {
                        if ($client=='wrm') {
						    echo $status;
                        } else {
                            echo 'unnapproved';
                        }
					}

				} else {
					echo 'inactive'; // user not active
				}
			} else {
				echo 'no';
			}
		}
	} else {
		echo 'no'; //Invalid Login
	}
} else {
    echo 'nodb';
}

?>
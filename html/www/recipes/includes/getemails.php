<?php
    require_once('rdb.php');

	$sql="SELECT email, name from email_history where owner=:uid order by email";
    $dbemail = $rdb->prepare($sql);
    $dbemail->bindValue(':uid', $uid);
    $dbemail->execute();
    $err=$rdb->errorInfo();
    $emailarray = $dbemail->fetchAll(PDO::FETCH_BOTH);
    $erows = $dbemail->rowCount();
    $dbemail->closeCursor();
    
    if ($erows>0) {
        for ($lt = 0; $lt < $erows; $lt++) {
            $email = $emailarray[$lt][0];
            $name = $emailarray[$lt][1];
            $str = $name.' ('.$email.')';     
            $emails[$lt] = array('value' => $str);
        }
        $response['emails'] = $emails;
        
        echo json_encode($response);
    }
?>
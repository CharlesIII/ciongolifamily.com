<?php
    require_once('rdb.php');
    
    if (isset($_POST['measure']) and $_POST['measure']!="") {
        $measure=$_POST['measure'];
        if(!isset($_POST['measureid'])) {
            $val=$measure;
            $var='measure';
            require_once('updateselecttables.php');
            $mid=$rid;
        } else {
            $mid=$_POST['measureid'];
        }
        $sql="$call query_add_measure_pref(:mid,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':mid', $mid);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();       
        $_SESSION[$client.'dmeasure']= $measure;
    } else {
        $sql="UPDATE owner SET measure=null where id=:uid";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
        unset($_SESSION[$client.'dmeasure']);
    } 

    if (isset($_POST['toc']) && $_POST['toc']=='on') { $toc=TRUE;} else { $toc=FALSE;}
    if (isset($_POST['catt']) && $_POST['catt']=='on') { $catt=TRUE;} else { $catt=FALSE;}
    if (isset($_POST['pdf']) && $_POST['pdf']=='on') { $pdf=TRUE;} else { $pdf=FALSE;}
    if (isset($_POST['welcome']) && $_POST['welcome']=='on') { $welcome=TRUE;} else { $welcome=FALSE;}
    if (isset($_POST['rapp']) && $_POST['rapp']=='on') {
        $rapp=TRUE;
    } else {
        $rapp=FALSE;
    }                                      
    $_SESSION[$client.'rapp'] = $rapp;
    $_SESSION[$client.'toc'] = $toc;
    $_SESSION[$client.'catt'] = $catt;
    $_SESSION[$client.'pdf'] = $pdf;
    
    $sql="$call query_add_eboption_prefs(:toc, :catt, :welcome, :pdf, :rapp, :uid)";
    $rs = $rdb->prepare($sql);
    $rs->bindValue(':toc', $toc,PDO::PARAM_BOOL);
    $rs->bindValue(':catt', $catt, PDO::PARAM_BOOL);
    $rs->bindValue(':welcome', $welcome, PDO::PARAM_BOOL);
    $rs->bindValue(':pdf', $pdf, PDO::PARAM_BOOL);
    $rs->bindValue(':rapp', $rapp, PDO::PARAM_BOOL);
    $rs->bindValue(':uid', $uid);
    $rs->execute();
    $err=$rdb->errorInfo();
    $rs->closeCursor();

    if (isset($_POST['title']) and $_POST['title']!="") {
        $title=$_POST['title'];
        $sql="$call query_add_ebtitle_pref(:title,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':title', $title);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
        $_SESSION[$client.'title'] = $title;
    } else {
        $sql="UPDATE owner SET ebtitle=null where id=:uid";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
        unset($_SESSION[$client.'title']);
    }
    if (isset($_POST['popovers']) and $_POST['popovers']=='on') {
        $popovers = TRUE;
    } else {
        $popovers = FALSE;
    }
    $sql="UPDATE owner set popovers=:popovers where id=:uid";
    $rs = $rdb->prepare($sql);
    $rs->bindValue(':popovers', $popovers, PDO::PARAM_BOOL);
    $rs->bindValue(':uid', $uid);
    $rs->execute();
    $err=$rdb->errorInfo();
    $rs->closeCursor();
    if (isset($_POST['date']) and $_POST['date']!="") {
        $date=$_POST['date'];
        $sql="$call query_add_date_pref(:date,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':date', $date);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
        $_SESSION[$client.'datefmt'] = $date;
    }
    if (isset($_POST['numfmtid'])) {
        $numfmt=$_POST['numfmtid'];
        $sql="$call query_add_numfmt_pref(:numfmt,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':numfmt', $numfmt);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
    }
    
    if (isset($_POST['fracdecid'])) {
        $fracdec=$_POST['fracdecid'];
        $sql="$call query_add_fracdec_pref(:fracdec,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':fracdec', $fracdec);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
    }
    
    if (isset($_POST['regionid'])) {
        $region=$_POST['regionid'];
        $sql="$call query_add_region_pref(:region,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':region', $region);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();    
    }
    
    if (isset($_POST['grorozid'])) {
        $groroz=$_POST['grorozid'];
        $sql="UPDATE owner set groroz=:groroz where id=:uid";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':groroz', $groroz);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
    }
    
    if (isset($_POST['paper']) and $_POST['paper']!="") {
        $paper=$_POST['paper'];
        $sql="$call query_add_paper_pref(:paper,:uid)";
        $rs = $rdb->prepare($sql);
        $rs->bindValue(':paper', $paper);
        $rs->bindValue(':uid', $uid);
        $rs->execute();
        $err=$rdb->errorInfo();
        $rs->closeCursor();
        $_SESSION[$client.'paper'] = $paper;
    }
?>
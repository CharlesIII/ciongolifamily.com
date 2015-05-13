<?php
// ----------------------------------------------------------------------------
// --- ajax.php
// ----------------------------------------------------------------------------

require_once('rdb.php');

$id = $_POST["listid"];

if (isset($id))  {
    $sql = "$call query_list(:id,:uid)";
    $getl = $rdb->prepare($sql);
    $getl->bindValue(':id', $id);
    $getl->bindValue(':uid', $uid);
    $getl->execute();
    $err=$rdb->errorInfo();
    $rows = $getl->rowCount();
    $get = $getl->fetchAll(PDO::FETCH_BOTH);
    $getl->closeCursor();
    
    for ($lt=0;$lt < $rows;$lt++) {
            unset($image);
            unset($recid);
            unset($aisle);
            unset($aisle_order);
            $listitem = $get[$lt][0];
            $ing = $get[$lt][1];
            $aisle = $get[$lt][2];
            $recid = $get[$lt][3];
            $aisle_order = $get[$lt][4];
            
            if(isset($recid)) {
                $sql="select name from recipe where id=$recid";
                $recname = $rdb->prepare($sql);
                $recname->execute();
                $err=$rdb->errorInfo();
                $recnames = $recname->fetch(PDO::FETCH_BOTH);
                $recname->closeCursor();
                
                if(isset($recnames[0])) {
                    $name=$recnames[0];
                }
                
                $sql="$call query_recipe_images(:recid)";
                $rsimgs = $rdb->prepare($sql);
                $rsimgs->bindValue(':recid', $recid);
                $rsimgs->execute();
                $err=$rdb->errorInfo();
                $imgrows = $rsimgs->rowCount();
                $rsimg = $rsimgs->fetch(PDO::FETCH_BOTH);
                $rsimgs->closeCursor();
                
                if ($imgrows>0) {
                        $image=$rsimg[1];            
                }
            }
            $ings[$lt] = array('item' => $listitem, 'ing' => $ing);
            if(isset($aisle)) {
                $ings[$lt]['aisle'] = $aisle;               
            } else {
                $ings[$lt]['aisle'] = null;
            }
            if(isset($image)) {
                $ings[$lt]['image'] = $image;               
            } else {
                $ings[$lt]['image'] = null;
            }
            if(isset($name)) {
                $ings[$lt]['name'] = $name;               
            } else {
                $ings[$lt]['name'] = null;
            }
            if(isset($recid)) {
                $ings[$lt]['recid'] = $recid;               
            } else {
                $ings[$lt]['recid'] = null;
            }
            if(isset($aisle_order)) {
                $ings[$lt]['aisle_order'] = $aisle_order;               
            } else {
                $ings[$lt]['aisle_order'] = null;
            }
    }
    if(isset($ings)) {
     $response['ings'] = $ings;
     echo json_encode($response);
    } else {
        echo 'noitems';
    }
    
}
?>
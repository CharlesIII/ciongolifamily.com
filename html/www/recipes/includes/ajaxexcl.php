<?php
// ----------------------------------------------------------------------------
// --- ajax.php
// ----------------------------------------------------------------------------

require_once('rdb.php');

$sql = "$call query_owner_excl_ingredients(:uid)";
$rse = $rdb->prepare($sql);
$rse->bindValue(':uid', $uid);
$rse->execute();
$err=$rdb->errorInfo();
$ingnum = $rse->rowCount();
$rs = $rse->fetchAll(PDO::FETCH_BOTH);
$rse->closeCursor();

if ($ingnum>0) {
  for ($lt=0;$lt < $ingnum;$lt++) {

    if ($lt==0) {
      $data1 = $ingnum.'||'.$rs[$lt][0];
      $data2 = $rs[$lt][1];
    } else {
      $data1 .= "|".$rs[$lt][0];
      $data2 .= "|".$rs[$lt][1];
    }
  }
  $data=$data1.'||'.$data2;
  echo $data;
}
?>
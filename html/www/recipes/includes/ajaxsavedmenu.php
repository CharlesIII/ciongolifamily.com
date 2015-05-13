<?php
// ----------------------------------------------------------------------------
// --- ajax.php
// ----------------------------------------------------------------------------

require_once('rdb.php');

$id = $_POST["menuid"];

$sql = "SELECT link, recipe, day, rank, meal FROM menu_recipe where menu=:id ORDER BY day, meal,rank";
$getm = $rdb->prepare($sql);
$getm->bindValue(':id', $id);
$getm->execute();
$err=$rdb->errorInfo();
$rows = $getm->rowCount();
$get = $getm->fetchAll(PDO::FETCH_BOTH);
$getm->closeCursor();

if ($rows>0) {
  for ($lt=0;$lt < $rows;$lt++) {
    $link=$get[$lt][0];
    $recipe=$get[$lt][1];
    $day=$get[$lt][2];
    $order=$get[$lt][3];
    $meal=$get[$lt][4];
    if (!isset($meal)) {
        $meal='b';
    }
    if ($lt==0) {
      $data = $link.'|'.$recipe.'|'.$day.'|'.$order.'|'.$meal;
    } else {
      $data .= "||".$link.'|'.$recipe.'|'.$day.'|'.$order.'|'.$meal;
    }
  }
  echo $data;
}
?>
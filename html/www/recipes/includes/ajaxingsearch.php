<?php
      require_once('rdb.php');
      
      if(isset($_POST['oid'])) {
        $oid = $_POST['oid'];
      }

      $sql = "$call query_owner_ingredients_ids(:uid)";  //return all ingredients from db
      $dbingredient = $rdb->prepare($sql);
      $dbingredient->bindValue(':uid', $uid);
      $dbingredient->execute();
      $err=$rdb->errorInfo();
      $numings = $dbingredient->rowCount();
      $rsingredient = $dbingredient->fetchAll(PDO::FETCH_BOTH);
      $dbingredient->closeCursor();
      
      $inglist=explode("\n", $_POST['ingredient']);
      $ict=count($inglist);
      $searchlist[0]="";
      
      foreach($inglist as $key => $value) {
          if ($value!="") {
              $allvalues=explode(',',$value);
              if(isset($allvalues[0])) {
                  $value1=$allvalues[0];
              }
              if(isset($allvalues[1])) {
                  $value2=$allvalues[1];
              }
              for ($lt = 0; $lt < $numings; $lt++) {
                  $ingname= $rsingredient[$lt][1];
                  $pos1=stripos($ingname,"Broth");
                  $pos2=stripos($ingname,"Stock");
                  $pos3=stripos($ingname,"Bouil");
                  $pos4=stripos($ingname,"Extract");
                  $pos5=stripos($ingname,"Essence");
                  if (isset($value2)) {
                      if(stripos($ingname,"$value1")>-1 || stripos($ingname,"$value2")>-1) {
                          if ($pos1===false and $pos2===false and $pos3===false and $pos4===false and $pos5===false) {
                              $searchlist[$key] .= $rsingredient[$lt][0].", ";
                          }
                      }
                  } else {
                      if(stripos($ingname,"$value1")>-1) {
                          if ($pos1===false and $pos2===false and $pos3===false and $pos4===false and $pos5===false) {
                              $searchlist[$key] .= $rsingredient[$lt][0].", ";
                          }
                      }
                  }
              }
              $searchlist[$key] = substr($searchlist[$key],0,strlen($searchlist[$key])-2);
          }
      }
      if($client=='wrm') {
          $sql= "select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where approved is true and visible is true and owner in (select id from owner where dboid=$oid)) and ing in(";
          foreach($searchlist as $key => $value) {
              if($key==0) {
                  $sql .= $value.")";
              } else {
                  if ($_POST['reqnum']=='Any') {
                      $sql .= "union select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where owner in (select id from owner where dboid=$oid) and approved is true and visible is true) and ing in($value)";
                  } else {
                      $sql .= "intersect select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where owner in (select id from owner where dboid=$oid) and approved is true and visible is true) and ing in($value)";
                  }
              }
          }
          $sql .= " order by name";
          $dbrec = $rdb->prepare($sql);
          $dbrec->execute();
          $err=$rdb->errorInfo();
          $numrsrec = $dbrec->rowCount();
          $rsrec = $dbrec->fetchAll(PDO::FETCH_BOTH);
          $dbrec->closeCursor();
      } else {
          $sql= "select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where approved is true and visible is true) and ing in(";
          foreach($searchlist as $key => $value) {
              if($key==0) {
                  $sql .= $value.")";
              } else {
                  if ($_POST['reqnum']=='Any') {
                      $sql .= "union select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where  approved is true and visible is true) and ing in($value)";
                  } else {
                      $sql .= "intersect select DISTINCT recipe, get_recipename(recipe) as name from recipe_ing where recipe in(SELECT distinct id FROM recipe where approved is true and visible is true) and ing in($value)";
                  }
              }
          }
          $sql .= " order by name";
          $dbrec = $rdb->prepare($sql);
          $dbrec->execute();
          $err=$rdb->errorInfo();
          $numrsrec = $dbrec->rowCount();
          $rsrec = $dbrec->fetchAll(PDO::FETCH_BOTH);
          $dbrec->closeCursor();
      }
      
      for ($lt = 0; $lt < $numrsrec; $lt++) {
          $id = $rsrec[$lt][0];
          if($lt==0) {
              $idlist="$id";
          } else {
              $idlist .= ",$id";
          }
      }
      if(isset($idlist)) {
          require_once('searchmenu.php');
      }
?>

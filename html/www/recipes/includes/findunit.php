<?php
 foreach ($mwunitarray as $qvalue) {
      if (stripos($line,$qvalue[0])!==false) {
         ${'unit'.$key}=$qvalue[0];
         $line=str_ireplace($qvalue[0],'',$line);
         break;
      }
 }
 $linearray=explode(' ',$line);
 foreach ($linearray as $wkey => $word) {
      foreach ($unitarray as $uvalue) {
          if (strtolower($word)==$uvalue[0]) {
             ${'unit'.$key}=$word;
             unset($linearray[$wkey]);
             break;
          }
     }
 }
 $uc=-1;
 foreach ($linearray as $wordsleft) {
     $uc++;
     if ($uc==0) {
          $line =   $wordsleft;
     } else {
        $line .=  ' '.$wordsleft;
     }
 }
?>

<?PHP
   @set_time_limit(36000);
   unset($image);
   require('getrecipe.php');
   $name = iconv('UTF-8', 'windows-1252', $name);
   if ($imgrows>0) {
      $image=$rsimg[0][1];
   }
   $measure = iconv('UTF-8', 'windows-1252', $measure);

   $pdf->AddPage();

   $ratingimg="$rating.png";

   $pdf->SetFont('tahoma bold','',$toctfont);
   $pdf->Write(7,$name,0,'L');
   
   if ($rating>0) {
      $pdf->Ln(10);
      $pdf->Image("images/$ratingimg",null,null,0,0);
      
   }
   if (isset($toc) && $toc) {
	 if (isset($scatmenu)) {
		$pdf->TOC_Entry($name, 2, 'r');
	 } else {
		$pdf->TOC_Entry($name, 1, 'r');
	 }
   }
   if (isset($image)) {
	  $size=getimagesize("images/recipe/$image");
	  $width=$size[0];
	  $height=$size[1];
	  $move=($width/2.95)+5;
	  $belowpic=($height/2.95)+20;
	  $pdf->Ln(10);
	  $pdf->Image("images/recipe/$image",20,35,0,0,'JPEG');
	  $pdf->SetY($belowpic);

   }
   if ($irows>0) {
      if(isset($image)) {
          $pdf->Ln(5);
      }else{
          $pdf->Ln(10);
      }
	  $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','U',$font);
	  $pdf->Cell(0,$lh,'Ingredients');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Ln(10);

	  for ($lt1 = 0; $lt1 < $irows; $lt1++) {
		 $quantity = $rsing[$lt1][0];
		 $unit = $rsing[$lt1][1];
         $unit = iconv('UTF-8', 'windows-1252', $unit);
		 $ingline=$quantity.' '.$unit;
		 $quantity2 = $rsing[$lt1][5];
		 $unit2 = $rsing[$lt1][6];
         $unit2 = iconv('UTF-8', 'windows-1252', $unit2);
		 if ($quantity2 and $unit2) {
			$ingline .= '('.$quantity2.' '.$unit2.')';
		 } else if ($quantity2) {
			$ingline .= '('.$quantity2.')';
		 } else if ($unit2) {
			$ingline .= '('.$unit2.')';
		 }
		 $ing = $rsing[$lt1][2];
         $ing = iconv('UTF-8', 'windows-1252', $ing);
		 $ingline .= ' '.$ing;
		 $pp = $rsing[$lt1][3];
		 if (isset($pp)) {
            $pp=iconv('UTF-8', 'windows-1252', $pp);
			$ingline .= ', '.$pp;
		 }
		 $pp = $rsing[$lt1][4];
		 if (isset($pp)) {
            $pp=iconv('UTF-8', 'windows-1252', $pp);
			$ingline .= ', '.$pp;
		 }
		 $ingline=trim($ingline);
		 $pdf->MultiCell(0,$lh,$ingline,0,'L');
	  }
   }
   if (isset($note)) {
      $note=iconv('UTF-8', 'windows-1252', stripslashes($note));
      $pdf->Ln(5);
      //$pdf->SetTextColor(161, 88, 131);
      $pdf->SetFont('tahoma bold','U',$font);
      $pdf->Cell(0,$lh,'Notes');
      $pdf->Ln(10);
      //$pdf->SetTextColor(2,2,2);
      $pdf->SetFont('tahoma','',$font);
      $pdf->Write($lh,$note);
      $pdf->Ln(5);
   }
   if (isset($directions)) {
	  $directions=iconv('UTF-8', 'windows-1252', stripslashes($directions));
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','U',$font);
	  $pdf->Cell(0,$lh,'Directions');
	  $pdf->Ln(10);
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write($lh,$directions);
   }
   $pdf->Ln(5);
   if (isset($measure) && $measure!='') {
		 $pdf->Ln(5);
		 //$pdf->SetTextColor(161, 88, 131);
		 $pdf->SetFont('tahoma bold','',$font);
		 $pdf->Write(null,'Measurement System: ');
		 //$pdf->SetTextColor(2,2,2);
		 $pdf->SetFont('tahoma','',$font);
		 $pdf->Write(null,$measure);
	  }
   if (isset($yield) && $yield!='') {
	  $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Makes: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$yield);
      if(isset($yield_unit)) {
          $yield_unit = iconv('UTF-8', 'windows-1252', $yield_unit);
          $pdf->Write(null,' '.$yield_unit);
      }
   }
   if ($tried) {
	   $tried = "Yes";
   } else {
	   $tried = "No";
   }
   if ($tried) {
	  $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Tried: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$tried);
   }

   if (isset($preptime)) {
	  $preptime = iconv('UTF-8', 'windows-1252', $preptime);
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Preparation Time: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$preptime);
   }
   if (isset($cooktime)) {
	  $cooktime = iconv('UTF-8', 'windows-1252', $cooktime);
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Cooking Time: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$cooktime);
   }
   if (isset($cuisine)) {
      $cuisine=iconv('UTF-8', 'windows-1252', $cuisine);
	  $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Cuisine: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$cuisine);
   }

   for ($lt1 = 0; $lt1 < $drows; $lt1++) {
	  $diet = iconv('UTF-8', 'windows-1252', $rsdiet[$lt1][0]);
	  if ($lt1 > 0) {
		   	$pdf->Write(null,', '.$diet);
	  } else {
			$pdf->Ln(5);
			//$pdf->SetTextColor(161, 88, 131);
			$pdf->SetFont('tahoma bold','',$font);
			$pdf->Write(null,'Diet/s: ');
			//$pdf->SetTextColor(2,2,2);
			$pdf->SetFont('tahoma','',$font);
			$pdf->Write(null,$diet);
	  }
   }
   $pdf->Ln(5);

   for ($lt1 = 0; $lt1 < $srows; $lt1++) {
       unset($cat);
       unset($subcat);
       if (isset($rscat[$lt1][0])) {
	        $cat = iconv('UTF-8', 'windows-1252', $rscat[$lt1][0]);
       }
       if (isset($rscat[$lt1][1])) {
	        $subcat = iconv('UTF-8', 'windows-1252', $rscat[$lt1][1]);
       }
	   if ($lt1 > 0) {
		   if (isset($subcat)) {
			   $pdf->Write(null,', '.$cat.': '.$subcat);
		   } else {
			   $pdf->Write(null,', '.$cat);
		   }
	   } else {
		   if (isset($subcat)) {
               $pdf->SetFont('tahoma bold','',$font);
               $pdf->Write(null,'Recipe Types & Categories: ');
               $pdf->SetFont('tahoma','',$font);
			   $pdf->Write(null,' '.$cat.': '.$subcat);
		   } else {
               $pdf->SetFont('tahoma bold','',$font);
               $pdf->Write(null,'Recipe Types: ');
               $pdf->SetFont('tahoma','',$font);
			   $pdf->Write(null,' '.$cat);
		   }
	   }
   }
   if (isset($source)) {
	  $source = iconv('UTF-8', 'windows-1252', $source);
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Source: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$source);
   }
   if (isset($addedby)) {
      $addedby = iconv('UTF-8', 'windows-1252', $addedby);
      $pdf->Ln(10);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Added By: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$addedby);
   }
   if (isset($added)) {
	  $added = iconv('UTF-8', 'windows-1252', $added);
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Added: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$added);
   }
   if (isset($updated)) {
	  $updated = iconv('UTF-8', 'windows-1252', $updated);
      $pdf->Ln(5);
	  //$pdf->SetTextColor(161, 88, 131);
	  $pdf->SetFont('tahoma bold','',$font);
	  $pdf->Write(null,'Last Modified: ');
	  //$pdf->SetTextColor(2,2,2);
	  $pdf->SetFont('tahoma','',$font);
	  $pdf->Write(null,$updated);
   }
   for ($lt1 = 0; $lt1 < $rrrows; $lt1++) {
      if ($id == $rsrel[$lt1][0]) {
          $relid = $rsrel[$lt1][1];
          $relname= iconv('UTF-8', 'windows-1252', $rsrel[$lt1][3]);
      }
      if ($lt1 == 0) {
         $pdf->Ln(10);
         //$pdf->SetTextColor(161, 88, 131);
         $pdf->SetFont('tahoma bold','U',$font);
         $pdf->Cell(0,$lh,'Related Recipes');
         $pdf->Ln(5);
         //$pdf->SetTextColor(2,2,2);
         $pdf->SetFont('tahoma','',$font);
         $pdf->Write($lh,$relname);
      } else {
         $pdf->Ln();
         //$pdf->SetTextColor(2,2,2);
         $pdf->SetFont('tahoma','',$font);
         $pdf->Write($lh,$relname);
      }
   }
   $extraimages=$imgrows-1;
   if ($extraimages>0) {
       require('thumbnail_create.php');
       $pdf->AddPage();
       for ($lt2 = 1; $lt2 < $extraimages+1; $lt2++) {
            $image=$rsimg[$lt2][1];
            $sourcedir = "images/recipe/$image";
            list($image_width,$image_height) = getimagesize("$sourcedir");
            $start_x = $pdf->GetX();
            $start_y = $pdf->GetY();

           // place image and move cursor to proper place. "+ 5" added for buffer
           $pdf->Image($sourcedir,$pdf->GetX(),$pdf->GetY() + 5,0,0,'JPEG');
           //$pdf->Image($sourcedir, $pdf->GetX(), $pdf->GetY() + 5, $image_height, $image_width);

           if ($lt2 == 1 || $lt2 == 4  || $lt2 == 7) {
                $height1= $image_height/2.95;
                $pdf->SetXY($start_x + $image_width/2.95 + 5, $start_y);
           } else if ($lt2 == 2 || $lt2 == 5  || $lt2 == 8) {
               $height2= $image_height/2.95;
               $pdf->SetXY($start_x + $image_width/2.95 + 5, $start_y);
           } else {
               $height3= $image_height/2.95;
               $height= max($height1,$height2,$height3);
               $pdf->SetXY(20, $start_y + $height + 10);
           }

        }
      
   }
   if (isset($pdfimage) && isset($_POST['pdf'])) {
	  $withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/", "",$pdfimage);
	  $pdfjpg = $withoutExt.'.jpg';
	  if (file_exists('images/recipe/'.$withoutExt.'-0.jpg')) {
		 foreach (glob('images/recipe/'.$withoutExt.'*.jpg') as $filename) {
			if ($filename!="images/recipe/$pdfjpg") {
			   $pdf->AddPage();
			   $pdf->Image("$filename",20,10,0,0,'JPEG');
			}
		 }
	  }
   }
?>

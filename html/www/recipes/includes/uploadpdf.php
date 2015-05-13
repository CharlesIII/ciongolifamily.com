<?php
	require_once('dbclient.php');

	$sourcedir = $_FILES['file']['tmp_name'];
	$targetdir = "../imagetmp/".str_replace(' ','_',$_FILES['file']['name']);
	rename($sourcedir, $targetdir);


   $withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/", "", str_replace(' ','_',basename($_FILES['file']['name'])));
   $newimage = '../imagetmp/'.$withoutExt.'-%d.jpg';
   $convert = $impath."convert $targetdir -quality 100% $newimage";

   exec($convert);

   $files = glob("../imagetmp/$withoutExt*.jpg");
   $imgs='';
   foreach ($files as &$value) {
           $imgs .= ' '.$value;
   }
   $imgs=trim($imgs);
   $newimage = '../imagetmp/'.$withoutExt.'.jpg';
   $combine = $impath."convert $imgs -append  $newimage";

   exec($combine);

   echo "1";
?>
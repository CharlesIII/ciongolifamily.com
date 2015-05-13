<?php
if (!empty($_FILES)) {
	$target = "../imagetmp/".basename($_FILES['file']['name']);
	list($width,$height) = getimagesize($_FILES['file']['tmp_name']);
	if ($width > 250) {$width = 250;}
	if ($height > 250) {$height = 250;}
	require_once('thumbnail_create.php');
	$a = new Thumbnail($_FILES['file']['tmp_name'],$width,$height,$target,80,'"bevel(0)"');

	if($a) {
		echo "1";
	}
}
?>
<?php
if (!empty($_FILES)) {
	$sourcedir = $_FILES['file']['tmp_name'];
	$targetdir = "../imagetmp/".str_replace(' ','_',$_FILES['file']['name']);
	rename($sourcedir, $targetdir);
}
?>
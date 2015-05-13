$(document).ready(function(){
	$(document).on('click', ".back", function() {
		var cpage = window.location.pathname;
		if (cpage=='/wrm/pasterules.php' || cpage=='/pasterules.php' || cpage=='/mywrm/pasterules.php') {
			top.location.href = 'pasterecipe.php';
		} else if (cpage=='/wrm/import_format.php' || cpage=='/import_format.php'  || cpage=='/mywrm/import_format.php') {
			top.location.href = 'import_multi_recipes.php'; 
		} else if (cpage=='/wrm/upload_multi_images.php' || cpage=='/upload_multi_images.php' || cpage=='/mywrm/upload_multi_images.php') {
			top.location.href = 'import_multi_recipes.php';	
		} else if (cpage=='/wrm/mm-abbrev.php' || cpage=='/mm-abbrev.php' || cpage=='/mywrm/mm-abbrev.php') {
            top.location.href = 'export.php';
        }
	});
});
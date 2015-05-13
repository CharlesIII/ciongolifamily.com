$(document).ready(function(){
	$(document).on('click', ".hidevid", function() {
		$('.hidevid').hide();
		$('#showvid').show();
		$('.embed-container').hide();
	    return false;
	});
	$(document).on('click', "#showvid", function() {
		$(this).hide();
		$('.embed-container').show();
		$('.hidevid').show();
		    return false;
	});
	$(document).on('click', ".hidepdf", function() {
		$('.hidepdf').hide();
		$('#showpdf').show();
		$('.pdf').hide();
	    return false;
	});
	$(document).on('click', "#showpdf", function() {
		$(this).hide();
		$('.pdf').show();
		$('.hidepdf').show();
		    return false;
	});
	$(document).on('click', "#hideimg", function() {
		$(this).hide();
		$('#showimg').show();
		$('.imagedisp').hide();
	    return false;
	});
	$(document).on('click', "#showimg", function() {
		$(this).hide();
		$('.imagedisp').show();
		$('#hideimg').show();
		    return false;
	});
});
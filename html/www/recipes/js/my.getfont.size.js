$(document).ready(function() {
    var fontsize = $.cookie('fontsize');
    // Set the user preference for fontsize
    if (fontsize=='small') {
       $('#font').val('small'); 
	};
    if (fontsize=='med') {
        $('#font').val('med');
	};
    if (fontsize=='large') {
        $('#font').val('large');
	};
    
});

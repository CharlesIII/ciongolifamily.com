$(document).ready(function() {
    var fontsize = $.cookie('fontsize');
    // Set the user preference for fontsize
    if (fontsize=='small') {
        $("body").css("font-size","12px");
	    $("body").css("line-height","auto");
    }    
    if (fontsize=='med') {
        $("body").css("font-size","14px");
	    $("body").css("line-height","auto");

    }
    if (fontsize=='large') {
        $("body").css("font-size","16px");
	    $("body").css("line-height","auto");

    }
    $(document).on('click', "#small", function() {
        $("body").css("font-size","12px");
	    $("body").css("line-height","auto");
        $.cookie('fontsize','small', { expires: 9999, path: '/' });
    });
    $(document).on('click', "#med", function() {
        $("body").css("font-size","14px");
	    $("body").css("line-height","auto");
        $.cookie('fontsize','med', { expires: 9999, path: '/' });
    });
    $(document).on('click', "#large", function() {
        $("body").css("font-size","16px");
	    $("body").css("line-height","auto");
        $.cookie('fontsize','large', { expires: 9999, path: '/' });
    });
});

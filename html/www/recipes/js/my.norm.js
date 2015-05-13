function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
$(window).load(function () {
   $('.btn').removeAttr('disabled');
   $("#msgbox").removeClass().hide();
});
$(document).ready(function() {
    $(".rlist").change(function() {
        if(this.value!='Select a recipe to view...') {
            $.cookie('rid',this.value, { path: '/' });
            window.open(this.children[this.selectedIndex].getAttribute('href'),"_blank");
        }
    });
	$("#normalise").submit(function() {
                $(".message_box").addClass('ok');
                $(".message_box").html('Applying changes...');
                $(".message_box").show();                                
    });
    var cpage = window.location.pathname;
    $("#usermaint").tablesorter({widgets: ['zebra']});
	
	$('.tcase').click(function() {
		$(".message_box").html('Convering...').show();
		$('.ing').each(function(index) {
			$(this).val(toTitleCase($(this).val()));
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	    
	});
	$('.lcase').click(function() {
		$(".message_box").html('Convering...').show();
		$('.ing').each(function(index) {
		    $(this).val($(this).val().toLowerCase());
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	});
	$('.tcase_not_upper').click(function() {
		$(".message_box").html('Convering...').show();
		$('.ing').each(function(index) {
		    if ($(this).val().toUpperCase()!==$(this).val()) {
			$(this).val(toTitleCase($(this).val()));
		    }    
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	    
	});
	$('.lcase_not_upper').click(function() {
		$(".message_box").html('Convering...').show();
		$('.ing').each(function(index) {
		    if ($(this).val().toUpperCase()!==$(this).val()) {
			$(this).val($(this).val().toLowerCase());
		    }
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	});
	$('.tcase').click(function() {
		$(".message_box").html('Convering...').show();
		$('.recipe').each(function(index) {
		    $(this).val(toTitleCase($(this).val()));
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	    
	});
	$('.lcase').click(function() {
		$(".message_box").html('Convering...').show();
		$('.recipe').each(function(index) {
		    $(this).val($(this).val().toLowerCase());
		});
		$(".message_box").html('<img class=close_message src="images/ok.png">Conversion complete');
	});
});
$(function () {
	$(window).scroll(function(){
		var newtop = ($(window).scrollTop() + 100) + 'px';
		$(".message_box").css('top', newtop);
		var top_offset = 100;
		$(".message_box").animate({top: ($(window).scrollTop() + top_offset)  +"px" },{queue: false, duration: 350});
	});
	$(document).on('click', ".close_message", function() {
		$('.message_box').hide();
	});
});
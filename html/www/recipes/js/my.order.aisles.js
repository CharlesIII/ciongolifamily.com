
$(function() {
	$("#sortme").sortable({
		scroll : true,
		update : function () {
			var order = $('#sortme').sortable('serialize');
			$.post("includes/updaisleorder.php", order,function(data) {
                if(data=="nodb"){
                    $(".message_box").removeClass('ok');
                    $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                    return false;
               }
            });
		}
	});
});

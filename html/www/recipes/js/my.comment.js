$(document).ready(function(){
	$("#comment").submit(function(){
	//remove all the class add the messagebox classes and start fading
	$(".message_box").addClass('ok');
	$(".message_box").html('Submitting...');
	$(".message_box").show();
	  
	  var inData = "";
	  var ct=0;
	  
	  function appGET(data, str) {
		if (data && data != 'undefined') {
			data = encodeURIComponent(html_entity_decode(data));
			if (ct == 0) {
			   inData += str + '=' + data;
			} else {
			   inData += '&' + str + '=' + data;
			}
			ct++;
		}
	  }
	  
	  appGET($('#id').val(), 'id');
	  appGET($('#message').val(), 'message');
	  appGET($('#admin').val(), 'admin');
	  
		$.post("includes/submitcomment.php",inData,function(data) {
			var parsed = data.split('|');
			var cnum = parsed[0];
			var msg = parsed[1];
            var user = parsed[2];
			if (msg=='Submission Successful') {
				var mess = $('#message').val();
				var d = new Date();
			
				var weekday=new Array(7);
				weekday[0]="Sunday";
				weekday[1]="Monday";
				weekday[2]="Tuesday";
				weekday[3]="Wednesday";
				weekday[4]="Thursday";
				weekday[5]="Friday";
				weekday[6]="Saturday"
				var day=weekday[d.getDay()]
				var month=parseInt(d.getMonth())+1;
				var seldate=$('#seldate').val();
				if (seldate!="") {
					if (seldate==0) {
						var date= d.getDate() +'.'+month+'.'+ d.getFullYear().toString().slice(2);
					}  else {
						var date= month +'.'+d.getDate()+'.'+ d.getFullYear().toString().slice(2);
					}
				}  else {
					var date= month +'.'+d.getDate()+'.'+ d.getFullYear().toString().slice(2);
				}
				if (d.getHours()<12) {
					var m='am';
				} else {
					var m='pm';
				}
				var time= d.getHours() + ':' + d.getMinutes() + m;
				if (cnum==1){
					$("#ccnum").html('There is currently 1 comment for this recipe');
				} else {
					$("#ccnum").html('There are currently ' + cnum + ' comments for this recipe');
				}
				var newhtml='';
				newhtml += '<p>Comment: ' + mess + '</p><p class=postedby>Posted by ' + user + ' on ' + day + ', ' + date + ' @ ' + time + '</p>\n\n' + $('#newcom').html();
				$('#newcom').html(newhtml);
				$(".message_box").addClass('ok');
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                $(".message_box").show();
                $('#message').val("");
                $('#currentcomments').show();
			} else if(data=="nodb"){
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
            } else {
				$(".message_box").removeClass('ok');
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                $(".message_box").show();
			}
		 
		});
		return false;//not to post the  form physically
	});
	$(document).on('click', "#more", function() {
		$(this).hide();
		$('.commentbody').show();
		return false;
	});
});
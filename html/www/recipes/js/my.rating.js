$(document).ready(function() {
	$.each([1,2,3,4,5,6], function(i){
	    $('.star_' + i).on('click',(function(i){ 
	        return function(event) {
				var current_star = $(this).attr("class").split("_")[1].substring(0,1);
				$(".message_box").html('Recording your rating...');
				$(".message_box").show();
				$.post("includes/updrating.php",{recid:$('#id').val(),rating:current_star} ,function(data) {
                    if(data=="nodb"){
                        $(".message_box").removeClass('ok');
                        $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                        return false;
                    }
					var parsed=data.split('|');
					var rating=parsed[0];
					var msg=parsed[1];
					var rnum=parsed[2];
					if(msg=='Rating Recorded') {
                        rating=parseInt(rating) -1;
                        $('.star:first').rating('select',rating);
						if (rnum>0) {
							if (rnum==1) {
								$('#rnum').html('Rated by 1 person');
							} else {
								$('#rnum').html('Rated by ' + rnum + ' people');
							}
						} else {
							$('#rnum').html('');
						}
						//add message
						$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
					} else {
						$(".message_box").removeClass('ok').html('<img class="close_message"  src="images/ok.png">' + msg);
					}
				});
				return false;//not to post the  form physically
			} 
		})(i + 1));
	});
    $(document).on('click', ".rating-cancel", function() { 
          //$(".message_box").html('Cancelling your rating...');
          //$(".message_box").show();
          $.post("includes/delrating.php",{recid:$('#id').val()} ,function(data) {
              if(data=="nodb"){
                  $(".message_box").removeClass('ok');
                  $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                  return false;
              }
              var parsed=data.split('|');                                           
              var rating=parsed[0];
              var msg=parsed[1];
              var rnum=parsed[2];
              if(msg=='Rating Cancelled') {
                  rating=parseInt(rating) -1;
                  if(rating>-1) {
                      $('.star:first').rating('select',rating);
                  }
                  if (rnum>0) {
                      if (rnum==1) {
                          $('#rnum').html('Rated by 1 person');
                      } else {
                          $('#rnum').html('Rated by ' + rnum + ' people');
                      }
                  } else {
                      $('#rnum').html('');
                  }
                  //add message
                  //$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
              } else {
                  $(".message_box").removeClass('ok').html('<img class="close_message"  src="images/ok.png">' + msg);
              }
          });
          return false;//not to post the  form physically 
    });
});
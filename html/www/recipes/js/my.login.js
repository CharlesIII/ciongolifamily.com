function  login(data,thisObj) {
    //var lastp = $('#lastpage').val();

    if(data.substring(0,6)=='active' || data.substring(0,3)=='yes') {
        var parsed= data.split('||');
        var parsed2=parsed[1].split('|');
        var welcome=parsed2[0];
        if(welcome==1) {
            welcome=true;
        } else {
            welcome=false;
        }

        var id=parsed2[1];
        $.cookie('rid',id, { path: '/' });
        var rowner=parsed2[2];
        $.cookie('rowner',rowner, { path: '/' });
        var numfmt=parsed2[3];
        $.cookie('numfmt',numfmt, { path: '/' });
        var fracdec=parsed2[4];
        $.cookie('fracdec',fracdec, { path: '/' });
        var region=parsed2[5];
        $.cookie('region',region, { path: '/' });
        var groroz=parsed2[6];
        $.cookie('groroz',groroz, { path: '/' });
        var popovers=parsed2[7];
        if(popovers==1) {
            popovers=true;
        } else {
            popovers=false;
        }
        $.cookie('popovers',popovers, { path: '/' }); 
        
        /*if (lastp && lastp != 'display') {
            document.location= lastp;
            $.removeCookie('welcome', { path: '/' });
        } else {*/
            $.cookie('welcome', welcome, { path: '/' });
            document.location="display.php";
        //}
    } else if(data.substring(0,9)=='suspended') {
        var parsed = data.split('||');
        var parsed1 = parsed[0].split('|');
        var susmsg = parsed1[1];
        var parsed2=parsed[1].split('|');
        var welcome=parsed2[0];
        $.cookie('welcome', welcome, { path: '/' });
        
        var id=parsed2[1];
        $.cookie('rid',id, { path: '/' });
        var rowner=parsed2[2];
        $.cookie('rowner',rowner, { path: '/' });
        var numfmt=parsed2[3];
        $.cookie('numfmt',numfmt, { path: '/' });
        var fracdec=parsed2[4];
        $.cookie('fracdec',fracdec, { path: '/' });
        var region=parsed2[5];
        $.cookie('region',region, { path: '/' }); 
        var groroz=parsed2[6];
        $.cookie('groroz',groroz, { path: '/' });
        var popovers=parsed2[7];
        $.cookie('popovers',popovers, { path: '/' });
        
        document.location="display.php?suspended=yes&susmsg=" + susmsg;
    } else if(data.substring(0,9)=='cancelled') {
        thisObj.html("Your account has been disabled.").addClass('messageboxerror').fadeTo(900,1);
    } else if(data.substring(0,9)=='nosub') {
        thisObj.html("Subscription required, please sign up").addClass('messageboxerror').fadeTo(900,1);
    }
}
function error(data,thisObj) {
    //add message and change the class of the box and start fading
    if (data.substring(0,4)=='nodb') {
        thisObj.html("Sorry we're having technical issues, try again soon...").addClass('messageboxerror').fadeTo(900,1);
    } else if (data.substring(0,2)=='no') {
        thisObj.html('Invalid User or Password...').addClass('messageboxerror').fadeTo(900,1);
    } else if (data.substring(0,10)=='unapproved') {
        thisObj.html("Your account hasn't been approved yet...").addClass('messageboxerror').fadeTo(900,1);
    } else if (data.substring(0,11)=='wrongdomain'){
        thisObj.html('No license for this domain...').addClass('messageboxerror').fadeTo(900,1);
    } else if (data.substring(0,8)=='inactive'){
        if($('#client').val()=='wrm') {
           thisObj.html('You must purchase a subscription before you can log in.').addClass('messageboxerror').fadeTo(900,1); 
        } else {
            thisObj.html('Your account has either not been approved yet or has been disabled.').addClass('messageboxerror').fadeTo(900,1);
        }
    } else if (data.substring(0,7)=='expired'){
        thisObj.html('Your trial has expired...').addClass('messageboxerror').fadeTo(900,1);
    } else {
        thisObj.html(data).addClass('messageboxerror').fadeTo(900,1);
    }
}
$(document).ready(function() {
    $('#password').keypress(function (e) {
          if (e.which == 13) {
            $('#login_form').submit();
          }
    });
    $('#mpassword').keypress(function (e) {
          if (e.which == 13) {
            $('#mlogin_form').submit();
          }
    });
    $(document).on('click', ".mlogin", function() {
        $('#login_form').submit();
    });
	$("#login_form").submit(function() {
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("includes/ajax_login.php",{user:$('#user').val(),password:$('#password').val()} ,function(data){
			if(data.substring(0,9)=='suspended' || data.substring(0,6)=='active' || data.substring(0,9)=='cancelled' || data.substring(0,9)=='nosub' || data.substring(0,3)=='yes') {
				$("#msgbox").fadeTo(200,0.1,function() { //start fading the messagebox
					//add message and change the class of the box and start fading
					$(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
					function(){
						 login(data,$(this));
					});
				});
			} else {
				$("#msgbox").fadeTo(200,0.1,function() {//start fading the messagebox
				    error(data,$(this));
				});
			}
	    });
	    return false;//not to post the  form physically
	});
	$("#user").attr({ value: 'User...' }).focus(function(){
        if($(this).val()=="User..."){
            $(this).val("");
        }
	}).blur(function(){
        if($(this).val()==""){
            $(this).val("User...");
		}
	});
	$('#password-clear').show();
	$('#password').hide();

	$('#password-clear').focus(function() {
	    $('#password-clear').hide();
	    $('#password').show();
	    $('#password').focus();
	});
	$('#password').blur(function() {
	    if($('#password').val() == '') {
	        $('#password-clear').show();
	        $('#password').hide();
	    }
	});
	$("#mlogin_form").submit(function() {
		//remove all the class add the messagebox classes and start fading
		$("#mmsgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("includes/ajax_login.php",{user:$('#muser').val(),password:$('#mpassword').val()} ,function(data){
			if(data.substring(0,9)=='suspended' || data.substring(0,6)=='active' || data.substring(0,9)=='cancelled' || data.substring(0,9)=='nosub' || data.substring(0,3)=='yes') {
				$("#mmsgbox").fadeTo(200,0.1,function() { //start fading the messagebox
					//add message and change the class of the box and start fading
                    $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
                    function(){
                        login(data,$(this));
					});
				});
			} else {
				$("#mmsgbox").fadeTo(200,0.1,function() {//start fading the messagebox
					error(data,$(this));
				});
			}
		});
		return false;//not to post the  form physically
	});
	$("#muser").attr({ value: 'User...' }).focus(function(){
        if($(this).val()=="User..."){
            $(this).val("");
        }
	}).blur(function(){
        if($(this).val()==""){
            $(this).val("User...");
		}
	});
	$('#mpassword-clear').show();
	$('#mpassword').hide();

	$('#mpassword-clear').focus(function() {
	    $('#mpassword-clear').hide();
	    $('#mpassword').show();
	    $('#mpassword').focus();
	});
	$('#mpassword').blur(function() {
	    if($('#mpassword').val() == '') {
	        $('#mpassword-clear').show();
	        $('#mpassword').hide();
	    }
	});
	$("#dlogin_form").submit(function() {
		//remove all the class add the messagebox classes and start fading
		$("#dmsgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("includes/ajax_login.php",{user:$('#duser').val(),password:$('#dpassword').val()} ,function(data){
			if(data.substring(0,9)=='suspended' || data.substring(0,6)=='active' || data.substring(0,9)=='cancelled' || data.substring(0,9)=='nosub' || data.substring(0,3)=='yes') {
				$("#dmsgbox").fadeTo(200,0.1,function() { //start fading the messagebox
					//add message and change the class of the box and start fading
                    $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
                    function(){
                       login(data,$(this));
					});
                });
			} else {
			        $("#dmsgbox").fadeTo(200,0.1,function() {//start fading the messagebox
						error(data,$(this));
			        });
	        }
	    });
	    return false;//not to post the  form physically
	});
});
// Popovers
$('#input-uname').popover({
        content: 'Please enter your user name or email address.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-email').popover({
        content: 'Please enter a valid email address.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-captcha').popover({
        content: 'Please enter the code below.',
        trigger: 'manual',
        placement: 'top'
});
// Validation
$("#support_form").submit(function() {
        var email=document.enq.email.value;
        var uname=document.enq.uname.value;
        var email_exp=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (email=='' && uname=='') {
                $('#contact-email').addClass('has-error');
                $('#contact-uname').addClass('has-error');
                $('#input-uname').popover('show')
                document.enq.email.focus();
                return false;
        } else {
                $('#contact-email').addClass('has-success');
                $('#contact-uname').addClass('has-success');
                $('#input-uname').popover('hide')
        } 
        if (email!='' && !email.match(email_exp)) {
                $('#contact-email').addClass('has-error');
                $('#input-email').popover('show')
                document.enq.email.focus();
                return false;
        } else {
                $('#contact-email').addClass('has-success');
                $('#input-email').popover('hide')
        }
        var captcha=document.enq.captcha.value;
        if (captcha=='') {
                $('#contact-captcha').addClass('has-warning');
                $('#input-captcha').popover('show')
                document.enq.captcha.focus();
                return false;
        } else {
                $('#contact-captcha').addClass('has-success');
                $('#input-captcha').popover('hide')
        }
        $('.success_txt').html('<strong>Resetting your password...</strong>');
        $('.success').show();
        $.post("includes/pw.php",{email:$('#input-email').val(),uname:$('#input-uname').val(),security_code:$('#input-captcha').val()} ,function(data){
	        if(data=='yes') {
                $('.success_txt').html('<strong>Your new password has been sent to your registered e-mail address.</strong>');
	            $("#support_form").trigger('reset');
	        } else {
			if (data=='novalues') {
                $('.success_txt').html('<strong>A username or email address must be entered...</strong></h3>');
			} else if (data=='nouname') {
				$('.success_txt').html("<strong>Username doesn't exist. Please enter an email address...</strong>");
			} else if (data=='noemail') {
				$('.success_txt').html("<strong>Email doesn't exist. Please enter a username...</strong>");
			} else if (data=='wrongstr') {
				$('.success_txt').html('<strong>Security code incorrect. Please try again.</strong>');
			} else if (data=='"Message failed to send"') {
                $('.success_txt').html('<strong>Unable to send your password to you. Please chcek your email address and try again.</strong>');
            } else if (data=='nodb') {
                $('.success_txt').html('<strong>Unable to connect to the database.</strong>');
            } else {
                $('.success_txt').html('<strong>' + data + '</strong>');
            }
        }
        setTimeout(function() { $(".success").fadeOut(1500); }, 3000);
	});
	return false;//not to post the  form physically
});
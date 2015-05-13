// Popovers
$('#input-name').popover({
        content: 'Please enter your name.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-email').popover({
        content: 'Please enter a valid email address.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-message').popover({
        content: 'Please enter your message.',
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
        var contactname=document.enq.name.value;
        var name_exp=/^[A-Za-z\s]+$/;
        if (contactname=='') {
                $('#contact-name').addClass('has-warning');
                $('#input-name').popover('show')
                document.enq.name.focus();
                return false;
        } else if (!contactname.match(name_exp)) {
                $('#contact-name').addClass('has-error');
                $('#input-name').popover('show')
                document.enq.name.focus();
                return false;
        } else {
                $('#contact-name').addClass('has-success');
                $('#input-name').popover('hide')
        }
        var email=document.enq.email.value;
        var email_exp=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (email=='') {
                $('#contact-email').addClass('has-warning');
                $('#input-email').popover('show')
                document.enq.email.focus();
                return false;
        } else if (!email.match(email_exp)) {
                $('#contact-email').addClass('has-error');
                $('#input-email').popover('show')
                document.enq.email.focus();
                return false;
        } else {
                $('#contact-email').addClass('has-success');
                $('#input-email').popover('hide')
        }
        var message=document.enq.message.value;
        if (message=='') {
                $('#contact-message').addClass('has-warning');
                $('#input-message').popover('show')
                document.enq.message.focus();
                return false;
        } else {
                $('#contact-message').addClass('has-success');
                $('#input-message').popover('hide')
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
        $('.success_txt').html('<strong>Sending email...</strong>');
        $('.success').show();
        $.post("includes/form.php",{name:$('#input-name').val(),email:$('#input-email').val(),message:$('#input-message').val(),security_code:$('#input-captcha').val()} ,function(data){
	        if(data=='yes') {
                $('.success_txt').html('<strong>Email sent sucessfully</strong><br>Someone will get back to you shortly.');
	            $("#support_form").trigger('reset');
	        } else {
			if (data=='noname') {
                $('.success_txt').html('<strong>A name must be entered.</strong></h3>');
			} else if (data=='noemail') {
				$('.success_txt').html('<strong>We need a valid email address to get back to you.</strong>');
			} else if (data=='nomess') {
				$('.success_txt').html('<strong>Please enter a message.</strong>');
			} else if (data=='wrongstr') {
				$('.success_txt').html('<strong>Security code incorrect. Please try again.</strong>');
			} else if (data=="Message failed to send") {
                $('.success_txt').html('<strong>' + data + '</strong>');
            } else if (data=='nodb') {
                $('.success_txt').html('<strong>Unable to connect to the database.</strong>');
            }
        }
        setTimeout(function() { $(".success").fadeOut(1500); }, 3000);
	});
	return false;//not to post the  form physically
});
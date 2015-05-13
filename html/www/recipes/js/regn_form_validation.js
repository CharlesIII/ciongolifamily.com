// Popovers
$('#input-fname').popover({
        content: 'Please enter your first name.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-uname').popover({
        content: 'Please enter a user name.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-email').popover({
        content: 'Please enter a valid email address.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-pword').popover({
        content: 'Please enter a password with at least 6 characters, and no more than 72.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-cpword').popover({
        content: 'Your passwords do not match.',
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
        var contactfname=document.enq.fname.value;
        var fname_exp=/^[A-Za-z\s]+$/;
        if (contactfname=='') {
                $('#contact-fname').addClass('has-warning');
                $('#input-fname').popover('show')
                document.enq.fname.focus();
                return false;
        } else if (!contactfname.match(fname_exp)) {
                $('#contact-fname').addClass('has-error');
                $('#input-fname').popover('show')
                document.enq.fname.focus();
                return false;
        } else {
                $('#contact-fname').addClass('has-success');
                $('#input-fname').popover('hide')
        }
        var contactuname=document.enq.uname.value;
        if (contactuname=='') {
                $('#contact-uname').addClass('has-warning');
                $('#input-uname').popover('show')
                document.enq.uname.focus();
                return false;
        } else {
                $('#contact-uname').addClass('has-success');
                $('#input-uname').popover('hide')
        }
        var pword=document.enq.pword.value;
        if (pword=='' || pword.length < 6 || pword.length > 72) {
                $('#contact-pword').addClass('has-warning');
                $('#input-pword').popover('show')
                document.enq.pword.focus();
                return false;
        } else {
                $('#contact-pword').addClass('has-success');
                $('#input-pword').popover('hide')
        }
        var cpword=document.enq.cpword.value;
        if (cpword=='' || cpword != pword) {
                $('#contact-cpword').addClass('has-warning');
                $('#input-cpword').popover('show')
                document.enq.cpword.focus();
                return false;
        } else {
                $('#contact-cpword').addClass('has-success');
                $('#input-cpword').popover('hide')
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
        $('.success_txt').html('<strong>Creating account...</strong>');
        
        $('.success').show();
        $.post("includes/register.php",{fname:$('#input-fname').val(),lname:$('#input-lname').val(),uname:$('#input-uname').val(),email:$('#input-email').val(),pword:$('#input-pword').val(),captcha:$('#input-captcha').val()} ,function(data){
	        if(data=='yes') {
                    $('.success_txt').html('<strong>Account created.</strong><br>You will be able to log in once your sign up has been approved by an administrator.');
	                $("#support_form").trigger('reset');
	        } else {
			if (data=='noname') {
                $('.success_txt').html('<strong>A first name must be entered.</strong></h3>');
			} else if (data=='noemail') {
				$('.success_txt').html('<strong>Please enter a valid email address.</strong>');
			} else if (data=='nouname') {
                $('.success_txt').html('<strong>Please enter a user name.</strong>');
            } else if (data=='nopass') {
				$('.success_txt').html('<strong>Please enter a password.</strong>');
			} else if (data=='shortpass') {
                $('.success_txt').html('<strong>Your password must be at least 6 characters.</strong>');
            } else if (data=='longpass') {
                $('.success_txt').html('<strong>Your password must be no longer than 72 characters.</strong>');
            } else if (data=='wrongstr') {
                $('.success_txt').html('<strong>Security code incorrect. Please try again.</strong>');
            } else if (data=='unameexists') {
				$('.success_txt').html('<strong>This user name is taken, please try another.</strong>');
			} else if (data=='emailexists') {
                $('.success_txt').html('<strong>This email address is already in use, please try another.</strong>');
            } else if (data=='maxusers') {
                $('.success_txt').html('<strong>The user limit for this license has been reached.<strong><br>Please contact the administrator.'); 
            } else if (data=="Message failed to send") {
                $('.success_txt').html('<strong>Your account has been created but we were unable to send the details in an email.</strong><br>Please verify your email and update it if necessary.');
            } else if (data=='nodb') {
                $('.success_txt').html('<strong>Unable to connect to the database.</strong>');
            } else  {
                $('.success_txt').html('<strong>' + data + '</strong>');
            }
        }
        setTimeout(function() { $(".success").fadeOut(1500); }, 3000);
	});
	return false;//not to post the  form physically
});
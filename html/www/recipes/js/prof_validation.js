// Popovers
$('#input-fname').popover({
        content: 'Please enter your first name.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-email').popover({
        content: 'Please enter a valid email address.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-pword').popover({
        content: 'Please enter a password with at least 6 characters.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-cpword').popover({
        content: 'Your passwords do not match.',
        trigger: 'manual',
        placement: 'top'
});
// Validation
$("#support_form").submit(function() {
        var action = $('#action').val();
        if(action=='pw') {
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
        } else {
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
        }
        if(action=='pw') {
            $('.success_txt').html('<strong>Changing your password...</strong>');
        } else {
            $('.success_txt').html('<strong>Updating your profile...</strong>');
        }
        
        $('.success').show();
        $.post("includes/updprof.php",{fname:$('#input-fname').val(),lname:$('#input-lname').val(),email:$('#input-email').val(),pword:$('#input-pword').val(),action:action},function(data){
	        if(data=='yes') {
                if(action) {
                    $('.success_txt').html('<strong>Password changed.</strong>');
                    $('#input-pword').val('').attr('placeholder','Your New Password');
                    $('#input-cpword').val('').attr('placeholder','Confirm Your New Password');
                } else {
                    $('.success_txt').html('<strong>Profile updated.</strong>');
                }
	        } else {
			if (data=='noname') {
                $('.success_txt').html('<strong>A first name must be entered.</strong></h3>');
			} else if (data=='nopass') {
				$('.success_txt').html('<strong>A password must be entered.</strong>');
			} else if (data=='noemail') {
                $('.success_txt').html('<strong>Please enter a valid email address.</strong>');
            } else if (data=='longpass') {
				$('.success_txt').html('<strong>Your password must be no longer than 72 characters.</strong>');
			} else if (data=='shortpass') {
                $('.success_txt').html('<strong>Your password must be at least 6 characters.</strong>');
            } else if (data=='emailexists') {
                $('.success_txt').html('<strong>This email address is already in use, please try another.</strong>');
            } else if (data=='nodb') {
                $('.success_txt').html('<strong>Unable to connect to the database.</strong>');
            } else  {
                $('.success_txt').html('<strong>' + data + '</strong>');
            }
        }
        setTimeout(function() { $(".success").fadeOut(1500); }, 1500);
	});
	return false;//not to post the  form physically
});
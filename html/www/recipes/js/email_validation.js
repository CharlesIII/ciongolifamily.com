// Popovers
if($('#guest').val()) {
    $('#myname').popover({
            content: 'Please enter your name.',
            trigger: 'manual',
            placement: 'top'
    });
    $('#myemail').popover({
            content: 'Please enter your email.',
            trigger: 'manual',
            placement: 'top'
    });
}
$('#input-name').popover({
        content: 'Please enter at least one name.',
        trigger: 'manual',
        placement: 'top'
});
$('#input-email').popover({
        content: 'Please enter at least one email address.',
        trigger: 'manual',
        placement: 'top'
});

// Validation
$("#support_form").submit(function() {
        $('.success_txt').html('<strong>Sending email/s...</strong>');
        if($('#guest').val()) {
           var myname=document.enq.myname.value;
            if (myname=='') {
                    $('#my-name').addClass('has-warning');
                    $('#myname').popover('show')
                    document.enq.myname.focus();
                    return false;
            } else {
                    $('#my-name').addClass('has-success');
                    $('#myname').popover('hide')
            }
            var myemail=document.enq.myemail.value;
            if (myemail=='') {
                    $('#my-email').addClass('has-warning');
                    $('#myemail').popover('show')
                    document.enq.myemail.focus();
                    return false;
            } else {
                    $('#my-email').addClass('has-success');
                    $('#myemail').popover('hide')
            } 
        }
        var contactname=document.enq.name.value;
        if (contactname=='') {
                $('#contact-name').addClass('has-warning');
                $('#input-name').popover('show')
                document.enq.name.focus();
                return false;
        } else {
                $('#contact-name').addClass('has-success');
                $('#input-name').popover('hide')
        }
        var email=document.enq.email.value;
        if (email=='') {
                $('#contact-email').addClass('has-warning');
                $('#input-email').popover('show')
                document.enq.email.focus();
                return false;
        } else {
                $('#contact-email').addClass('has-success');
                $('#input-email').popover('hide')
        }
        $('.success').show();
        $.post("includes/email_recipe.php",{recid:$('#recid').val(),name:$('#input-name').val(),email:$('#input-email').val(),message:$('#input-message').val(),myname:$('#myname').val(),myemail:$('#myemail').val()} ,function(data){
                if(data=='yes') {
			        $('.success_txt').html('<strong>Email/s sent sucessfully.</strong>');
                                $("#support_form").trigger('reset');
		        } else if(data=='nodb') {
                    $('.success_txt').html('<strong>Unable to connect to database.</strong>');
                } else {
			        $('.success_txt').html('<strong>' + data + '</strong>');
		        }       
                setTimeout(function() { $(".success").fadeOut(1500); }, 3000);
	});
	return false;//not to post the  form physically
});
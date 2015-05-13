<?php
	require_once('includes/htop.php');
?>
<title>My Web Recipe Manager - Password Reset</title>
<meta name="description" content="Reset your My Web Recipe Manager password">
</head>
<body>
<?php
	require_once('includes/hbanner.php');
?>
    <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                                <h3><strong>password </strong>reset</h3>
	                            Enter either your username or email below and your new password will be emailed to you.
	                            <br>
	                            <br>
	                            <form name=enq method="post" id="support_form" action="" class="form-horizontal top-margin" role="form">
	                                    <div class="success" style="display:none;">
                                                <div class="success_txt">
                                                        <strong>Sending email...</strong>
                                                </div>
                                        </div>
		                                <div id="contact-uname" class="form-group">
                                                    <div class="col-xs-12">
                                                            <input id="input-uname" name="uname" type="text" class="form-control" placeholder="Your User Name">
                                                    </div>
                                        </div>
			                            <div id="contact-email" class="form-group">
                                                <div class="col-xs-12">
                                                        <input id="input-email" name="email" class="form-control" placeholder="Your Email">
                                                </div>
                                        </div>
                                        <div id="contact-captcha" class="form-group">
                                                    <div class="col-xs-12">
                                                            <input id="input-captcha" name="captcha" class="form-control" placeholder="Enter the code below:">
                                                            <br>
                                                            <img src="includes/captcha_code_file.php?rand=<?php echo rand(); ?>" id="captchaimg">
                                                            <br>
                                                    </div>
                                        </div>
		                                <div class="form-group">
                                                <div class="col-xs-12">
                                                        <button id=submit name="submit" type="submit" class="btn btn-default">Submit</button>
                                                </div>
                                        </div>
		                            
	                            </form>
                                <br>
                                </div>

<?php require_once('includes/hbottom.php');?>

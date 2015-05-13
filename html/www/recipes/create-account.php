<?php
	require_once('includes/htop.php');
?>
<title>My Web Recipe Manager - Create An Account</title>
<meta name="description" content="Create a My Web Recipe Manager Account" />
</head>
<body>
<?php require_once('includes/hbanner.php'); ?>

<div id="sb-site" class="sb-slide">
                <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-9">
                                <h3>Create <strong>An Account</strong></h3>
	                            <form name=enq method="post" id="support_form" action="" class="form-horizontal top-margin" role="form">
			                            <div>
                                            <div class="success" style="display:none;">
                                                        <div class="success_txt">
                                                                <strong>Creating your account...</strong>
                                                        </div>
                                            </div>
				                            <div id="contact-fname" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-fname" name="fname" type="text" class="form-control" placeholder="Your First Name">
                                                        </div>
                                            </div>
				                            <div id="contact-lname" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-lname" name="lname" type="text" class="form-control" placeholder="Your Last Name">
                                                        </div>
                                                </div>
				                            <div id="contact-uname" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-uname" name="uname" type="text" class="form-control" placeholder="Your User Name">
                                                        </div>
                                            </div>
				                            <div id="contact-pword" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-pword" name="pword" type="password" class="form-control" placeholder="Your Password">
                                                        </div>
                                            </div>
				                            <div id="contact-cpword" class="form-group">
                                                        <div class="col-xs-12">
                                                                <input id="input-cpword" name="cpword" type="password" class="form-control" placeholder="Confirm Your Password">
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
                                                                <button id=submit name="submit" type="submit" class="btn btn-default">Create Account</button>
                                                        </div>
                                            </div>
			                            </div>
			                            <strong> Note: Cookies and javascript must be enabled in your browser.</strong>
			                            <br><br>
					                            
                                </form>
                            </div>
	
<?php require_once('includes/hbottom.php'); ?>
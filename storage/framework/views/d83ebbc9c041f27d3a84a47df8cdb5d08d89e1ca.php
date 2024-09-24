<!DOCTYPE html>
<html>
<head>
	<title>Forget Password Email</title>
</head>
<body>
	 <div style="border: 1px solid #ddd;margin: auto;width: 70%;padding: 20px;line-height: 1.2;">
		 	Dear Partner, <br>
			 You can reset password from bellow link: <span style="color: #16589b;font-size: 1.25em;"><a href="<?php echo e(route('reset.password.tc.get', $token)); ?>">Reset Password</a></span><br><br>

		Warm regards,<br> 
		BPC Partner by Thomas Cook 
	</div>
	
</body>
</html><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/email/forgotpasstcuser.blade.php ENDPATH**/ ?>
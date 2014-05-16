<html>
<body>
	<h1><?php echo sprintf("Reset Password for %s", $identity);?></h1>
	<p><?php echo sprintf("Please click this link to %s.", anchor('auth/reset_password/'. $forgotten_password_code, "reset your password"));?></p>
</body>
</html>
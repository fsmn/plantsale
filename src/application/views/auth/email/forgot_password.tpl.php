<html>
<body>
	<h1><?php print sprintf('Reset Password for %', $identity); ?></h1>
	<p><?php print sprintf('Please click this link to %s.', anchor('auth/reset_password/' . $forgotten_password_code, 'reset your password')); ?></p>
</body>
</html>
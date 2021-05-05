<html>
<body>
	<h1><?php print format_string('Reset Password for @identity', ['@identity' => $identity]); ?></h1>
	<p><?php print format_string('Please click this link to @url.', ['@url' => anchor('auth/reset_password/' . $forgotten_password_code, 'reset your password')]); ?></p>
</body>
</html>
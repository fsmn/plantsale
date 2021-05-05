<html>
<body>
	<h1><?php print format_string('Activate account for @identity', ['@identity' => $identity]); ?></h1>
	<p><?php print format_string('Please click this link to @url.', ['@url' => anchor('auth/activate/' . $id . '/' . $activation, 'activate')]); ?>
	</p>
</body>
</html>
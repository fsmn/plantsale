<html>
<body>
	<h1><?php print sprintf('Activate account for %s', $identity); ?></h1>
	<p><?php print sprintf('Please click this link to %s.', anchor('auth/activate/' . $id . '/' . $activation, 'activate')); ?>
	</p>
</body>
</html>
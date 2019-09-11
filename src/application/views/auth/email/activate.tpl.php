<html>
<body>
	<h1><?php echo sprintf("Activate account for %s", $identity);?></h1>
	<p><?php echo sprintf("Please click this link to %s.", anchor('auth/activate/'. $id .'/'. $activation, "activate"));?></p>
</body>
</html>
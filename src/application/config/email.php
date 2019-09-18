<?php

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'TLS';

if ($_SERVER['HTTP_HOST'] == 'docker.test') {
	$config['smtp_user'] = getenv('SMTP_USER');
	$config['smtp_pass'] = getenv('SMTP_PASS');
}
else {
	$config['smtp_user'] = '{{ FSMN_SMTP_USER }}';
	$config['smtp_pass'] = '{{ FSMN_SMTP_PASS }}';
}

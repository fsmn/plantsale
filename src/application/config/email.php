<?php

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'TLS';

switch($_SERVER['HTTP_HOST']){
	case 'docker.test':
		$config['smtp_user'] = getenv('SMTP_USER');
		$config['smtp_pass'] = getenv('SMTP_PASS');
		break;
	case 'backoffice.t7test.io':
		$config['smtp_user'] = '{{ TEST_FSMN_SMTP_USER }}';
		$config['smtp_pass'] = '{{ TEST_FSMN_SMTP_USER }}';
		break;
	case 'backoffice.t7stage.io':
		$config['smtp_user'] = '{{ STAGE_FSMN_SMTP_USER }}';
		$config['smtp_pass'] = '{{ STAGE_FSMN_SMTP_USER }}';
		break;
	case 'backoffice.t7live.io':
	case 'db.friendsschoolplantsale.com':
		$config['smtp_user'] = '{{ LIVE_FSMN_SMTP_USER }}';
		$config['smtp_pass'] = '{{ LIVE_FSMN_SMTP_USER }}';
		break;
}

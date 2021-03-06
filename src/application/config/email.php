<?php

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'TLS';

switch($_SERVER['HTTP_HOST']){
	case 'docker.test':
	case 'backoffice.test':
		$config['smtp_user'] = getenv('SMTP_USER');
		$config['smtp_pass'] = getenv('SMTP_PASS');
		break;
	default:
		$config['smtp_user'] = '{{ backoffice_smtp_user }}';
		$config['smtp_pass'] = '{{ backoffice_smtp_pass }}';
		break;
}

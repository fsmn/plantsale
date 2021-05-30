<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$i = 1;
foreach ( $plants as $plant ) {
	if ($i % 2 == 0 && $i != 1) {
		$plant ['row_class'] [] = 'even';
	} else {
		$plant ['row_class'] [] = 'odd';
	}
	if ($i == 1) {
		$plant ['row_class'] [] = 'first';
	}
	
	if ($format == 'seed_packet' && $i % 2 == 1) {
		print '<div class="packet-row">';
	}
	$this->load->view ( 'variety/print/' . $format, $plant );
	if ($format == 'seed_packet' && $i % 2 == 0) {
		print '</div>';
	}
	$i ++;
}

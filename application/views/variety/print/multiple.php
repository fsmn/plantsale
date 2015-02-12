<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
foreach ( $plants as $plant ) {
	//if ($plant ["order"]->omit != 1) {
		$this->load->view ( "variety/print/$format", $plant );
	//}
}
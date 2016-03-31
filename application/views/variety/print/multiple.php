<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$i = 1;
foreach ( $plants as $plant ) {
if($i %2 == 0 && $i!=1){
    $plant['row_class'][] = "even";
}else{
     $plant['row_class'][] = "odd";
}
if($i == 1){
	$plant['row_class'][] = "first";
}
		$this->load->view ( "variety/print/$format", $plant );
$i++;
}
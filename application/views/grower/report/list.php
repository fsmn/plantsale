<?php defined('BASEPATH') OR exit('No direct script access allowed');

// report.php Chris Dart Jan 8, 2015 2:58:21 PM chrisdart@cerebratorium.com
?>
<table class="list">
<thead>
</thead>
<tbody>
<? foreach($growers as $grower){
    $this->load->view("grower/report/row",array("grower"=>$grower[0]));
} ?>
</tbody>
</table>
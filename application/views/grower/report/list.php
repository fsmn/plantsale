<?php defined('BASEPATH') OR exit('No direct script access allowed');

// report.php Chris Dart Jan 8, 2015 2:58:21 PM chrisdart@cerebratorium.com
?>
<table class="list">
<thead>
<tr>
<th>
ID
</th>
<th>
Name
</th>
<th>
Street
</th>
<th>
City, State, Zip
</th>
<th>
Totals for <?=$year;?>
</th>
<th>
</th>
</tr>
</thead>
<tbody>
<? foreach($growers as $grower){
    if($grower[0]){
    $this->load->view("grower/report/row",array("grower"=>$grower[0]));
    }
} ?>
</tbody>
</table>
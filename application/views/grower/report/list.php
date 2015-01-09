<?php defined('BASEPATH') OR exit('No direct script access allowed');

// report.php Chris Dart Jan 8, 2015 2:58:21 PM chrisdart@cerebratorium.com
$grand_total = 0;
?>
<div class="button-box">
<a href="<?=$_SERVER['REQUEST_URI']. "?export=true";?>" class="button " title="Export">Export List</a>
</div>
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
<th class="no-print">
</th>
</tr>
</thead>
<tbody>
<? foreach($growers as $grower){
    if($grower[0]){
    $this->load->view("grower/report/row",array("grower"=>$grower[0]));
    $grand_total += $grower[0]->total;
    }
} ?>
</tbody>
<tfoot>
<tr >
<th colspan="5" style="text-align: right;">
<?=get_as_price($grand_total);?>
</th>
<th>
</th>
</tr>
</tfoot>
</table>
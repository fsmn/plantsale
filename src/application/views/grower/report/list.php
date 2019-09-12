<?php defined('BASEPATH') OR exit('No direct script access allowed');

// report.php Chris Dart Jan 8, 2015 2:58:21 PM chrisdart@cerebratorium.com
//$grand_total = 0;
?>
<h1>Grower Totals, <?php echo $year; ?></h1>
<?php $buttons[] = array("text"=>"Export","class"=>array("button","export"),"style"=>"export","title"=>"Export as Spreadsheet","href"=>$_SERVER['REQUEST_URI']. "?export=true");?>
<?php if($orphan_count > 0){
    $verb = $orphan_count == 1?"is":"are";
    $plural = $orphan_count > 1?"s":"";
$buttons[] = array("text"=>"Show $orphan_count Orphan Grower$plural <span class='badge'>$orphan_count</span>","title"=>"There $verb $orphan_count grower$plural with no grower record. Click here to fix this.","class"=>array("button"),"style"=>"default","href"=>site_url("grower/show_orphans"));
}

print create_button_bar($buttons);
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
Email/Phone
</th>
<th>
Address
</th>
<th>
Our Contact
</th>
<th>
Totals for <?php echo $year;?>
</th>
<th class="no-print">
</th>
</tr>
</thead>
<tbody>
<?php
print implode("\r",$growers);?>
</tbody>
<tfoot>
<tr >
<th colspan="5" style="text-align: right;">
<?php echo get_as_price($grand_total);?>
</th>
<th>
</th>
</tr>
</tfoot>
</table>
<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$this->load->view("variety/list/header");
?>


<? foreach($plants as $plant):?>
<div id="variety-row_<?=$plant->id;?>" style="padding-top:2em;">

<div id="variety-info">
		<h4><span><a
			href="<?=site_url(sprintf("common/find?genus=%s",$plant->genus));?>"
			title="View all <?=$plant->genus;?>"><?=$plant->genus;?></a></span>&nbsp;
		<span><?=$plant->species;?></span>&nbsp;
		<span><a href="<?=site_url("common/view/$plant->common_id");?>"
			title="View the details for <?=$plant->name;?>"><?=$plant->name;?></a></span>&nbsp;
		<span><a href="<?=site_url("variety/view/$plant->id");?>"
			title="View the details for <?=$plant->variety;?>"><?=$plant->variety;?></a></span>
			</h4>
	</div>
<div id="variety-orders" style="max-width: 900px;">
<? $data["orders"] = $plant->orders;
$this->load->view("order/list",$data);
endforeach; ?>
</div>
</div>


<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
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
<table class="list compressed">
<thead>
<tr>
<th>Year</th>
<th>Grower</th>
<th>Cat#</th>
<th>Pre</th>
<th>Mid</th>
<th>Tot</th>
<th>Pot Size</th>
<th>Flat Size</th>
<th>Flat Cost</th>
<th>Plant Cost</th>
<th>Price</th>
<th>Dead</th>
<th>Friday Sellout</th>
<th>Saturday Sellout</th>
<th>Fri Rem</th>
<th>Sat Rem</th>
<th>Sun Rem</th>
<th>Grower Code</th>
</tr>
</thead>
<tbody>
<? foreach($plant->orders as $order):?>

<? $this->load->view("order/row",array("order"=>$order));?>
<? endforeach; ?>
</tbody>
</table>
</div>
</div>

<? endforeach;
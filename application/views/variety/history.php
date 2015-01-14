<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>

<fieldset class="search-fieldset">
	<legend  title="click to show or hide the parameters">Search Parameters</legend>
	<div class="search-parameters">
	<? if (isset ( $options )) : ?>

		<? $keys = array_keys ( $options ); ?>
		<? $values = array_values ( $options ); ?>

		<ul>

		<? for($i = 0; $i < count ( $options ); $i ++):?>
       	<li>
       	<? if(is_array($values[$i])){
       		$values[$i] = implode(",",$values[$i]);
       	}?>
       	<?=ucwords(clean_string($keys [$i])); ?>:&nbsp;<strong><?=ucwords(clean_string($values [$i])); ?></strong>
		</li>
		<? endfor;?>
		</ul>
	<?  else : ?>
		<p>Showing All Varieties</p>
	<? endif; ?>
<p>
		<strong>Sort Order</strong>
	</p>
<? $sorting = $this->input->get("sorting"); ?>
<? $direction = $this->input->get("direction");?>
<ul>
<? for($i = 0; $i < count($sorting); $i++):?>
<li><? printf("%s, %s", ucwords($sorting[$i]), $direction[$i]); ?></li>
<? endfor; ?>
</ul>
<p>
Found Count: <strong><?=count($plants);?> Varieties</strong>
</p>
	<div class="button-box">
		<span class="button search-varieties">Refine Search</span>
	</div>
	</div>
</fieldset>
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
endforeach;


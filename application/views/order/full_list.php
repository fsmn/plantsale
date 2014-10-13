<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// n envelope for the plant list.

?>

<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class="search-parameters">
	<? if (isset ( $options )) : ?>

		<? $keys = array_keys ( $options ); ?>
		<? $values = array_values ( $options ); ?>

		<ul>

		<? for($i = 0; $i < count ( $options ); $i ++):?>
       	<li>
       	<?=ucwords(clean_string($keys [$i])); ?>:&nbsp;<strong><?=clean_string($values [$i]); ?></strong>
		</li>
		<? endfor;?>
		</ul>
	<?  else : ?>
		<p>Showing All Orders for $sale_year</p>
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
Found Count: <strong><?=count($orders);?> Orders</strong>
</p>
	<div class="button-box">
		<span class="button search-orders">Refine Search</span>
		<a href="<?=$_SERVER['REQUEST_URI']. "&export=true";?>" class="button" title="Export">Export List</a>
	</div>
	</div>
</fieldset>
<? if($is_inventory){
    $this->load->view("order/inventory");
}else{
    $this->load->view("order/name_list");
} ?>


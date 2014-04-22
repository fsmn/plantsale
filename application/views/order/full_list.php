<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// n envelope for the plant list.

?>

<fieldset class="search_fieldset">
	<legend>Search Parameters</legend>
	<? if (isset ( $options )) : ?>
		
		<? $keys = array_keys ( $options ); ?>
		<? $values = array_values ( $options ); ?>
		
		<ul>
		
		<? for($i = 0; $i < count ( $options ); $i ++):?>
       	<li>
       	<?=ucfirst($keys [$i]); ?>:&nbsp;<strong><?=$values [$i]; ?></strong>
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
<li><? printf("%s, %s", $sorting[$i], $direction[$i]); ?></li>
<? endfor; ?>
</ul>

	<div class="button-box">
		<span class="button search-orders">Refine Search</span>
	</div>
</fieldset>

<? $this->load->view("order/list");
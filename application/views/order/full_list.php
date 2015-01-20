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
<li><? printf("%s, %s", clean_string(ucwords($sorting[$i])), $direction[$i]); ?></li>
<? endfor; ?>
</ul>
<p>
Found Count: <strong><?=count($orders);?> Orders</strong>
</p>
	<div class="button-box">
		<span class="button search-orders refine">Refine Search</span>

	</div>
	</div>
</fieldset>

<? $buttons[] = array("text"=>"Full Export","title"=>"Export all the fields using the current sort","class"=>array("button","array"), "href"=>$_SERVER['REQUEST_URI']. "&export=true" );
$buttons[] = array("text"=>"Grower Export","title"=>"Export grower fields using a special grower export","class"=>array("button","array"), "href"=>$_SERVER['REQUEST_URI']. "&export=true&export_type=grower" );
print create_button_bar($buttons);
?>


<? if($is_inventory){
    $this->load->view("order/inventory");
}else{
    $this->load->view("order/catalog");
} ?>


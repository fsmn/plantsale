<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// n envelope for the plant list.

?>
<!-- order/full_list -->
<?php if(!strstr($output_format,"printable")):?>
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
<?php echo create_button_bar(array(array("text"=>"Refine Search","class"=>array("button","refine","search-orders"))));?>
	
	</div>
</fieldset>

<? $buttons[] = array("text"=>"Full Export","title"=>"Export all the fields using the current sort","class"=>array("button","export"), "href"=>$_SERVER['REQUEST_URI']. "&export=true" );
$buttons[] = array("text"=>"Grower Export","title"=>"Export grower fields using a special grower export","class"=>array("button","export"), "href"=>$_SERVER['REQUEST_URI']. "&export=true&export_type=grower" );
if(IS_ADMIN){
$buttons[] = array("text"=>"Batch Update","title"=>"Batch Update values for all the listed orders.","class"=>array("button","batch-update-orders","edit"));
}
print create_button_bar($buttons);
?>
<?php endif;?>

<? if($output_format == "inventory"){
    $this->load->view("order/inventory");
}elseif($output_format == "printable-sellouts"){
	$this->load->view("order/sellouts");
}elseif($output_format == "printable-tracking"){
	$this->load->view("order/tracking");
}elseif($output_format == "printable-shelfchecking"){
	$this->load->view("order/shelfchecking");
}else{
    $this->load->view("order/catalog");
} ?>


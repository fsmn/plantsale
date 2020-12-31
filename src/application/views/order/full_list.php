<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// n envelope for the plant list.

?>
<!-- order/full_list -->
<?php if(!strstr($output_format,"printable")):?>
<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class="search-parameters">
	<?php if (isset ( $options )) : ?>

		<?php $keys = array_keys ( $options ); ?>
		<?php $values = array_values ( $options ); ?>

		<ul>

		<?php for($i = 0; $i < count ( $options ); $i ++):?>
       	<li>
       	<?php echo ucwords(clean_string($keys [$i])); ?>:&nbsp;<strong><?php echo clean_string($values [$i]); ?></strong>
			</li>
		<?php endfor;?>
		</ul>
	<?php else : ?>
		<p>Showing All Orders for $sale_year</p>
	<?php endif; ?>
<p>
			<strong>Sort Order</strong>
		</p>
<?php $sorting = $this->input->get("sorting"); ?>
<?php $direction = $this->input->get("direction");?>
<ul>
<?php for($i = 0; $i < count($sorting); $i++):?>
<li><?php printf("%s, %s", clean_string(ucwords($sorting[$i])), $direction[$i]); ?></li>
<?php endfor; ?>
</ul>
		<p>
			Found Count: <strong><?php echo count($orders);?> Orders</strong>
		</p>
<?php echo create_button_bar(array(array("text"=>"Refine Search","class"=>array("button","refine","search","dialog","search-orders"),"href"=>site_url("order/search"))));?>
	
	</div>
</fieldset>

<?php
	if ($output_format != "crop-failure") {
		$buttons [] = array (
				"text" => "Full Export",
				"title" => "Export all the fields using the current sort",
				"class" => array (
						"button",
						"export" 
				),
				"style" => "export",
				"href" => $_SERVER ['REQUEST_URI'] . "&export=true" 
		);
		$buttons [] = array (
				"text" => "Grower Export",
				"title" => "Export grower fields using a special grower export",
				"class" => array (
						"button",
						"export" 
				),
				"style" => "export",
				"href" => $_SERVER ['REQUEST_URI'] . "&export=true&export_type=grower" 
		);
		if (IS_ADMIN) {
			$buttons [] = array (
					"text" => "Batch Update",
					"title" => "Batch Update values for all the listed orders.",
					"class" => array (
							"button",
							"batch-update-orders",
							"edit" 
					),
					"style" => "edit" 
			);
		}
		print create_button_bar ( $buttons );
	}
	?>
<?php endif;?>

<?php

if ($output_format == 'inventory') {
	if($year == 2021){
		$this->load->view('order/inventory_2021');
	}else {
		$this->load->view('order/inventory');
	}
} elseif ($output_format == 'crop-failure') {
	$this->load->view ( 'order/crop_failures' );
} elseif ($output_format == 'printable-sellouts') {
	$this->load->view ( 'order/sellouts' );
} elseif ($output_format == 'printable-tracking') {
	$this->load->view ( 'order/tracking' );
} elseif ($output_format == 'printable-shelfchecking') {
	$this->load->view ( 'order/shelfchecking' );
} elseif ($output_format == 'profitability') {
	$this->load->view ( 'order/profitability' );
} else {
	$this->load->view ( 'order/catalog' );
}
?>


<?php defined('BASEPATH') OR exit('No direct script access allowed');

#an envelope for the plant list. 

?>

<fieldset class="search_fieldset">
	<legend>Search Parameters</legend>
	<?
	if(isset($options)){

		$keys = array_keys($options);
		$values = array_values($options);

		echo "<ul>";

		for($i = 0; $i < count($options); $i++){
			$key = $keys[$i];
			$value = $values[$i];
			echo sprintf("<li>%s:&nbsp;<strong>%s</strong></li>",ucfirst($key),$value);
				
		}
		echo "</ul>";

	}else{
		echo "<p>Showing All Orders for $sale_year</p>";
	}
	
	if(isset($sorting)): ?>
<p><strong>Sort Order</strong></p>
<?php $sorting = $this->input->get("sorting"); ?>
<ul>
<?php foreach($sorting as $sort):?>
<li><?php echo $sort; ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
	

	<div class="button-box">
		<span class="button search-orders">Refine Search</span>
	</div>
</fieldset>

<?php $this->load->view("order/list"); ?>
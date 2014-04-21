<?php defined('BASEPATH') OR exit('No direct script access allowed');

#an envelope for the plant list. 

?>

<fieldset class="search-fieldset">
	<legend>Search Parameters</legend>
	<?
	if(isset($options)){

		$keys = array_keys($options);
		$values = array_values($options);

		echo "<ul>";

		for($i = 0; $i < count($options); $i++){
			$key = $keys[$i];
			$value = $values[$i];
			echo sprintf("<li>%s <strong>%s</strong></li>",ucfirst($key),$value);
				
		}
		echo "</ul>";

	}else{
		echo "<p>Showing All Orders for $sale_year</p>";
	}
	?>

	<div class="button-box">
		<a class="button search-orders">Refine Search</a>
	</div>
</fieldset>

<?php $this->load->view("order/list"); ?>
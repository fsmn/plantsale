<?php
?>
<div class="container-fluid ">
	<form id="catalog-id-search" class="form-inline" name="catalog-id-search" action="<?php echo site_url("inventory/search");?>" method="get">
		<div class="form-group">
			<label for="catalog_number">Enter Catalog Number</label>
			<input type="text" class="form-control" name="catalog_number" id="catalog-number" value="<?php echo $catalog_number; ?>"  />
		</div>
		<div class="form-group">
<div class="field-wrapper col-sm-5 col-md-2">

			<input type="submit" value="Search" class="btn btn-success btn-lg search" />
</div>
		</div>
	</form>
	<div id="catalog_number_error"></div>
</div>
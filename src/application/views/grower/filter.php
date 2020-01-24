<?php
?>
<form name="grower-filter" action="<?php print base_url('grower/totals/');?>" method="get">
	<div class="field-set label-break"><label for="year">Enter the year you want to view grower totals for</label>
	<input type="number" name="year" value="<?php print get_current_year();?>"/></div>
	<input type="submit" value="Filter" class="button btn btn-default"/>
</form>

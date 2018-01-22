<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>

<form id="batch-update" name="batch-update" method="post" action="<?php echo base_url("variety/batch_update_flags");?>">
<input type="hidden" id="ids" name="ids" value="<?php echo implode(",",$ids);?>"/>
<input type="hidden" id="action" name="action" value="update"/>
<input type="hidden" id="target" name="target" value="<?php echo $target; ?>"/>
<h2>DANGER: Updating <?php echo count($ids);?> Records</h2>
<p class="notice">Changes you submit here cannot be undone!</p>
<p>
	<label for="flag">
	<?php echo form_dropdown("flag",$flags); ?>
	</label>
	</p>
	<p>
	<input type="submit" class="button" class="button warning"/>
	</p>
</form>

<script type="text/javascript">
$("#batch-update").submit(function(){
	is_sure = confirm("Are you absolutely sure you want to do this? It cannot be undone!");
	if(is_sure){
	}else{
	return false;
	}
});
</script>
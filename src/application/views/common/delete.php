<?php
if(empty($varieties)):
?>
<form id="common-delete" name="common-delete" method="post" action="<?php print base_url('common/delete');?>">
	<input type="hidden" name="id" value="<?php print $common->id;?>"/>
	<h3>Are you sure you want to delete <?php print $common->name;?></h3>
	<p>This common has no related varieties, so deleting this should not cause problems.</p>
	<input type="submit" value="Delete" class="button delete">
</form>
<?php else: ?>
<h3>Cannot delete <?php print $common->name . ' ' . $common->genus; ?></h3>
<p> This common has <?php  print count($varieties);?> varieties associated with it.
	You cannot delete it unless you either reassign the varieties to a different common or delete it. </p>
<a href="<?php print base_url('common/view/'. $common->id);?>">Return to this common's page.</a>
<?php endif;

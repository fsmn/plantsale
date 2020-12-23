<?php
if(!empty($ids)):
?>

<form name="batch_update" id="batch-update" method="post"
	  action="<?php print base_url('variety/batch_update'); ?>">
	<input type="hidden" id="ids" name="ids"
		   value="<?php print implode(',', $ids); ?>"/>
	<input type="hidden" id="action" name="action" value="update"/>
	<h2>DANGER: Updating <?php echo count($ids); ?> Records</h2>
	<p class="notice">Changes you submit here cannot be undone!</p>
	<p>
		<?php print form_dropdown('online_only', [
				'yes' => 'Set to online only',
				'no' => 'Set to available at the sale',
		]); ?>
	</p>
	<p>
		<input type="submit" class="button"/>
	</p>

</form>

<script type="text/javascript">
	$("#batch-update").submit(function () {
		let is_sure = confirm("Are you absolutely sure you want to do this? It cannot be undone!");
		if (is_sure) {
		} else {
			return false;
		}
	});
</script>
<?php else: ?>
<p>I didn't get a list of ids. Something must have gone wrong.</p>
<?php endif;

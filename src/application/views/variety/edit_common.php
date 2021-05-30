<?php defined('BASEPATH') or exit('No direct script access allowed');

// edit_common.php Chris Dart Dec 1, 2014 5:14:01 PM chrisdart@cerebratorium.com

//edit the common id for the variety

?>

<form name="edit-common-id" id="edit-common-id" method="post"
	  action="<?php print site_url('variety/edit_common_id'); ?>"
	  style="width: 36ex;">
	<div class="alert">Be very careful making changes. This cannot be undone!</div>
	<input type="hidden" name="id" id="id" value="<?php print $variety->id; ?>"/>
	<input type="hidden" name="original_id" id="original_id" value="<?php print $variety->common_id; ?>"/>
	<p>
		<input type="number" name="common_id" id="common_id" style="width:15ex"
			   value="<?php print $variety->common_id; ?>"/>&nbsp;
		<?php print create_button([
				'text' => 'Check',
				'class' => [
						'button',
						'small',
				],
				'id' => 'change-button',
		]); ?>
	</p>
	<div id="common-name"><?php print $variety->common_name; ?></div>
	<p>
		<input type="submit" name="submit" id="submit" value="Change" class="button edit" style="display:none;"/>
		<?php print create_button([
				'text' => 'Revert',
				'class' => [
						'button',
						'hidden'
				],
				'id' => 'revert'
		]); ?>
	</p>
</form>











<?php defined('BASEPATH') OR exit('No direct script access allowed');

// edit_common.php Chris Dart Dec 1, 2014 5:14:01 PM chrisdart@cerebratorium.com

//edit the common id for the variety

?>

<form name="edit-common-id" id="edit-common-id" method="post" action="<?=site_url("variety/edit_common_id");?>" style="width: 36ex;">
<div class="alert">Be very careful making changes. This cannot be undone!</div>
<input type="hidden" name="id" id="id" value="<?=$variety->id;?>"/>
<input type="hidden" name="original_id" id="original_id" value="<?=$variety->common_id;?>"/>
<p>
<input type="number" name="common_id" id="common_id" style="width:15ex" value="<?=$variety->common_id;?>"/>&nbsp;
<span class="button small" id="change-button" style="display: none;">Check</span>
</p>
<div id="common-name"><?=$variety->common_name;?></div>
<p>
<input type="submit" name="submit" id="submit" value="Change" class="button edit" style="display:none;"/>
<span id="revert" class="button" style="display: none;">Revert</span>
</p>
</form>
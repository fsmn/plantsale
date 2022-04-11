<?php if(empty($wrapper))	$wrapper = 'div'; ?>
<<?php print $wrapper; ?>>
<label for="<?php print $name;?>"><?php print ucwords(str_replace('_', ' ', $name)); ?>: </label>
<span name="<?php print $name;?>"><?php print $value; ?></span>
</<?php print $wrapper; ?>>

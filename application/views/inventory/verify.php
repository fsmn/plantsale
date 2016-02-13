<?php

?>
<h4>
<?php printf("Is %s: %s %s (%s) Correct?",$item->catalog_number, $item->name,$item->variety, format_latin_name($item));?></h4>

<img class="small" src="<?php echo base_url($item->image_path);?>"/>
<p>
<span style="display: inline-block">
<a href="<?php echo site_url("inventory/verify/$item->catalog_number");?>" class="btn btn-success btn-lg" style="padding-left: 3em;padding-right:3em;">Yes</a>
</span>
&nbsp;
<span style="display: inline-block; float: right;">
<a href="<?php echo site_url("inventory/index");?>" class="btn btn-danger btn-lg" style="padding-left:3em;padding-right:3em;">No</a>
</span>
</p>
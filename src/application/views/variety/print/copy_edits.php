<?php defined('BASEPATH') OR exit('No direct script access allowed');

// copy_edits.php Chris Dart Feb 10, 2015 1:48:29 PM chrisdart@cerebratorium.com

?>
<h2>Copy Edits for <?php print $year;?></h2>
<?php 
foreach($plants as $variety):
?>
<div class="variety-info">
<h3><?php print $variety->name;?> (ID=<?php print $variety->common_id;?>), <?php print $variety->variety;?> (ID=<?php print $variety->id;?>)</h3>
<p>
<strong>Common (General) Description</strong><br/>
<?php print $variety->description;?></p>
<?php if($variety->print_description):?>
<p>
<strong>Variety Descriptionn</strong><br/>
<?php print $variety->print_description;?>
</p>
<?php endif; ?>

<?php if($variety->web_description):?>
<p>
<strong>Variety Web Descriptionn</strong><br/>
<?php print $variety->web_description;?>
</p>
<?php endif; ?>
</div>
<?php endforeach;

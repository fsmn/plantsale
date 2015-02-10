<?php defined('BASEPATH') OR exit('No direct script access allowed');

// paper_waste.php Chris Dart Feb 10, 2015 1:48:29 PM chrisdart@cerebratorium.com


foreach($varieties as $variety):
?>
<div class="variety-info">
<h3><?=$variety->name;?> (ID=<?=$variety->common_id;?>), <?=$variety->variety;?> (ID=<?=$variety->id;?>)</h4>
<p>
<strong>Common (General) Description</strong><br/>
<?=$variety->description;?></p>
<? if($variety->print_description):?>
<p>
<strong>Variety Print Descriptionn</strong><br/>
<?=$variety->print_description;?>
</p>
<? endif; ?>

<? if($variety->web_description):?>
<p>
<strong>Variety Web Descriptionn</strong><br/>
<?=$variety->web_description;?>
</p>
<? endif; ?>
</div>
<? endforeach;

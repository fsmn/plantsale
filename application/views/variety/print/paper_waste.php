<?php defined('BASEPATH') OR exit('No direct script access allowed');

// paper_waste.php Chris Dart Feb 10, 2015 1:48:29 PM chrisdart@cerebratorium.com

?>
<h2>Copy Edits for <?php echo $year;?></h2>
<?php 
foreach($plants as $variety):
?>
<div class="variety-info">
<h3><?php echo $variety->name;?> (ID=<?php echo $variety->common_id;?>), <?php echo $variety->variety;?> (ID=<?php echo $variety->id;?>)</h3>
<p>
<strong>Common (General) Description</strong><br/>
<?php echo $variety->description;?></p>
<?php if($variety->print_description):?>
<p>
<strong>Variety Descriptionn</strong><br/>
<?php echo $variety->print_description;?>
</p>
<?php endif; ?>

<?php if($variety->web_description):?>
<p>
<strong>Variety Web Descriptionn</strong><br/>
<?php echo $variety->web_description;?>
</p>
<?php endif; ?>
</div>
<?php endforeach;

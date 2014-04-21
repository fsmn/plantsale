<?php defined('BASEPATH') OR exit('No direct script access allowed');

// totals.php Chris Dart Apr 21, 2014 2:06:25 PM chrisdart@cerebratorium.com
?>
<table class="chart">

<? foreach($categories["current"] as $category) : ?>
	<tr>
	<td>
	<a href="<?=site_url("order/category_totals?category=$category->category");?>"><?=$category->category;?></a>
	</td>
	<td>
	<?=$category->count;?>

	</td>
	<td>
	<? //it's clumsy, but it works ?>
	<?foreach($categories["previous"] as $old_category): ?>
		<? if($old_category->category == $category->category):?>
			<?=$old_category->count;?>
		<? endif;?>
	<? endforeach;?>
	</td>
	</tr>
<?endforeach; ?>

</table>
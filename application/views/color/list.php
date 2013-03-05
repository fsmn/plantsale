<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Mar 5, 2013 10:57:17 AM chrisdart@cerebratorium.com
?>
<table id="color-list" class="list">
	<thead>
		<tr>
			<th>Species</th>
			<th>Color</th>
			<th>Height</th>
			<th>Width</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($colors as $color): ?>
		<tr id="color-row_<?=$color->id;?>" class="color-row">
			<td><?=$color->species;?></td>
			<td class="color-color edit"><?=$color->color;?></td>
			<?
			$height = "";
			if($color->min_height){
				$height = $color->min_height;
				if($color->min_height != $color->max_height && $color->max_height) {
					$height = sprintf("%s-%s", $color->min_height, $color->max_height);
				}
				if($color->height_unit){
					$height .= sprintf(" %s", $color->height_unit);
				}
			}//end if color->min_height
			$width = "";
			if($color->min_width){
				$width = $color->min_width;
				if($color->min_width != $color->max_width && $color->max_width){
					$width = sprintf("%s-%s", $color->min_width, $color->max_width);
				}
				if($color->width_unit){
					$width .= sprintf(" %s", $color->width_unit);
				}
			}
			?>
			<td class="color-height edit"><?=$height;?>
			</td>
			<td class="color-width edit"><?=$width;?></td>
			<td class="color-view edit"><a class="button"
				href="<?=site_url("color/view/$color->id");?>">View</a></td>
		</tr>

		<? endforeach; ?>
	</tbody>
</table>

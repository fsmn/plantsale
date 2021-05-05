<?php defined('BASEPATH') OR exit('No direct script access allowed');
// list.php Chris Dart Mar 5, 2013 10:57:17 AM chrisdart@cerebratorium.com
?>
<table id="variety-list" class="list" >
	<thead>
		<tr>
			<th>Species</th>
			<th>Variety</th>
			<th>Height</th>
			<th>Width</th>
			<th>Year</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($varieties as $variety): ?>
		<tr id="variety-row_<?php print $variety->id;?>" class="variety-row">
			<td><a href="<?php print base_url('variety/view/' . $variety->id);?>"><?php print $variety->species;?></a></td>
			<td class="variety-variety edit"><a href="<?php print base_url('variety/view/' . $variety->id);?>"><?php print $variety->variety;?></a></td>
			<?php
			$height = '';
			if($variety->min_height){
				$height = $variety->min_height;
				if($variety->min_height != $variety->max_height && $variety->max_height) {
					$height = format_string('@min_height-@max_height', [
						'@min_height' => $variety->min_height,
						'@max_height' => $variety->max_height,
					]);
				}
				if($variety->height_unit){
					$height .= format_string(' @height_unit', ['@height_unit' => $variety->height_unit]);
				}
			}//end if variety->min_height
			$width = '';
			if($variety->min_width){
				$width = $variety->min_width;
				if($variety->min_width != $variety->max_width && $variety->max_width){
					$width = format_string('@min_width-@max_width', [
						'@min_width' => $variety->min_width,
						'@max_width' => $variety->max_width,
					]);
				}
				if($variety->width_unit){
					$width .= format_string(' @width_unit', ['@width_unit' => $variety->width_unit]);
				}
			}
			?>
			<td class="variety-height edit"><?php print $height;?>
			</td>
			<td class="variety-width edit"><?php print $width;?></td>
			<td class="variety-year edit"><?php print $variety->year;?></td>
		</tr>

		<?php endforeach; ?>
	</tbody>
</table>

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
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($varieties as $variety): ?>
		<tr id="variety-row_<?=$variety->id;?>" class="variety-row">
			<td><?=$variety->species;?></td>
			<td class="variety-variety edit"><?=$variety->variety;?></td>
			<?
			$height = "";
			if($variety->min_height){
				$height = $variety->min_height;
				if($variety->min_height != $variety->max_height && $variety->max_height) {
					$height = sprintf("%s-%s", $variety->min_height, $variety->max_height);
				}
				if($variety->height_unit){
					$height .= sprintf(" %s", $variety->height_unit);
				}
			}//end if variety->min_height
			$width = "";
			if($variety->min_width){
				$width = $variety->min_width;
				if($variety->min_width != $variety->max_width && $variety->max_width){
					$width = sprintf("%s-%s", $variety->min_width, $variety->max_width);
				}
				if($variety->width_unit){
					$width .= sprintf(" %s", $variety->width_unit);
				}
			}
			?>
			<td class="variety-height edit"><?=$height;?>
			</td>
			<td class="variety-width edit"><?=$width;?></td>
			<td class="variety-year edit"><?=$variety->year;?></td>
			<td class="variety-view edit">
						<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"id"=>"id_$variety->id","href"=>site_url("variety/view/$variety->id")));?>
			
			</td>
		</tr>

		<? endforeach; ?>
	</tbody>
</table>

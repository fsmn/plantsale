<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<div style="overflow: scroll;max-height: 25em">

<table id="color-name-list" class="list compressed">
	<?if($full_list):?>
		<thead>
			<tr>
				<th>Color</th>
	
				<th>Species</th>
				
				<th>Common Name</th>
				
				<th>Genus</th>
	
				<th>Height</th>
	
				<th>Width</th>
	
				<th>Details</th>
	
				<th></th>
			</tr>
		</thead>
	<? endif; ?>
	<tbody>
		<? foreach($names as $name){ ?>
		<tr>
			<td><span class="color-color color-edit-row"
				id="color-color_<?=$name->id;?>"><?=$name->color;?> </span>
			</td>
			<td><span class="color-species color-edit-row"
				id="color-species_<?=$name->id;?>"><?=$name->species;?> </span>
			</td>
			<td><span class="color-common-name color-edit-row"
				id="color-common-name_<?=$name->id;?>"><a href="<?=base_url("common/view/$name->common_id");?>"><?=$name->common_name;?></a></span>
			</td>
			<td><span class="color-species color-edit-row"
				id="color-genus_<?=$name->id;?>"><?=$name->genus;?> </span>
			</td>
			<?
			$height = "";
			if($name->min_height){
				$height = $name->min_height;
				if($name->min_height != $name->max_height && $name->max_height) {
					$height = sprintf("%s-%s", $name->min_height, $name->max_height);
				}
				if($name->height_unit){
					$height .= sprintf(" %s", $name->height_unit);
				}
			}//end if color->min_height
			$width = "";
			if($name->min_width){
				$width = $name->min_width;
				if($name->min_width != $name->max_width && $name->max_width){
					$width = sprintf("%s-%s", $name->min_width, $name->max_width);
				}
				if($name->width_unit){
					$width .= sprintf(" %s", $name->width_unit);
				}
			}
			?>
			<td><span class="color-height color-edit-row"
				id="color-height_<?=$name->id;?>"><?=$height;?> </span>
			</td>
				<td><span class="color-width color-edit-row"
				id="color-width_<?=$name->id;?>"><?=$width;?> </span>
			</td>
			<td>
			<a class="button" id="id_<?=$name->id;?>"
				href="<?=site_url("color/view/$name->id");?>">Details</a>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>
</div>
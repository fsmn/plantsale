<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<div style="overflow: scroll;max-height: 25em">

<table id="variety-name-list" class="list compressed">
	<?if($full_list):?>
		<thead>
			<tr>
				<th>variety</th>
	
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
			<td><span class="variety-variety variety-edit-row"
				id="variety-variety_<?=$name->id;?>"><?=$name->variety;?> </span>
			</td>
			<td><span class="variety-species variety-edit-row"
				id="variety-species_<?=$name->id;?>"><?=$name->species;?> </span>
			</td>
			<td><span class="variety-common-name variety-edit-row"
				id="variety-common-name_<?=$name->id;?>"><a href="<?=base_url("common/view/$name->common_id");?>"><?=$name->common_name;?></a></span>
			</td>
			<td><span class="variety-species variety-edit-row"
				id="variety-genus_<?=$name->id;?>"><?=$name->genus;?> </span>
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
			}//end if variety->min_height
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
			<td><span class="variety-height variety-edit-row"
				id="variety-height_<?=$name->id;?>"><?=$height;?> </span>
			</td>
				<td><span class="variety-width variety-edit-row"
				id="variety-width_<?=$name->id;?>"><?=$width;?> </span>
			</td>
			<td>
			<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"id"=>"id_$name->id","href"=>site_url("variety/view/$name->id")));?>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<div style="overflow: scroll;max-height: 25em">

<table id="variety-name-list" class="list compressed">
	<?php if($full_list):?>
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
	<?php endif; ?>
	<tbody>
		<?php foreach($names as $name){ ?>
		<tr>
			<td><span class="variety-variety variety-edit-row"
				id="variety-variety_<?php print $name->id;?>"><?php print $name->variety;?> </span>
			</td>
			<td><span class="variety-species variety-edit-row"
				id="variety-species_<?php print $name->id;?>"><?php print $name->species;?> </span>
			</td>
			<td><span class="variety-common-name variety-edit-row"
				id="variety-common-name_<?php print $name->id;?>"><a href="<?php print base_url('common/view/' . $name->common_id);?>"><?php print $name->common_name;?></a></span>
			</td>
			<td><span class="variety-species variety-edit-row"
				id="variety-genus_<?php print $name->id;?>"><?php print $name->genus;?> </span>
			</td>
			<?php
			$height = '';
			if($name->min_height){
				$height = $name->min_height;
				if($name->min_height != $name->max_height && $name->max_height) {
					$height = format_string('@min_height-@max_height', [
						'@min_height' => $name->min_height,
						'@max_height' => $name->max_height,
					]);
				}
				if($name->height_unit){
					$height .= format_string(' @height_unit', ['@height_unit' => $name->height_unit]);
				}
			}//end if variety->min_height
			$width = '';
			if($name->min_width){
				$width = $name->min_width;
				if($name->min_width != $name->max_width && $name->max_width){
					$width = format_string('@min_width-@max_width', [
							'@min_width' => $name->min_width,
							'@max_width' => $name->max_width,
					]);
				}
				if($name->width_unit){
					$width .= format_string(' @width_unit', ['@width_unit' => $name->width_unit]);
				}
			}
			?>
			<td><span class="variety-height variety-edit-row"
				id="variety-height_<?php print $name->id;?>"><?php print $height;?> </span>
			</td>
				<td><span class="variety-width variety-edit-row"
				id="variety-width_<?php print $name->id;?>"><?php print $width;?> </span>
			</td>
			<td>
			<?php print create_button([
					'text' => 'Details',
					'class' => [
							'button',
							'details'
					],
					'id' => 'id_' . $name->id,
					'href' => site_url('variety/view/' . $name->id)
			]);?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>

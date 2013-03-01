<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h2>
	<?=$common->name;?>
</h2>
<? $buttons[] = array("selection" => "common" , "text" => "Edit", "class" => array("button","edit","common-edit"), "id" => "ec_$common->id", "type" => "span", "title" => "Edit this record");
print create_button_bar($buttons);
?>
<fieldset id="common">
<input type="hidden" name="id" id="id" value="<?=$common->id;?>"/>
	<?=create_edit_field("genus", $common->genus, "Genus");?>
	<?=create_edit_field("species", $common->species, "Species");?>
	<?=create_edit_field("category", $common->category, "Category", array("class"=>"dropdown", "attributes"=>"menu='common_category'"));?>
	<?=create_edit_field("subcategory", $common->subcategory, "Subcategory");?>
	<?=create_edit_field("latin_name", $common->latin_name, "Latin Name");?>
	<?=create_edit_field("description", $common->description, "Description", array("class"=>"textarea"));?>


</fieldset>
<table id="color-list">
	<thead>
		<tr>
			<th>Name</th>
			<th>Color</th>
			<th>Height</th>
			<th>Width</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($colors as $color): ?>
		<tr id="color-row_<?=$color->id;?>" class="color-row">
			<td><?=$color->name;?></td>
			<td class="color-color edit"><?=$color->color;?></td>
			<td class="color-height edit"><?=$color->height;?></td>
			<td class="color-width edit"><?=$color->width;?></td>
			<td class="color-view edit"><a class="button"
				href="<?=site_url("color/view/$color->id");?>">View</a></td>
		</tr>

		<? endforeach; ?>

		<tr id="color-row-new">
			<td><span class="button new color-create"
				id="common-id_<?=$common->id;?>">Add a Color</span></td>
		</tr>
	</tbody>
</table>

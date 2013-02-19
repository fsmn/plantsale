<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h2>
	<?=$common->name;?>
</h2>
<? $buttons[] = array("selection" => "common" , "text" => "Edit", "class" => array("button","edit","common-edit"), "id" => "ec_$common->id", "type" => "span", "title" => "Edit this record");
print create_button_bar($buttons);
?>
<p>
	<label>Genus:</label>
	<?=$common->genus;?>
</p>
<p>
	<label>Species:</label>
	<?=$common->species;?>
</p>
<p>
	<label>Category:</label>
	<?=$common->category;?>
</p>
<p>
	<label>Subcategory:</label>
	<?=$common->subcategory;?>
</p>
<p>
	<label>Latin Name:</label>
	<?=$common->latin_name;?>
</p>
<p>
	<label>Description:</label><br />
	<?=$common->description;?>
</p>

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
			<td class="color-view edit"><span class="button">View</span></td>
		</tr>

		<? endforeach; ?>

		<tr id="color-row-new">
			<td><span class="button new color-add" id="common-id_<?=$common->id;?>">Add a Color</span></td>
		</tr>
	</tbody>
</table>

<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>

<table id="common-name-list" class="list compressed">
	<?if($full_list):?>
	<thead>
		<tr>
			<th>Name</th>

			<th>Genus</th>

			<th>Category</th>

			<th>Sunlight</th>

			<th>Description</th>

			<th></th>
		</tr>
	</thead>
	<? endif; ?>
	<tbody>
		<? foreach($names as $name){ ?>
		<tr>
			<td><span class="common-name common-edit-row"
				id="cnid_<?=$name->id;?>"><?=$name->name;?> </span>
			</td>
			<td><span class="common-genus common-edit-row"
				id="cgid_<?=$name->id;?>"><?=$name->genus;?> </span>
			</td>
			<td><span class="common-category common-edit-row"
				id="ccid_<?=$name->id;?>"><?=$name->category;?> </span>
			</td>
			<td><a class="button" id="id_<?=$name->id;?>"
				href="<?=site_url("common/view/$name->id");?>">Details</a>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

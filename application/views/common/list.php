<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Feb 27, 2013 11:07:53 AM chrisdart@cerebratorium.com

?>

<table id="common-name-list">
	<?if($full_list):?><thead>
		<tr>
			<th>Name</th>
		</tr>
		<tr>
			<th>Species</th>
		</tr>
		<tr>
			<th>Genus</th>
		</tr>
		<tr>
			<th>Category</th>
		</tr>
		<tr>
			<th>Description</th>
		</tr>
		<tr>
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
		</tr>
		<tr>
			<td><span class="common-species common-edit-row"
				id="csid_<?=$name->id;?>"><?=$name->species;?> </span>
			</td>
		</tr>
		<tr>
			<td><span class="common-genus common-edit-row"
				id="cgid_<?=$name->id;?>"><?=$name->genus;?> </span>
			</td>
		</tr>
		<tr>
			<td><span class="common-category common-edit-row"
				id="ccid_<?=$name->id;?>"><?=$name->category;?> </span>
			</td>
		</tr>
		<tr>
			<td><span class="common-description common-edit-row"
				id="cdid_<?=$name->id;?>"><?=$name->description;?> </span>
			</td>
		</tr>
		<tr>
			<td><span class="button" id="id_<?=$name->id;?>">View Details</span>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

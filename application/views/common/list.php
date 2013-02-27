<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Feb 27, 2013 11:07:53 AM chrisdart@cerebratorium.com

?>

<table id="common-name-list">
	<?if($full_list):?><thead>
		<tr>
			<th>Name</th>

			<th>Species</th>
	
			<th>Genus</th>
	
			<th>Category</th>
	
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
	
			<td><span class="common-species common-edit-row"
				id="csid_<?=$name->id;?>"><?=$name->species;?> </span>
			</td>
		
			<td><span class="common-genus common-edit-row"
				id="cgid_<?=$name->id;?>"><?=$name->genus;?> </span>
			</td>
		
			<td><span class="common-category common-edit-row"
				id="ccid_<?=$name->id;?>"><?=$name->category;?> </span>
			</td>
					<td><span class="common-description common-edit-row"
				id="cdid_<?=$name->id;?>"><?=$name->description;?> </span>
			</td>
		
			<td><a class="button" id="id_<?=$name->id;?>" href="<?=site_url("common/view/$name->id");?>">View Details</a>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

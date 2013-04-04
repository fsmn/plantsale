<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Feb 27, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<fieldset class="search_fieldset">
	<legend>Search Parameters</legend>
	<?
	if(!empty($params)){

		$keys = array_keys($params);
		$values = array_values($params);
		echo "<ul>";
		for($i = 0; $i < count($params); $i++){
			echo "<li>" . ucfirst($keys[$i]) .": <strong>";
			if(is_array($values[$i])){
				echo implode(", ", $values[$i]);
			}else{
				echo $values[$i];
			}
			echo "</strong></li>";
		}
		echo "</ul>";

	}else{
		echo "<p>Showing All Common Names</p>";

	}
	?>

	<div class="button-box">
		<span class="button search-common-names">Refine Search</span>
	</div>
</fieldset>
<table id="common-name-list" class="list">
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
			<td><span class="common-sunlight common-edit-row"
				id="csid_<?=$name->id;?>"> <?=$name->sunlight;?>
			</span>
			</td>

			<td><span class="common-description common-edit-row"
				id="cdid_<?=$name->id;?>"><?=$name->description;?> </span>
			</td>

			<td><a class="button" id="id_<?=$name->id;?>"
				href="<?=site_url("common/view/$name->id");?>">Details</a>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
print $this->input->post("year");
// list.php Chris Dart Feb 27, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class="search-parameters">
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
<p>
Found Count: <strong><?=count($names);?> Records</strong>
</p>
<?php echo create_button_bar(array(array("text"=>"Refine Search","class"=>array("button","refine","search","dialog","search-common-names"),"href"=>site_url("common/search"))));?>
	</div>
</fieldset>
<table id="common-name-list" class="list">
	<?if($full_list):?>
	<thead>
		<tr>
			<th>Name</th>

			<th>Genus</th>

			<th>Category</th>

			<th>Subcategory</th>

			<th>Sunlight</th>

			<th>Description</th>

			<th></th>
		</tr>
	</thead>
	<? endif; ?>
	<tbody>
		<? foreach($names as $name): ?>
		<tr>
			<td><?=edit_field("name", $name->name, "","common",$name->id,array("envelope"=>"span"));?>
			</td>
			<td>
			<?=edit_field("genus", $name->genus, "","common",$name->id,array("envelope"=>"span"));?>

			</td>

			<td><?=edit_field("category_id", $name->category, "","common",$name->id, array("envelope"=>"span","class"=>"category-dropdown"));?>
			</td>
			<td>
			<?=edit_field("subcategory_id", $name->subcategory, "","common",$name->id, array("envelope"=>"span","class"=>"subcategory-dropdown"));?>
			</td>
			<td>	<?=edit_field("sunlight",$name->sunlight, "","common",$name->id,array("envelope"=>"span","class"=>"multiselect","attributes"=>"menu='sunlight'","format"=>"multiselect"));?>

			</td>

			<td>	<?=edit_field("description", $name->description, "","common",$name->id, array("envelope"=>"span","class"=>"textarea"));?>

			</td>

			<td>
			<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"href"=>site_url("common/view/$name->id")));?>

			</td>
		</tr>
		<? endforeach; ?>
	</tbody>
</table>

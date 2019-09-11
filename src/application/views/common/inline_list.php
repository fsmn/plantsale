<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>

<table id="common-name-list" class="list compressed">
	<?php if($full_list):?>
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
	<?php endif; ?>
	<tbody>
		<?php foreach($names as $name): ?>
		<tr>
			<td><span class="common-name common-edit-row"
				id="cnid_<?php echo $name->id;?>"><?php echo $name->name;?> </span>
			</td>
			<td><span class="common-genus common-edit-row"
				id="cgid_<?php echo $name->id;?>"><?php echo $name->genus;?> </span>
			</td>
			<td><span class="common-category common-edit-row"
				id="ccid_<?php echo $name->id;?>"><?php echo $name->category;?> </span>
			</td>
			<td>
			<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"href"=>site_url("common/view/$name->id")));?>
			<a class="button" id="id_<?php echo $name->id;?>"
				href="<?php echo site_url("common/view/$name->id");?>">Details <?php echo add_fa_icon(array("details"));?></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

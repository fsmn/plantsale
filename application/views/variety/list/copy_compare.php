<?php
$fields = array (
		"Common",
		"Latin",
		"Variety",
		"Description",
		"Web Description",
		"Print Description",
		"ARCIVED Description",
		"ARCHIVED Variety Note",
		"ARCHIVED Extended Description" 
);

?>
<table class="list table">
<thead>
<tr>
<?php foreach($fields as $field):?>
<th><?php echo $field; ?>
<?php endforeach;?>
</tr>
</thead>
<tbody>
<?php foreach($plants as $plant):?>
<tr>
<td><a href="<?php echo base_url("common/view/$plant->common_id");?>"><?php echo $plant->name;?></a></td>
<td><?php echo format_latin_name($plant->genus,$plant->species);?></td>
<td><a href="<?php echo base_url("variety/view/$plant->variety_id");?>"><?php echo $plant->variety;?></a></td>
<td>
<span class="field-envelope" id="common__description__<?=$plant->common_id;?>">
				<span class="textarea live-field text" name="description">
					<textarea name="description" cols="40" rows="10" id="description_<?=$plant->common_id;?>" size="127" type="textarea" category=""><?php echo get_value($plant,"description");?></textarea>
				</span>
			</span>
			</td>
			<td><span class="field-envelope" id="variety__web_description__<?=$plant->variety_id?>">
				<span class="textarea live-field text" name="web_description">
					<textarea name="web_description" cols="40" rows="10" id="web-description_<?=$plant->variety_id;?>" size="5" type="textarea" category=""><?=get_value($plant,"web_description");?></textarea>
				</span>
			</span>
			</td>
<td>
<span class="field-envelope" id="variety__print_description__<?=$plant->variety_id?>">
				<span class="textarea live-field text" name="print_description">
					<textarea name="print_description" cols="40" rows="10" id="print-description_<?=$plant->variety_id;?>" size="5" type="textarea" category=""><?=get_value($plant,"print_description");?></textarea>
				</span>
			</span>
</td>
<td>
<?php echo $plant->old_description; ?>
</td>
<td>
<?php echo $plant->note;?>
</td>
<td>
<?php echo $plant->extended_description;?>
</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
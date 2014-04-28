<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h2>
	<?=$common->name;?>
</h2>
<? $buttons[] = array("selection" => "common" , "text" => "Edit", "class" => array("button","edit","common-edit"), "id" => "ec_$common->id", "type" => "span", "title" => "Edit this record");
print create_button_bar($buttons);
?>
<div class="grouping" id="common">
	<input type="hidden" name="id" id="id" value="<?=$common->id;?>" />
	<?=create_edit_field("genus", $common->genus, "Genus");?>
	<?=create_edit_field("category", $common->category, "Category", array("class"=>"dropdown", "attributes"=>"menu='common_category'"));?>
	<?=create_edit_field("subcategory", $common->subcategory, "Subcategory");?>
	<?=create_edit_field("description", $common->description, "Description", array("class"=>"textarea"));?>
	<?=create_edit_field("extended_description", $common->extended_description, "Extended Description (for web)", array("class"=>"textarea"));?>
	<?=create_edit_field("other_names",$common->other_names, "Other Names");?>
	<?=create_edit_field("sunlight",$common->sunlight, "Sunlight Requirements",array("class"=>"multiselect","attributes"=>"menu='sunlight'","format"=>"multiselect"));?>

</div>
<? $this->load->view("variety/list");?>
<? print create_button_bar(array(
		array(
		"selection"=>"variety",
		"text"=>"Add a variety",
		"class"=>array("button","new","variety-create"),
		"id"=>sprintf("common-id_%s",$common->id),
		"type"=>"span",
		"title"=>"add a new variety",
)
)
);


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
	<?=create_edit_field("comment",$common->comment, "Comment", array("class"=>"textarea"));?>
	<?=create_edit_field("sunlight",$common->sunlight, "Sunlight Requirements", array("class"=>"checkbox","attributes"=>"menu='sunlight'"));?>

</div>
<? $this->load->view("color/list");?>
<? print create_button_bar(array(
		array(
		"selection"=>"color",
		"text"=>"Add a Color",
		"class"=>array("button","new","color-create"),
		"id"=>sprintf("common-id_%s",$common->id),
		"type"=>"span",
		"title"=>"add a new color",
)
)
);


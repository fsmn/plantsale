<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>
	<?=$common->name;?>
</h2>
<? if(DB_ROLE == 1):?>
<? $buttons[] = array("selection" => "common" , "text" => "Edit", "class" => array("button","edit","common-edit"), "id" => "ec_$common->id", "type" => "span", "title" => "Edit this record");?>
<?=create_button_bar($buttons);?>
<? endif; ?>
<div class="grouping" id="common">
	<input type="hidden" name="id" id="id" value="<?=$common->id;?>" />
	<?=edit_field("genus", $common->genus, "Genus","common",$common->id);?>
	<?=edit_field("category", $common->category, "Category","common",$common->id, array("class"=>"dropdown", "attributes"=>"menu='common_category'"));?>
	<?=edit_field("subcategory", $common->subcategory, "Subcategory","common",$common->id);?>
	<?=edit_field("description", $common->description, "Description","common",$common->id, array("class"=>"textarea"));?>
	<?=edit_field("extended_description", $common->extended_description, "Extended Description (for web)","common",$common->id, array("class"=>"textarea"));?>
	<?=edit_field("other_names",$common->other_names, "Other Names","common",$common->id);?>
	<?=edit_field("sunlight",$common->sunlight, "Sunlight Requirements","common",$common->id,array("class"=>"multiselect","attributes"=>"menu='sunlight'","format"=>"multiselect"));?>

</div>
<? $this->load->view("variety/list");?>
<?


if (DB_ROLE == 1) {
	print create_button_bar ( array (
			array (
					"selection" => "variety",
					"text" => "Add a variety",
					"class" => array (
							"button",
							"new",
							"variety-create" 
					),
					"id" => sprintf ( "common-id_%s", $common->id ),
					"type" => "span",
					"title" => "add a new variety" 
			) 
	) );
}


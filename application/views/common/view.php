<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>
	<?=edit_field("name", $common->name, "","common",$common->id,array("envelope"=>"span"));?>

</h2>
<div
	class="grouping column left"
	style="min-width: 400px;"
	id="common">
<?

if (IS_EDITOR) {
    $buttons["edit_common"] = array(
            "selection" => "common",
            "text" => "Edit",
            "class" => array(
                    "button",
                    "edit",
                    "common-edit"
            ),
            "id" => "ec_$common->id",
            "type" => "span",
            "title" => "Edit this record"
    );

    $buttons["add_variety"] = array(
            "selection" => "variety",
            "text" => "Add a variety",
            "class" => array(
                    "button",
                    "new",
                    "variety-create"
            ),
            "id" => sprintf("common-id_%s", $common->id),
            "type" => "span",
            "title" => "add a new variety"
    );
    if (empty($varieties)) {
        $buttons["delete_common"] = array(
                "selection" => "common",
                "text" => "Delete",
                "class" => array(
                        "button",
                        "delete",
                        "delete-common"
                ),
                "id" => "delete-common_$common->id",
                "type" => "span",
                "title" => "Delete this Common"
        );

    }
    print create_button_bar($buttons);

}?>
	<input
		type="hidden"
		name="id"
		id="id"
		value="<?=$common->id;?>" />

	<?=edit_field("genus", $common->genus, "Genus","common",$common->id);?>
	<?=edit_field("category_id", $common->category, "Category","common",$common->id, array("envelope"=>"p","class"=>"category-dropdown"));?>
	<?=edit_field("subcategory_id", $common->subcategory, "Subcategory","common",$common->id,array("envelope"=>"p","class"=>"subcategory-dropdown"));?>
	<?=edit_field("description", $common->description, "Description","common",$common->id, array("class"=>"textarea","envelope"=>"div","field-wrapper"=>"div"));?>
	<?=edit_field("other_names",$common->other_names, "Other Names","common",$common->id);?>
	<?=edit_field("sunlight",$common->sunlight, "Sunlight Requirements","common",$common->id,array("class"=>"multiselect","attributes"=>"menu='sunlight'","format"=>"multiselect"));?>

</div>
<?
if (IS_EDITOR) {
    print create_button_bar(array(
            $buttons["add_variety"]
    ));
}

?>
<div class="column-right common-varieties">
<? $this->load->view("variety/list");?>
</div>


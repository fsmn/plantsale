<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>
	<?php echo edit_field('name', $common->name, '','common',$common->id,array('envelope'=>'span'));?>

</h2>
<div class="grouping column first" style="min-width: 400px;" id="common">
    <?php

if (IS_EDITOR) {
    $buttons['edit_common'] = array(
            'selection' => 'common',
            'text' => 'Edit',
            'class' => array(
                    'button',
                    'edit',
            		'dialog',
                    'common-edit'
            ),
    		'style'=>'edit',
            'id' => 'ec_$common->id',
            'href' => site_url('common/edit/'.$common->id),
            'title' => 'Edit this record'
    );

    $buttons['add_variety'] = array(
            'selection' => 'variety',
            'text' => 'Add a variety',
            'class' => array(
                    'button',
                    'new',
            		'create',
            		'dialog',
                    'variety-create'
            ),
    		'style'=>'new',
            'id' => sprintf('common-id_%s', $common->id),
            'href' => site_url('variety/create?common_id='.$common->id),
            'title' => 'add a new variety'
    );
    if (empty($varieties)) {
        $buttons['delete_common'] = [
                'selection' => 'common',
                'text' => 'Delete',
                'class' => [
                        'button',
                        'delete',
                        'dialog'
                ],
        		'style'=>'delete',
                'data_values' => ['common_id'=>$common->id],
                'href' => base_url('common/delete/' . $common->id),
                'title' => 'Delete this Common',
            ];
        }
        print create_button_bar($buttons);
    } ?>
    <input type="hidden" name="id" id="id" value="<?php print $common->id; ?>" />

	<?php echo edit_field('genus', $common->genus, 'Genus','common',$common->id);?>
	<?php echo edit_field('category_id', $common->category, 'Category','common',$common->id, array('envelope'=>'p','class'=>'category-dropdown'));?>
	<?php echo edit_field('subcategory_id', $common->subcategory, 'Subcategory','common',$common->id,array('envelope'=>'p','class'=>'subcategory-dropdown'));?>
	<?php echo edit_field('description', $common->description, 'Description','common',$common->id, array('class'=>'textarea','envelope'=>'div','field-wrapper'=>'div'));?>
	<?php echo edit_field('other_names',$common->other_names, 'Other Names','common',$common->id);?>
	<?php echo edit_field('sunlight',$common->sunlight, 'Sunlight Requirements','common',$common->id,array('class'=>'multiselect','attributes'=>'menu="sunlight"','format'=>'multiselect'));?>

</div>

<div class='column-right column last'>
</div>
<div class='column first  common-varieties'>
<?php
if (IS_EDITOR) {
    print create_button_bar(array(
            $buttons['add_variety']
    ));
}

?>
<?php $this->load->view('variety/list/list');?>
</div>
<div class='column last'></div>

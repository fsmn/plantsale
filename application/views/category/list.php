<?php 
$buttons[] = array("text"=>"New Category","class"=>array("new","button","dialog","create"),"style"=>"new","href"=>site_url("category/create"));
echo create_button_bar($buttons);

?>


<ul class="field-list list">
<?php foreach($categories as $category): ?>
	<li class="list-item">
	<?php echo live_field("category",$category->category,"category", $category->id,array("size"=>"200","envelope"=>"span")); ?>
	<?php echo create_button(array("text"=>"Add Subcategory","class"=>"new button dialog create small","href"=>site_url("subcategory/create/$category->id")));?>
	<?php if(!empty($category->subcategories)): ?>
		<ul class="field-list list child">
		<?php foreach($category->subcategories as $subcategory):?>
		<li class="list-item">
			<?php echo live_field("subcategory",$subcategory->subcategory,"subcategory", $subcategory->id,array("size"=>"auto","envelope"=>"span")); ?>
		&nbsp;
					<?php echo live_field("web_label",$subcategory->web_label ,"subcategory", $subcategory->id,array("size"=>"200","envelope"=>"span")); ?>
		
		</li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	</li>
<?php endforeach; ?>
</ul>
<?php ?>

<form id="subcategory-editor" name="subcategory-editor" action="<?php echo site_url("subcategory/$action");?>" method="post">
<input type="hidden" name="id" value="<?php echo get_value($subcategory,"id");?>"/>
<input type="hidden" name="category_id" value="<?php echo $category_id;?>"/>
<p>
<label for="subcategory">subcategory: </label>
<input type="text" name="subcategory" id="subcategory" value="<?php echo get_value($subcategory,"subcategory");?>"/>
</p>
<p>
<input type="submit"  class="new button" value="<?php echo ucfirst($action);?>"/>
</p>
</form>
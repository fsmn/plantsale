<?php ?>

<form id="category_editor" name="category-editor" action="<?php echo site_url("category/$action");?>" method="post">
<input type="hidden" name="id" value="<?php get_value($category,"id");?>"/>
<p>
<label for="category">Category: </label>
<input type="text" name="category" id="category" value="<?php echo get_value($category,"category");?>"/>
</p>
<p>
<input type="submit"  class="new button" value="<?php echo ucfirst($action);?>"/>
</p>
</form>
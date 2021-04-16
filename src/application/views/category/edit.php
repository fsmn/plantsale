<?php ?>

<form id="category_editor" name="category-editor" action="<?php print site_url('category/' . $action); ?>" method="post">
    <input type="hidden" name="id" value="<?php get_value($category, 'id'); ?>" />
    <p>
        <label for="category">Category: </label>
        <input type="text" name="category" id="category" value="<?php print get_value($category, 'category'); ?>" />
    </p>
    <p>
        <input type="submit" class="new button" value="<?php print ucfirst($action); ?>" />
    </p>
</form>
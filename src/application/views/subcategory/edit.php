<?php ?>

<form id="subcategory-editor" name="subcategory-editor" action="<?php print site_url('subcategory/' . $action); ?>" method="post">
    <input type="hidden" name="id" value="<?php print get_value($subcategory, 'id'); ?>" />
    <input type="hidden" name="category_id" value="<?php print $category_id; ?>" />
    <p>
        <label for="subcategory">subcategory: </label>
        <input type="text" name="subcategory" id="subcategory" value="<?php print get_value($subcategory, 'subcategory'); ?>" />
    </p>
    <p>
        <input type="submit" class="new button" value="<?php print ucfirst($action); ?>" />
    </p>
</form>
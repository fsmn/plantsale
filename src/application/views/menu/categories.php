<?php defined('BASEPATH') or exit('No direct script access allowed');

// categories.php Chris Dart Jan 26, 2015 4:57:16 PM chrisdart@cerebratorium.com

?>
<ul>
    <?php foreach ($categories as $category) : ?>
        <li><a href="<?php print site_url('menu/show_all/' . $category->category); ?>"><?php print $category->category; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
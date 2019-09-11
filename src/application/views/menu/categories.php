<?php defined('BASEPATH') OR exit('No direct script access allowed');

// categories.php Chris Dart Jan 26, 2015 4:57:16 PM chrisdart@cerebratorium.com

?>
<ul>
<?php foreach($categories as $category):?>
<li><a href="<?php echo site_url("menu/show_all/$category->category");?>"><?php echo $category->category;?></a></li>
<?php endforeach;?>
</ul>
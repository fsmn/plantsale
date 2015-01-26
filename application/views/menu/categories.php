<?php defined('BASEPATH') OR exit('No direct script access allowed');

// categories.php Chris Dart Jan 26, 2015 4:57:16 PM chrisdart@cerebratorium.com

?>
<ul>
<? foreach($categories as $category):?>
<li><a href="<?=site_url("menu/show_all/$category->category");?>"><?=$category->category;?></a></li>
<? endforeach;?>
</ul>
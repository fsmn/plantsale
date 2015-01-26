<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Jan 26, 2015 3:56:07 PM chrisdart@cerebratorium.com
?>
<h2><?=$title;?></h2>
<? $this->load->view("menu/categories");?>
<?=create_button_bar(array(array("text"=>"Add New Item","class"=>array("button","new","create-menu-item"),"href"=>site_url("menu/create"))));?>
<table class="list">
<thead>
<tr>
<th>Category</th>
<th>Key</th>
<th>Value</th>
<th></th>
</tr>
</thead>
<tbody>
<? foreach($items as $item): ?>
<tr>
<td><?=$item->category;?></td>
<td><?=$item->key;?></td>
<td><?=$item->value;?></td>
<td><a class="button edit edit-menu-item" id="edit-menu-item_<?=$item->id;?>" href="<?=site_url("menu/edit/$item->id");?>">Edit</a>
</tr>
<? endforeach;?>
</tbody>
</table>
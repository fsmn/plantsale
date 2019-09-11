<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Jan 26, 2015 3:56:07 PM chrisdart@cerebratorium.com
?>
<h2><?php echo $title;?></h2>
<?php $this->load->view("menu/categories");?>
<?php echo create_button_bar(array(array("text"=>"Add New Item","class"=>array("button","new","create-menu-item"),"href"=>site_url("menu/create"))));?>
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
<?php foreach($items as $item): ?>
<tr>
<td><?php echo $item->category;?></td>
<td><?php echo $item->key;?></td>
<td><?php echo $item->value;?></td>
<td>
<?php echo create_button(array("text"=>"Edit","class"=>array("button","edit","edit-menu-item"),"id"=>"edit-menu-item_$item->id","href"=>site_url("menu/edit/$item->id")));?>
</tr>
<?php endforeach;?>
</tbody>
</table>
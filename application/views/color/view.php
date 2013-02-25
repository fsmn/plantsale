<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "color",
		"text" => "Edit",
		"class" => array("button edit color_edit"),
		"id" => "ce_$color->id",
		"title" => "Edit this color");
echo create_button_bar($buttons);
print_r($color);
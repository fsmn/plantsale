<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "index",
"text" => "Home",
"class" => array("button"),
"href"=> site_url(""),
"title" => "Home");

$buttons[] = array("selection" => "common",
"text" => "Common Names",
"class" => array("button","show-common-names"),
"href"=> site_url("common"),
"title" => "View the list of common names");

print create_button_bar($buttons, array("id" =>"navigation-buttons"));

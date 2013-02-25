<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "index",
		"text" => "Log Out",
		"class" => array("button"),
		"href"=> site_url("auth/logout"),
		"title" => sprintf("Log out %s",$this->session->userdata("username")));


print create_button_bar($buttons,
		array("id" =>"utility-buttons")
);

<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(DB_ROLE == 1){
$buttons["edit"] = array("text"=>"Edit","class"=>"button edit variety-edit","id"=>"edit-variety_$variety->id","href"=>site_url("variety/edit/?id=$variety->id"),"selection"=>"home");
}
$buttons["print-options"] = array("text"=>"Print","class"=>"button print variety-print-options","id"=>"print-options_$variety->id","href"=>site_url("variety/print_options/$variety->id"),"selection"=>"home","target"=>"_blank");
if(DB_ROLE == 1){
	$buttons["delete"] = array("text"=>"Delete","class"=>"button delete variety-delete","id"=>"delete-variety_$variety->id","type"=>"span","selection"=>"home");
}

print create_button_bar($buttons);
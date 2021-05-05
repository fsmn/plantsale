<?php defined('BASEPATH') OR exit('No direct script access allowed');

// navigation.php Chris Dart May 27, 2014 7:43:10 PM chrisdart@cerebratorium.com
$fonts = array("lato","ubuntu","merriweather-sans","merriweather");
foreach($fonts as $font){
    $is_active = "";
    if($font == "ubuntu"){
        $is_active = "active";
    }
$buttons[] = array("text"=> format_string("Try @font Font", ['@font' => ucfirst($font)]), "class"=>array("button","change-font", $is_active),"style"=>"print","id"=>$font );
}
print create_button_bar($buttons);
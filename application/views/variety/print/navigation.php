<?php defined('BASEPATH') OR exit('No direct script access allowed');

// navigation.php Chris Dart May 27, 2014 7:43:10 PM chrisdart@cerebratorium.com
$fonts = array("lato","ubuntu","merriweather-sans","merriweather");
foreach($fonts as $font){
$buttons[] = array("text"=>sprintf("Try %s Font",ucfirst($font)), "class"=>"button change-font","id"=>$font );
}
print create_button_bar($buttons);
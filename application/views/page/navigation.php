<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "index", "text" => "Common Names", "class" => array("button","new","show-common-names"), "href"=> site_url("common"), "title" => "Add a new student to the database");
	$buttons[] = array("selection" => "attendance" , "text" => "Search Attendance", "class" => array("button","show_attendance_search"), "type" => "span", "title" => "Search attendance records");
	$buttons[] = array("selection" => "teacher\?", "text" => "List Teachers", "href" => site_url("teacher?gradeStart=0&gradeEnd=8"), "title" => "List all the teachers &amp; other users in the database");
	$buttons[] = array("selection" => "narrative", "text" => "Narrative Search &amp; Replace", "href" => site_url("narrative/search"), "title" => "Search &amp; Replace Narrative Text");
	print create_button_bar($buttons, array("id" =>"navigation-buttons"));
	
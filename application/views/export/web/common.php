<?php
defined('BASEPATH') or exit('No direct script access allowed');
$extension = "csv";
// $extension = "tab";
// common.php Chris Dart Feb 17, 2015 4:22:01 PM chrisdart@cerebratorium.com
$filename = "common_web_" . date("Y-m-d_H-i-s") . "." . $extension;
$header = array(
        "common_id",
        "Common Name",
        "Category",
        "Genus",
        "Description",
        "sunlight_full",
        "sunlight_partial",
        "sunlight_shade"
);

if ($extension == "csv") {
    $output[] = implode(",", $header);
} else {
    $output[] = implode("\t", $header);
}

foreach ($commons as $common) {
    if (! strstr($common->subcategory, "Hanging")) {
        $line = array(
                $common->id,
                $common->name,
                $common->subcategory && ! strstr($common->subcategory, "General") ? sprintf("%s - %s", $common->category, $common->subcategory) : $common->category,
                $common->genus,
                str_replace("\"","&quot;",$common->description),
                strstr($common->sunlight, "full") ? "1" : "",
                strstr($common->sunlight, "part") ? "1" : "",
                strstr($common->sunlight, "shade") ? "1" : ""
        );
        if ($extension == "csv") {
            $output[] = "\"" . implode("\",\"", $line) . "\"";
            // $output[] = implode(",", $line);
        } else {
            $output[] = implode("\t", $line);
        }
    }
}

$data = implode("\n", $output);
force_download($filename, $data);
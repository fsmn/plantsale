<?php
defined('BASEPATH') or exit('No direct script access allowed');
$extension = "csv";
//$extension = "tab";
// common.php Chris Dart Feb 17, 2015 4:22:01 PM chrisdart@cerebratorium.com
$filename = "common_web_" . date("Y-m-d_H-i-s") . "." . $extension;
$header = array(
        "__kp_Primary_Key",
        "Common Name",
        "Category",
        "Genus",
        "Description",
        "Sun~Full Sun",
        "Sun~PartSunPartShade",
        "Sun~Shade"
);

if ($extension == "csv") {
    $output[] = implode(",", $header);
} else {
    $output[] = implode("\t", $header);
}

foreach ($commons as $common) {
    $line = array(
            $common->id,
            $common->name,
            $common->subcategory && ! strstr($common->subcategory, "General") ? sprintf("%s - %s", $common->category, $common->subcategory) : $common->category,
            $common->description,
            strstr($common->sunlight, "full") ? "+++" : "",
            strstr($common->sunlight, "part") ? "%%%" : "",
            strstr($common->sunlight, "shade") ? "///" : ""
    );
    if ($extension == "csv") {
        $output[] = "\"" . implode("\",\"", $line) . "\"";
        //$output[] =  implode(",", $line);
    } else {
        $output[] = implode("\t", $line);
    }
}

$data = implode("\n", $output);
force_download($filename, $data);
<?php defined('BASEPATH') OR exit('No direct script access allowed');

// export.php Chris Dart Jan 9, 2015 2:47:18 PM chrisdart@cerebratorium.com

$filename = "grower_totals-$year.csv";
//Define the fields desired for output in this array
$fields = array(
        "id" => "Grower ID",
        "grower_name" => "Grower Name",
        "street_address" => "Street",
        "po_box" => "PO Box",
        "city" => "City",
        "state" => "State",
        "zip" => "Postal Code",
        "country" => "Country",
        "total" => "Total",
        "email"=>"Main Email",
        "phone" =>"Main Phone",
        "fax" => "Main Fax",
        "shipping_name"=>"Shipping Contact",
        "shipping_phone1"=>"Shipping Phone 1",
        "shipping_phone2"=>"Shipping Phone 2",
        "shipping_email"=>"Shipping Email",
        "ordering_name"=>"Ordering Contact",
        "ordering_phone1"=>"Ordering Phone 1",
        "ordering_phone2"=>"Ordering Phone 2",
        "ordering_email"=>"Ordering Email",
);
foreach (array_values($fields) as $value) {
    $header_values[] = $value;
}

$output = array(
        implode(",", $header_values)
);
foreach ($growers as $grower) {
    foreach (array_keys($fields) as $key) {
        $line[] = $grower->$key;
    }
    $output[] = "\"" . implode("\",\"", $line) . "\"";
    $line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);
<?php
defined('BASEPATH') or exit('No direct script access allowed');

// varieties.php Chris Dart Feb 17"," 2015 2:57:55 PM chrisdart@cerebratorium.com



$filename = "varieties_web_" . date("Y-m-d_H-i-s"). ".csv";

$header = array(
        "_kf_Link_To_Common_Name",
        "_catalog_number",
        "__COLORS_ID",
        "Color",
        "Species",
        "ColorSearch",
        "Other Common Names",
        "Category Subcategory Export",
        "Item Notes",
        "Additional Item Description",
        "CurYr_Price",
        "Pot Size",
        "Web~Height_Min~inches",
        "Web~Height_Max~inches",
        "Web~Width_Min~inches",
        "Web~Width_Max~inches",
        "flagC~New Item Exp",
        "flag~Saturday exp",
        "flag~Birds_Insects Exp",
        "flag~Butterflies Exp",
        "flag~Cold_Sensitive Exp",
        "flag~Container Foliage Exp",
        "flag~CulinaryB Exp",
        "flag~EdibleB Exp",
        "flag~Ground Cover Exp",
        "flag~Hummingbirds Exp",
        "flag~MedicinalB Exp",
        "flag~Native Exp",
        "flag~Organic Exp",
        "flag~Poisonous Exp",
        "flag~Rock Garden Exp",
        "flag~US Native Exp"
);

$output[] = implode(",",$header);

foreach ($varieties as $variety) {
    $line = array(
            $variety->common_id,
            $variety->catalog_number,
            "P" . $variety->id,
            $variety->variety,
            $variety->species,
            str_replace(",", "\r", $variety->plant_color),
            $variety->other_names,
            $variety->subcategory && !strstr($variety->subcategory, "General") ? sprintf("%s-%s", $variety->category, $variety->subcategory) : $variety->category,
            $variety->print_description,
            $variety->web_description,
            $variety->price,
            $variety->pot_size,
            $variety->height_unit == "Feet" ? $variety->min_height * 12 : $variety->min_height,
            $variety->height_unit == "Feet" ? $variety->max_height * 12 : $variety->max_height,
            $variety->width_unit == "Feet" ? $variety->min_width * 12 : $variety->min_width,
            $variety->width_unit == "Feet" ? $variety->max_width * 12 : $variety->max_width,
            $variety->year = $variety->new_year ? 1 : 0,
            $variety->count_midsale > 0 ? 1 : 0,
            in_array("Birds", $variety->flags),
            in_array("Butterflies", $variety->flags),
            in_array("Cold Sensitive", $variety->flags),
            in_array("Interesting Foliage", $variety->flags),
            in_array("Culinary", $variety->flags),
            in_array("Edible Flowers", $variety->flags),
            in_array("Ground Cover", $variety->flags),
            in_array("Hummingbirds", $variety->flags),
            in_array("Medicinal", $variety->flags),
            in_array("Minnesota Native", $variety->flags),
            in_array("Organic", $variety->flags),
            in_array("Poisonous", $variety->flags),
            in_array("Rock Garden", $variety->flags),
            in_array("Bees", $variety->flags)
    );
    $output[] = "\"" . implode("\",\"", $line) . "\"";
}

$data = implode("\n", $output);
force_download($filename, $data);
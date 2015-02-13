<?php
defined('BASEPATH') or exit('No direct script access allowed');

// quark_helper.php Chris Dart Feb 9, 2015 4:34:51 PM
// chrisdart@cerebratorium.com
function format_sunlight ($sunlight, $format = "quark")
{
    $output = "";
    if ($format == "quark") {
        if (strstr($sunlight, "full")) {
            $output .= "Í";
        }
        if (strstr($sunlight, "part")) {
            $output .= "∏";
        }
        if (strstr($sunlight, "shade")) {
            $output .= "Ó";
        } else {
            if (strstr($sunlight, "full")) {
                $output .= "+++";
            }
            if (strstr($sunlight, "part")) {
                $output .= "%%%";
            }
            if (strstr($sunlight, "shade")) {
                $output .= "///";
            }
        }
        if ($format == "quark") {
            $output = sprintf("<f\"FSMPlantSaleIcons\">%s<f$>", $output);
        }
        return $output;
    }
}

/**
 * the rules for codes are baffling and require special knowledge,
 * but here we are with a crazy setup.
 * Someday we'll
 * clean this up.
 */
function format_flags ($flags, $format = "quark")
{
    $output = FALSE;
    foreach ($flags as $flag) {
        switch ($flag->name) {
            case "Bees":
                if ($format == "quark") {
                    $output .= "Ω";
                    // If(flag~Bee > "a";"Ω";"")
                } else {
                    $output = "Bee";
                }
                break;
            case "Butterflies":
                if ($format == "quark") {
                    $output .= "∫";
                } else {
                    $output .= "ButterB";
                }
                break;
            case "Cold Sensitive":
                if ($format == "quark") {
                    $output .= "†";
                } else {
                    $output .= "ColdB";
                }
                break;
            case "Culinary":
                if ($format == "quark") {
                    $output .= "Ç";
                } else {
                    $output .= "CulinaryB";
                }
                break;
            case "Edible Flowers":
                if ($format == "quark") {
                    $output .= "´";
                } else {
                    $output .= "EdibleB";
                }
                break;
            case "Ground Cover":
                if ($format == "quark") {
                    $output .= "˝";
                } else {
                    $output = "GroundB";
                }
                break;
            case "Hummingbirds":
                if ($format == "quark") {
                    $output .= "˙";
                } else {
                    $output .= "HummB";
                }
                break;
            case "Interesting Foliage":
                if ($format == "quark") {
                    $output .= "ç";
                } else {
                    $output .= "FoliageB";
                }
                break;
            case "Medicinal":
                if ($format == "quark") {
                    $output .= "Â";
                } else {
                    $output .= "MedicinalB";
                }
                break;
            case "Minnesota Native":
                if ($format == "quark") {
                    $output .= "˜";
                } else {
                    $output .= "NativeB";
                }
                break;
            case "Organic":
                if ($format == "quark") {
                    $output .= "Ø";
                } else {
                    $output .= "OrganicB";
                }
            case "Poisonous":
                if ($format == "quark") {
                    $output .= "¥";
                } else {
                    $output .= "PoisonousB";
                }
                break;
            case "Rock Garden":
                if ($format == "quark") {
                    $output .= "‰";
                } else {
                    $output .= "RockB";
                }
                break;
        }
    }
    if ($format == "quark") {
        if ($output) {
            $output = sprintf("<f\"FSMPlantSaleIcons\">%s<f$>", $output);
        }
    }
    return $output;
}

/**
 * Assume that the determination of new year is calculated elsewhere.
 */
function format_new ($format = "quark")
{
    if ($format == "quark") {
        $output = sprintf("<f\"FSMPlantSaleIcons\">%s<f$>", "◊");
    } else {
        $output = "Y";
    }

    return $output;
}

function format_saturday ($format = "quark")
{
    if ($format == "quark") {
        $output = sprintf("<f\"FSMPlantSaleIcons\">%s<f$>", "ß");
    } else {
        $output = "qqq";
    }
    return $output;
}

function format_quark_dimensions ($object)
{
    $output = array();
    if ($object->min_height || $object->max_height) {
        $output["height"] = format_dimensions($object->min_height, $object->max_height, $object->height_unit == "Inches" ? "”" : "’", "h");
    }
    if ($object->min_width || $object->max_width) {
        $output["width"] = format_dimensions($object->min_width, $object->max_width, $object->width_unit == "Inches" ? "”" : "’", "w");
    }
    return implode(" by ", $output);
}

function format_description ($description, $object, $format = FALSE)
{
    $output[] = $description;

    if ($object->print_description) {
        $output[] = $object->print_description;
    }
    if ($format == "web") {
        if ($object->web_description) {
            $output[] = $object->web_description;
        }
    }
    return implode(" ", $output);
}

function subcategory_order ($categories = array())
{
    if (! $categories) {
        $categories = array("Indoor Plants","Miniature Gardens","Succulents","General","Hanging Baskets");
    }
    $category_order = "CASE ";

    for ($i = 0; $i < count($categories); $i ++) {
        $my_category = $categories[$i];
        $x = $i + 1;
        $category_order .= "WHEN subcategory='$my_category' THEN $x ";
    }
    $category_order .= "END";
    return $category_order;
}

function quark_single ($common)
{
    $variety = $common->varieties[0];
    $output[] = sprintf("@Common Name:<@Number In-text>%s<@\$p>%s", $variety->catalog_number, $common->name);
    $output[] = $variety->count_midsale > 0 ? format_saturday("quark") : "";
    $output[] = $variety->new_year == get_current_year() ? format_new("quark") : "";
    $output[] = sprintf("<p>@Latin Name:%s", format_latin_name($common->genus, $variety->species));
    $output[] = sprintf("<$>'%s'<$>", $variety->variety);
    $output[] = sprintf("<p>@Copy:%s", format_description($common->description, $variety, "quark"));
    $output[] = format_quark_dimensions($variety);
    $output[] = sprintf(" %s", format_sunlight($common->sunlight, "quark"));
    $output[] = format_flags($variety->flags, "quark");
    $output[] = sprintf("<p>@Pot and Price Right:%s--%s", get_as_price($variety->price), $variety->pot_size);
    return implode("",$output);
}

function quark_multiple ($common)
{
    $output[] = sprintf("@Common Name:%s<p>@Latin Name:%s<p>@Copy:%s %s", $common->name, $common->genus, $common->description,
            format_sunlight($common->sunlight, "quark"));
    foreach ($common->varieties as $variety) {
        $output[] = sprintf("\r@Pot and Price:%s>--%s:", get_as_price($variety->price), $variety->pot_size);
        $output[] = sprintf("\r@Copy After Copy:<@Number In-text>%s<@\$p>", get_value($variety, "catalog_number"));
        $output[] = sprintf("%s @Latin Name:%s", $variety->variety, format_latin_name($common->genus, $variety->species));
        $output[] = $variety->new_year == get_current_year() ? format_new("quark") : "";
        $output[] = (get_value($variety, "count_midsale") > 0) ? format_saturday("quark") : "";
        $output[] = sprintf("--%s %s %s", $variety->print_description, format_quark_dimensions($variety), format_flags($variety->flags, "quark"));
    }
    return implode("", $output);
}

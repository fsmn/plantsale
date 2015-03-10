<?xml version="1.0" encoding="utf-8"?>
<rss
	version="2.0"
	xml:base="http://db.friendsschoolplantsale.com/variety/rss"
	xmlns:dc="http://purl.org/dc/elements/1.1/"> <channel>
<title>Variety Export</title>
<link>
http://db.friendsschoolplantsale.com/variety/rss
</link>
<description></description> <language>en</language>
    <?php foreach($varieties as $variety):?>
<item>
<title><?php echo $variety->variety;?></title>
<guid><?php echo $variety->id;?></guid> <image><?php echo base_url("files/$variety->id.jpg");?></image>
<link><?=site_url("variety/view/$variety->id");?></link>
<common_id><?php echo $variety->common_id;?></common_id> <catalog_number><?php echo $variety->catalog_number;?></catalog_number>
<variety><?php echo $variety->variety;?></variety> <species><?php echo $variety->species;?></species>
<plant_color><?php echo str_replace(",", "\r", $variety->plant_color);?></plant_color>
<other_names><?php echo $variety->other_names;?></other_names> <category><?php echo $variety->subcategory ? $variety->web_label : $variety->category; ?></category>,
<description><?php echo str_replace("'","&rsquo;",str_replace("\"","&quot;",$variety->print_description));?></description>
<web_description><?php echo str_replace("'","&rsquo;",str_replace("\"","&quot;",$variety->web_description));?></web_description>
<price><?php echo $variety->price;?></price> <pot_size><?php echo str_replace("'","&rsquo;",str_replace("\"","&quot;",$variety->pot_size));?></pot_size>
<min_height><?php echo $variety->height_unit == "Feet" ? $variety->min_height * 12 : $variety->min_height;?></min_height>
<max_height><?php echo $variety->height_unit == "Feet" ? $variety->max_height * 12 : $variety->max_height;?></max_height>
<min_width><?php echo $variety->width_unit == "Feet" ? $variety->min_width * 12 : $variety->min_width;?></min_width>
<max_width><?php echo $variety->width_unit == "Feet" ? $variety->max_width * 12 : $variety->max_width;?></max_width>
<new_year><?php echo $variety->year == $variety->new_year ? 1 : 0;?></new_year>
<saturday_delivery><?php echo $variety->count_midsale > 0 ? 1 : 0;?></saturday_delivery>
<birds><?php echo in_array("Birds", $variety->flags);?></birds> <butterflies><?php echo in_array("Butterflies", $variety->flags);?></butterflies>
<cold_sensitive><?php echo in_array("Cold Sensitive", $variety->flags);?></cold_sensitive>
<interesting_foliage><?php echo in_array("Interesting Foliage", $variety->flags);?></interesting_foliage>
<culinary><?php echo in_array("Culinary", $variety->flags);?></culinary>
<edible_flowers><?php echo in_array("Edible Flowers", $variety->flags);?></edible_flowers>
<ground_cover><?php echo in_array("Ground Cover", $variety->flags);?></ground_cover>
<hummingbirds><?php echo in_array("Hummingbirds", $variety->flags);?></hummingbirds>
<medicinal><?php echo in_array("Medicinal", $variety->flags);?></medicinal>
<native><?php echo in_array("Minnesota Native", $variety->flags);?></native>
<organic><?php echo in_array("Organic", $variety->flags);?></organic> <poisonous><?php echo in_array("Poisonous", $variety->flags);?></poisonous>
<rock_garden><?php echo in_array("Rock Garden", $variety->flags);?></rock_garden>
<bees><?php echo in_array("Bees", $variety->flags);?></bees> <category>
<pubDate><?php echo date("D, j  M Y H:i:s O");?></pubDate> <dc:creator>administrator</dc:creator>
</item>
 <?php endforeach;?>
  </channel>
 </rss>
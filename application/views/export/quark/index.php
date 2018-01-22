<?php  defined('BASEPATH') OR exit('No direct script access allowed');

$categories = "";
if($category && $subcategory){
	$categories = sprintf("%s-%s",$category,$subcategory);
}elseif($category){
	$categories = $category;
}
$filename = sprintf("quark-export_%s-%s.txt",$categories,date("Y-m-d-H-i-s"));
$output = array("<v8.1><e9>");
foreach($commons as $common){
	$data["common"]  = $common;
	if(count($common->varieties) > 1){
		$output[] = quark_multiple($common);
	}else{
		$output[] = quark_single($common);
	}


}

$quark = implode("\n\r", $output);
$this->load->helper('file');
write_file("./downloads/$filename",$quark);
//force_download($filename, $quark);?>

<p>You can download the file here:</p>
<p><a href="<?php echo base_url("/downloads/$filename");?>"><?php echo $filename;?></a></p>


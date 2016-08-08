<?php defined('BASEPATH') OR exit('No direct script access allowed');

// header.php Chris Dart Mar 2, 2015 2:48:19 PM chrisdart@cerebratorium.com
?>

<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class='search-parameters'>
	<? if (isset ( $options )) : ?>

		<? $keys = array_keys ( $options ); ?>
		<? $values = array_values ( $options ); ?>

		<ul>

		<? for($i = 0; $i < count ( $options ); $i ++):?>
       	<? if(is_array($values[$i])){
       		$values[$i] = implode(",",$values[$i]);
       	}?>
       	<? if($keys[$i] == "no_image"): ?>
       	<? if($values[$i] == 1 ): ?>
       	        	<li>
       	  <strong>Only Showing Varieties without Images</strong></li>
       	  <?else: ?>
       	  <?endif;?>
       	<? else:?>
       	<li>
       	<? echo ucwords(clean_string($keys [$i])); ?>:&nbsp;<strong><?=ucwords(clean_string($values [$i]));?></strong>
</li>
       <?	endif;?>

		<? endfor;?>
		</ul>
	<?  else : ?>
		<p>Showing All Varieties</p>
	<? endif; ?>
<p>
		<strong>Sort Order</strong>
	</p>
<? $sorting = $this->input->get("sorting"); ?>
<? $direction = $this->input->get("direction");?>
<ul>
<? for($i = 0; $i < count($sorting); $i++):?>
<li><? printf("%s, %s", ucwords($sorting[$i]), $direction[$i]); ?></li>
<? endfor; ?>
</ul>
<p>
Found Count: <strong><?=count($plants);?> Varieties</strong>
</p>
<?php 
/*This $action value allows the same interface to toggle
 *  between generic variety searches and the specialized copyedits search interface with less code. 
 */
$action = FALSE;
if($this->input->get("action")=="edits"){
	$action = "edits";
}
echo create_button_bar(array(array("text"=>"Refine Search","class"=>array("button","search","dialog","refine"),"href"=>site_url("variety/search?action=$action&refine=1"))));?>

	</div>
</fieldset>
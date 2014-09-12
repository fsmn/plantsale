<?php defined('BASEPATH') OR exit('No direct script access allowed');

$filename = "order_export.txt";
$header = "Grower ID\tYear\tCommon Name\tGenus\tSpecies\tVariety\tPot Size\tPresale Order\tMidsale Order\tFlat Size\tPot Count\tGrower Code\tCategory";

$output = array($header);
foreach($orders as $order){
	$line[] = $order->grower_id;
	$line[] = $order->year;
	$line[] = $order->name;
	$line[] = $order->genus;
	$line[] = $order->species;
	$line[] = $order->variety;
	$line[] = $order->pot_size;
	$line[] = $order->count_presale;
	$line[] = $order->count_midsale;
	$line[] = $order->flat_size;
	$line[] = ($order->count_presale + $order->count_midsale) * $order->flat_size;
	$line[] = $order->grower_code;
	$line[] = $order->category;
	$output[] = implode("\t", $line);
	$line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);
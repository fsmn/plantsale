<?php ?>

<h2><?php echo $title;?></h2>
<p>Click each button to download the data table. The critical tables for catastrophic recovery are common, contact, flag, grower, orders, variety, and user</p>


<?php
$exclude = array (
		'user_log',
		'user_sessions',
);
$critical = array (
		'common',
		'category',
		'flag',
		'grower',
		'orders',
		'variety',
		'image',
		'user',
		'subcategory' 
);
$buttons[] = array('selection'=>'all',
    'text'=>'Download All Critical Databases',
    'class'=>array('button','btn','export'),
    'style'=>'default',
    'href'=> site_url('backup/critical/'),
    'title'=>'Create a download of all critical tables',
    );
foreach ( $tables as $table ) :
	if (! in_array ( $table, $exclude )) {
		$class = array (
				'button',
				'btn',
				'export' 
		);
		$title = in_array ( $table, $critical ) ? '(CRITICAL)':'';
		
$buttons[] = array('selection' => 'all',
        'text' => sprintf('Download %s %s', ucfirst($table), $title),
        'class' => $class,
		'style'=>'default',
		'href' => site_url("backup/backup_table/$table"),
        'title' => 'Create a downloadable backup of the $table table');
	
}
 endforeach;
 
 echo create_button_bar($buttons, array('class'=>'vertical-list'));
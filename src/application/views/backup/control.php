<?php ?>

<h2><?php print $title; ?></h2>
<p>Click each button to download the data table. The critical tables for catastrophic recovery are common, contact,
    flag, grower, orders, variety, and user</p>
<p>Please note: running the complete backup may log some users out. It will not log out users who are currently making
    changes to the database. </p>


<?php
$exclude = [
    'common_archive',
];
$critical = [
    'common',
    'category',
    'flag',
    'grower',
    'orders',
    'variety',
    'image',
    'user',
    'subcategory'
];

$buttons[] = [
    'selection' => 'backup',
    'text' => 'Complete Backup',
    'class' => ['button', 'btn', 'export'],
    'style' => 'default',
    'href' => site_url('backup/full_backup'),
    'title' => 'Download a complete backup of every table in the database. This may force some users to log out.',
];

$buttons[] = [
    'selection' => 'all',
    'text' => 'Download All Critical Databases',
    'class' => ['button', 'btn', 'export'],
    'style' => 'default',
    'href' => site_url('backup/critical/'),
    'title' => 'Create a download of all critical tables',
];
foreach ($tables as $table) :
    if (!in_array($table, $exclude)) {
        $class = [
            'button',
            'btn',
            'export'
        ];
        $title = in_array($table, $critical) ? '(CRITICAL)' : '';

        $buttons[] = [
            'selection' => 'all',
            'text' => format_string('Download @table @title', [
                '@table' => $table,
                '@title' => $title,
            ]),
            'class' => $class,
            'style' => 'default',
            'href' => site_url('backup/backup_table/' . $table),
            'title' => 'Create a downloadable backup of the ' . $table . ' table'
        ];
    }
endforeach;

print create_button_bar($buttons, ['class' => 'vertical-list']);

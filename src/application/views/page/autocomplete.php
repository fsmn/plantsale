<?php defined('BASEPATH') or exit('No direct script access allowed');

$buttons[] = [
    'text' => 'Turn Autocomplete Off',
    'class' => [
        'link',
        'autocomplete-off'
    ],
    'style' => 'default'
];

print create_button_bar($buttons);

<?php
defined('BASEPATH') or exit('No direct script access allowed');

$buttons[] = [
        'selection' => 'index',
        'text' => 'Home',
        'class' => [
                'button'
        ],
        'style' => 'default',
        'href' => site_url(''),
        'title' => 'Home'
];

$buttons[] = [
        'selection' => 'variety',
        'type' => 'pass-through',
        'text' => '<input type="text" name="variety-search" id="variety-search-body" class="search-field variety-search" value="" placeholder="Quickly find plants here"/>'
];

$buttons[] = [
        'selection' => 'all',
        'text' => 'Common Search',
        'class' => [
                'button',
                'search',
                'dialog',
                'search-common-names',
        ],
        'style' => 'default',
        'href' => site_url('common/search'),
        'title' => 'Search among the common names'
];

$buttons[] = [
        'selection' => 'all',
        'text' => 'Variety Search',
        'class' => [
                'button',
                'search',
                'dialog',
                'search-varieties',
        ],
        'style' => 'search',
        'href' => site_url('variety/search'),
        'title' => 'Search among the varieties'
];

$buttons[] = [
        'selection' => 'order',
        'text' => 'Orders Search',
        'class' => [
                'button',
                'search',
                'dialog',
                'search-orders'
        ],
        'style' => 'search',
        'href' => site_url('order/search/'),
        'title' => 'Search Orders'
];

$buttons[] = [
        'selection' => 'grower',
        'text' => 'Grower Totals',
        'class' => ['button', 'grower-totals'],
        'href' => base_url('grower/totals'),
        'title' => 'Get Dollar Totals for All Growers for the current year',
        'style' => 'search',
];

print create_button_bar($buttons, [
        'id' => 'navigation-buttons'
]);

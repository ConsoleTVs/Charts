<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default settings for charts
    |--------------------------------------------------------------------------
    */

    'default'   => [
        'type'          => 'line',
        'library'       => 'google',
        'element_label' => 'Element',
        'title'         => 'My chart',
        'height'        => 400,
        'width'         => 500,
        'responsive'    => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Set to false if your app already includes jquery
    | or you wish to load it manually
    |--------------------------------------------------------------------------
    */

    'load_jquery'   => false,
];

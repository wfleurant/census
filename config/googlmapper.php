<?php

return [

    'enabled' => true,

    'key' => env('GOOGLE_API_KEY'),

    /* ISO 3166-1 code */
    'region' => 'US',
    'language' => 'en-us',

    /* User Custom Maps:
        Automatically add the logged in Google user to Googlmapper displayed map. */
    'user' => false,

    /* Location Marker:
        Automatically add a location marker to the provided location for a Googlmapper displayed map.*/
    'marker' => true,

    'center' => true,

    'zoom' => 8,

    /* Map Type:
        ROADMAP, SATELLITE, HYBRID, TERRAIN */
    'type' => 'ROADMAP',

    'ui' => true,

    /* Map Marker:
        Set the default Googlmapper map marker behavior */

    'markers' => [

        /* Marker Icon:
            Display a custom icon for markers. (Link to an image) */
        'icon' => '',

        /* Marker Animation:
            Display an animation effect for markers: NONE, DROP, BOUNCE */
        'animation' => 'NONE',
    ],

    /* Map Marker Cluster:
        Enable default Googlmapper map marker cluster. */
    'cluster' => false,
];

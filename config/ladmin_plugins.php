<?php

use DFSmania\LaradminLte\Tools\Plugins\ResourceType;

return [

    /*
    |--------------------------------------------------------------------------
    | Required Plugins
    |--------------------------------------------------------------------------
    |
    | This section defines the plugins that are essential for the proper
    | functioning of the AdminLTE template. These plugins are pre-configured
    | and should not be modified unless you have a thorough understanding of
    | their purpose and impact on the system.
    |
    | Proceed with caution when making changes to this configuration, as
    | altering these settings may lead to unexpected behavior or errors in
    | the AdminLTE interface.
    |
    */

    'Bootstrap5' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                'source' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js',
                'integrity' => 'sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],
    'FontAwesome' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css',
                'integrity' => 'sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],
    'GoogleFont' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://fonts.googleapis.com',
                'rel' => 'preconnect',
            ],
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://fonts.gstatic.com',
                'rel' => 'preconnect',
                'crossorigin' => true,
            ],
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap',
            ],
        ],
    ],
    'OverlayScrollbars' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css',
                'integrity' => 'sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=',
                'crossorigin' => 'anonymous',
            ],
            [
                'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js',
                'integrity' => 'sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],
    'Popper' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                'source' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js',
                'integrity' => 'sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Extra/Custom Plugins
    |--------------------------------------------------------------------------
    |
    | Here you can setup the set of additional or custom plugins that will be
    | used within the views of your admin panel. You can specify plugins here
    | to extend or customize the functionality of your application.
    |
    | For details you can look the online documentation here:
    | TBD
    |
    */

    'AnimateCss' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::POST_ADMINLTE_LINK,
                'source' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
            ],
        ],
    ],
];

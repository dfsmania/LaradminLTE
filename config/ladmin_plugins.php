<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Required Plugins
    |--------------------------------------------------------------------------
    |
    | This set of plugins is required by the AdminLTE template. So, don't make
    | any changes here unless you are really sure what you are doing.
    |
    */

    'Bootstrap5' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'pre-adminlte-script',
                'source' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js',
                'attr_integrity' => 'sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ',
                'attr_crossorigin' => 'anonymous',
            ],
        ],
    ],
    'FontAwesome' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'pre-adminlte-link',
                'source' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css',
                'attr_integrity' => 'sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=',
                'attr_crossorigin' => 'anonymous',
            ],
        ],
    ],
    'GoogleFont' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'pre-adminlte-link',
                'source' => 'https://fonts.googleapis.com',
                'attr_rel' => 'preconnect',
            ],
            [
                'type' => 'pre-adminlte-link',
                'source' => 'https://fonts.gstatic.com',
                'attr_rel' => 'preconnect',
                'attr_crossorigin' => true,
            ],
            [
                'type' => 'pre-adminlte-link',
                'source' => 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap',
            ],
        ],
    ],
    'OverlayScrollbars' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'pre-adminlte-link',
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css',
                'attr_integrity' => 'sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=',
                'attr_crossorigin' => 'anonymous',
            ],
            [
                'type' => 'pre-adminlte-script',
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js',
                'attr_integrity' => 'sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=',
                'attr_crossorigin' => 'anonymous',
            ],
        ],
    ],
    'Popper' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'pre-adminlte-script',
                'source' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js',
                'attr_integrity' => 'sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE',
                'attr_crossorigin' => 'anonymous',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Extra/Custom Plugins
    |--------------------------------------------------------------------------
    |
    | Here you can setup the set of extra or custom plugins that will be used
    | within the views of your Laralive-Admin panel.
    |
    | For details you can look the online documentation here:
    | TBD
    |
    */

    'AnimateCss' => [
        'always' => true,
        'resources' => [
            [
                'type' => 'post-adminlte-link',
                'source' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
            ],
        ],
    ],
];

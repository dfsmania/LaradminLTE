<?php

use DFSmania\LaradminLte\Tools\Plugins\ResourceType;

/*
|------------------------------------------------------------------------------
| LaradminLTE Plugins Configuration
|------------------------------------------------------------------------------
|
| This file defines the configuration for the plugins used in your admin panel,
| when not utilizing an asset bundler (like Vite). You can customize plugin
| loading order, resource types, and other settings to suit your needs.
|
| For more details, refer to the online documentation:
| TBD
|
*/
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
    | The order of the plugins is important, as some plugins depend on others
    | to function correctly. So, plugins are loaded in the specified order.
    |
    | Proceed with caution when making changes to this configuration, as
    | altering these settings may lead to unexpected behavior or errors in
    | the AdminLTE interface.
    |
    */

    // Popper.js is a library used to manage poppers in web applications.
    // It is required by Bootstrap 5 for tooltips and popovers.
    'Popper' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                'source' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js',
                'integrity' => 'sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],

    // Bootstrap 5 is a popular front-end framework for developing responsive
    // and mobile-first websites.
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

    // Bootstrap Icons is a set of icons designed to work with Bootstrap. This
    // is the icon set used by default in the AdminLTE template.
    'BootstrapIcons' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
                'integrity' => 'sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],

    // FontAwesome is a popular icon library that provides scalable vector
    // icons. This is an alternative icon set that you can use with the
    // AdminLTE template.
    'FontAwesomeIcons' => [
        'always' => false,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css',
                'integrity' => 'sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],

    // JsDeliver is a free CDN for open-source projects. It provides a way to
    // load CSS and JS files from a variety of sources. This is used to load
    // the font type used in the AdminLTE template from the CDN.
    'JsDeliverFont' => [
        'always' => true,
        'resources' => [
            [
                'type' => ResourceType::PRE_ADMINLTE_LINK,
                'source' => 'https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css',
                'integrity' => 'sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=',
                'crossorigin' => 'anonymous',
            ],
        ],
    ],

    // OverlayScrollbars is a plugin that provides a customizable scrollbar for
    // web applications. It is used in the AdminLTE template to enhance the
    // appearance and functionality of scrollbars.
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

    /*
    |--------------------------------------------------------------------------
    | Extra/Custom Plugins
    |--------------------------------------------------------------------------
    |
    | Here you can setup the set of additional or custom plugins that will be
    | used within the views of your admin panel. You can specify plugins here
    | to extend or customize the functionality of your application. Please,
    | note the plugins are loaded in the order they are defined here.
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

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
| https://dfsmania.github.io/LaradminLTE/sections/config/plugins.html
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
                'source' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js',
                'integrity' => 'sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK',
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
                'source' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
                'integrity' => 'sha256-pdY4ejLKO67E0CM2tbPtq1DJ3VGDVVdqAR6j3ZwdiE4=',
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
                'source' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css',
                'integrity' => 'sha256-dABdfBfUoC8vJUBOwGVdm8L9qlMWaHTIfXt+7GnZCIo=',
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
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.4/styles/overlayscrollbars.min.css',
                'integrity' => 'sha256-dVAS2stV/bK/jvzGpnud966U/YLpnFhwqpHNoKBRgYw=',
                'crossorigin' => 'anonymous',
            ],
            [
                'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                'source' => 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.4/browser/overlayscrollbars.browser.es6.min.js',
                'integrity' => 'sha256-SzG+hSSaDHMjdGPyEfl8WY0tQh+td14SLNy+02p5MTM=',
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

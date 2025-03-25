<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    |
    | Here you can setup the basic information of your admin panel. By default,
    | most of this information will appear in the footer section.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'basic' => [
        // The version of your admin panel.
        'version' => '1.0.0',

        // The name of the company that owns and develops the admin panel.
        'company' => 'Your Company Name',

        // The url site of the company that owns and develops the admin panel.
        'company_url' => 'https://your-company-website.com',

        // The year when the development of your admin panel started.
        'start_year' => 2024,
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here you can change the layout options of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'layout' => [
        // Whether to enable a fixed footer.
        'fixed_footer' => false,

        // Whether to enable a fixed navbar header.
        'fixed_navbar' => true,

        // Whether to enable a fixed sidebar.
        'fixed_sidebar' => true,

        // Whether to enable the right-to-left (RTL) layout.
        'rtl' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Navbar
    |--------------------------------------------------------------------------
    |
    | Here you can customize the top navbar section of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'navbar' => [
        // Specifies the Bootstrap theme for the navbar. Available options are
        // 'light' or 'dark'. Setting this to null will disable a specific theme
        // for the navbar, allowing it to inherit a global theme settings.
        'bootstrap_theme' => null,

        // The set of extra classes for the navbar, usually to setup its
        // background color and style.
        'classes' => ['bg-body'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here you can customize the sidebar section of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'sidebar' => [
        // Specifies the Bootstrap theme for the sidebar. Available options are
        // 'light' or 'dark'. Setting this to null will disable a specific theme
        // for the sidebar, allowing it to inherit a global theme settings.
        'bootstrap_theme' => 'dark',

        // The set of extra classes for the sidebar, usually to setup its
        // background color and style.
        'classes' => ['bg-body-secondary', 'shadow'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    |
    | Here you can customize the footer section of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'footer' => [
        // Specifies the Bootstrap theme for the footer. Available options are
        // 'light' or 'dark'. Setting this to null will disable a specific theme
        // for the footer, allowing it to inherit a global theme settings.
        'bootstrap_theme' => null,

        // The set of extra classes for the footer, usually to setup its
        // background color and style.
        'classes' => ['bg-body'],
    ],
];

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
    | Brand Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup the brand logo of your admin panel. By default, the
    | logo will appear in the top-left corner of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'logo' => [
        // The text displayed alongside the logo.
        'text' => 'AdminLTE',

        // The URL path to the logo image file.
        'image' => asset('vendor/laradmin/img/AdminLTELogo.png'),

        // The alternative text for the logo image, used for accessibility.
        'image_alt' => 'AdminLTE Logo',

        // The CSS classes applied to style the logo text.
        'text_classes' => ['fw-bold'],

        // The CSS classes applied to style the logo image.
        'image_classes' => ['rounded-circle', 'shadow', 'opacity-75'],
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

        // Specifies the Bootstrap theme for the entire layout. Available
        // options are 'light' or 'dark'.
        'bootstrap_theme' => 'light',
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
        // A list of additional CSS classes applied to the navbar, typically
        // used to configure its background color and styling.
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
        // for the sidebar, allowing it to inherit the global layout settings.
        'bootstrap_theme' => 'dark',

        // A list of additional CSS classes applied to the sidebar, typically
        // used to configure its background color and styling.
        'classes' => ['bg-body-secondary', 'shadow'],

        // Toggles the accordion navigation feature. When enabled, expanding a
        // sidebar menu will automatically collapse any other open menus.
        'accordion' => false,

        // Toggles the mini sidebar feature. When enabled, and it is manually
        // collapsed, the sidebar shrinks to a compact size displaying icons
        // only, instead of fully collapsing.
        'mini_sidebar' => true,

        // The Bootstrap breakpoint at which the sidebar automatically expands
        // or fully collapses. Valid options are: 'sm', 'md', 'lg', 'xl', 'xxl'.
        'expand_breakpoint' => 'lg',
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
        // A list of additional CSS classes applied to the footer, typically
        // used to configure its background color and styling.
        'classes' => ['bg-body'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Main Content
    |--------------------------------------------------------------------------
    |
    | Here you can customize the main content section of your admin panel.
    |
    | For more details you can look the online documentation here:
    | TBD
    |
    */

    'main_content' => [
        // A list of additional CSS classes applied to the main content,
        // typically used to configure its background color and styling.
        'classes' => ['bg-body-tertiary'],
    ],
];

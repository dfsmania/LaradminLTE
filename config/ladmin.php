<?php

/*
|------------------------------------------------------------------------------
| LaradminLTE Layout Configuration
|------------------------------------------------------------------------------
|
| This file contains the configuration settings for the layout of your admin
| panel. You can customize various aspects of the layout, including basic
| information, favicons, brand logo, multiple layout options, and more.
|
| For more details, refer to the online documentation:
| https://dfsmania.github.io/LaradminLTE/sections/config/layout.html
|
*/
return [

    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    |
    | Here you can setup the basic information of your admin panel. By default,
    | most of this information will appear in the footer section.
    |
    */

    'basic' => [
        // The name of the company that owns and develops the admin panel.
        'company' => 'Your Company Name',

        // The url site of the company that owns and develops the admin panel.
        'company_url' => 'https://your-company-website.com',

        // The year when the development of your admin panel started.
        'start_year' => 2024,

        // The version of your admin panel.
        'version' => '1.0.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Favicons
    |--------------------------------------------------------------------------
    |
    | Here you can configure the favicons markup for your admin panel. Favicons
    | are small icons displayed in browser tabs, bookmarks, and other areas.
    | They will be searched in the "favicons" folder within your configured
    | Laravel asset_url, typically located in the public directory.
    |
    */

    'favicons' => [
        // Determines whether to include comprehensive favicon markup to ensure
        // compatibility across various browsers and platforms. If disabled,
        // only the basic favicon markup will be included.
        'full_support' => true,

        // The primary color of your brand logo. Used for maskable icons on
        // iOS and Android Chrome when full support is enabled.
        'brand_logo_color' => '#000000',

        // The background color of your brand logo. Used for Microsoft
        // application tiles and Android Chrome address bar when full support
        // is enabled.
        'brand_background_color' => '#ffffff',

        // The list of PNG favicon sizes that are served by your server. These
        // sizes are used to generate the markup for the PNG favicons discovery
        // when full support is enabled.
        'png_sizes' => ['16x16', '32x32', '96x96'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Brand Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup the brand logo of your admin panel. By default, the
    | logo will appear in the top-left corner of your admin panel.
    |
    */

    'logo' => [
        // The URL path to the logo image file. Can be a relative path to the
        // public directory or an absolute URL.
        'image' => 'vendor/ladmin/img/LaradminLTE.png',

        // The alternative text for the logo image, used for accessibility.
        'image_alt' => 'LaradminLTE Logo',

        // The CSS classes applied to style the logo image.
        'image_classes' => ['rounded-circle', 'shadow'],

        // The text displayed alongside the logo.
        'text' => 'LaradminLTE',

        // The CSS classes applied to style the logo text.
        'text_classes' => ['fw-bold'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Icons
    |--------------------------------------------------------------------------
    |
    | Here you can setup the default icons used in your admin panel. By default,
    | this package works with Bootstrap Icons, but FontAwesome library is also
    | supported.
    |
    */

    'icons' => [
        'treeview_toggler' => 'bi bi-chevron-right',
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here you can change the layout options of your admin panel.
    |
    */

    'layout' => [
        // Specifies the Bootstrap theme for the entire layout. Available
        // options are 'light' or 'dark'.
        'bootstrap_theme' => 'light',

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
    */

    'sidebar' => [
        // Toggles the accordion navigation feature. When enabled, expanding a
        // sidebar menu will automatically collapse any other open menus.
        'accordion' => false,

        // Specifies the Bootstrap theme for the sidebar. Available options are
        // 'light' or 'dark'. Setting this to null will disable a specific theme
        // for the sidebar, allowing it to inherit the global layout settings.
        'bootstrap_theme' => 'dark',

        // A list of additional CSS classes applied to the sidebar, typically
        // used to configure its background color and styling.
        'classes' => ['bg-body-secondary', 'shadow'],

        // Determines if the sidebar should be collapsed by default when the
        // page loads. This is useful for creating a cleaner interface or
        // optimizing space on smaller screens.
        'default_collapsed' => false,

        // The Bootstrap breakpoint at which the sidebar automatically expands
        // or fully collapses. Valid options are: 'sm', 'md', 'lg', 'xl', 'xxl'.
        'expand_breakpoint' => 'lg',

        // Toggles the mini sidebar feature. When enabled, and it is manually
        // collapsed, the sidebar shrinks to a compact size displaying icons
        // only, instead of fully collapsing.
        'mini_sidebar' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    |
    | Here you can customize the footer section of your admin panel.
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
    */

    'main_content' => [
        // A list of additional CSS classes applied to the main content,
        // typically used to configure its background color and styling.
        'classes' => ['bg-body-tertiary'],
    ],
];

<?php

/*
|------------------------------------------------------------------------------
| LaradminLTE Authentication Scaffolding Configuration
|------------------------------------------------------------------------------
|
| This file defines the configuration for the authentication scaffolding of
| your admin panel. The authentication scaffolding uses Laravel Fortify package
| as the backend implementation. You can enable or disable the authentication
| scaffolding, its available features, and customize the appearance of the
| authentication pages.
|
| For more details, refer to the online documentation:
| https://dfsmania.github.io/LaradminLTE/sections/config/auth.html
|
*/
return [

    // Determines whether to completely enable or disable the authentication
    // scaffolding.
    'enabled' => true,

    // Defines the accent theme used for the authentication pages. You can set
    // this to any of the defined accent themes in the "accent_themes" section
    // of this configuration file to change the color scheme of various
    // elements on the authentication pages.
    'accent_theme' => 'default',

    // Defines the list of CSS classes applied to the authentication layout's
    // body tag, used to configure its background color and styling.
    'background_classes' => ['bg-body-secondary', 'bg-gradient'],

    // Defines the URL path to a background image for the authentication layout.
    // Can be a relative path to the public directory or an absolute URL. When
    // an image is set, background classes will be ignored, and the background
    // image will cover the entire body.
    'background_image' => null,

    // Defines the path where users will get redirected during authentication
    // or password reset when the operations are successful and the user is
    // authenticated.
    'home_path' => '/home',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can setup the logo displayed on the authentication pages.
    |
    */

    'logo' => [
        // The URL path to the logo image file. Can be a relative path to
        // the public directory or an absolute URL.
        'image' => '/vendor/ladmin/img/LaradminLTE-Auth.png',

        // The alternative text for the logo image, used for accessibility.
        'image_alt' => 'LaradminLTE Logo',

        // The CSS classes applied to style the logo image.
        'image_classes' => ['shadow-sm', 'me-1'],

        // The height of the authentication logo image.
        'image_height' => '55px',

        // The width of the authentication logo image.
        'image_width' => '55px',

        // The text displayed alongside the logo.
        'text' => 'LaradminLTE',

        // The CSS classes applied to style the logo text.
        'text_classes' => ['fw-bold', 'text-secondary'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Features
    |--------------------------------------------------------------------------
    |
    | Here you can setup the available features for the authentication
    | scaffolding.
    |
    */

    'features' => [
        // Enables the user registration feature, allowing new users to create
        // accounts.
        'registration' => true,

        // Enables the password reset feature, allowing users to reset their
        // passwords if they forget them. This feature requires you to properly
        // configure a mailing service in your application, by setting the
        // corresponding "MAIL_*" environment variables.
        'password_reset' => false,

        // Enables the email verification feature, requiring users to verify
        // their email addresses upon registration. This feature also requires
        // you to properly configure a mailing service in your application, by
        // setting the corresponding "MAIL_*" environment variables, to
        // implement the Illuminate\Contracts\Auth\MustVerifyEmail interface on
        // your User model, and to add the 'verified' middleware to routes that
        // should only be accessible to verified users.
        'email_verification' => false,

        // Enables the profile image feature, allowing users to upload and
        // manage their profile images. This feature requires you to include
        // the DFSmania\LaradminLte\Models\Concerns\HasProfileImage trait in
        // your User model, run the corresponding package migration to add the
        // profile_image_path column to your users table, and set up the proper
        // storage disk configuration for storing profile images.
        'profile_image' => false,

        // Enables the profile information update feature, allowing users to
        // update their profile information such as name and email address.
        'update_profile_information' => true,

        // Enables the password update feature, allowing users to update their
        // account passwords.
        'update_passwords' => true,

        // Enables the account deletion feature, allowing users to delete their
        // accounts permanently.
        // 'delete_accounts' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile Images Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can setup the configuration dedicated to profile images. Note
    | that the profile image feature must be enabled in order for these
    | settings to take effect.
    |
    */

    'profile_images' => [
        // The maximum allowed file size for profile image uploads (in
        // kilobytes).
        'max_size' => 2048,

        // The allowed MIME types for profile image uploads.
        'allowed_mime_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ],

        // The storage disk where profile images will be stored. This should
        // correspond to a disk defined in the "filesystems.php" configuration
        // file of your Laravel application.
        'storage_disk' => 'public',

        // The directory path within the storage disk where profile images
        // will be stored.
        'storage_path' => 'profile-images',

        // The default image mode to be used when a user has not uploaded a
        // profile image. Supported modes are:
        // - identicon: Uses Gravatar service with identicon mode based on
        //   user's email.
        // - robohash: Uses Gravatar service with robohash mode based on
        //   user's email.
        // - initials: Uses ui-avatars.com service to generate an image with
        //   the user's initials.
        'default_mode' => 'initials',
    ],

    /*
    |--------------------------------------------------------------------------
    | Accent Color Themes
    |--------------------------------------------------------------------------
    |
    | Here you can setup the available accent color themes for the auth pages.
    | You can create your own themes by adding new keys. The values of each key
    | are defined like this:
    | - background: CSS Bootstrap classes for the background of the auth pages.
    | - button, icon, link: Bootstrap color theme names for buttons, icons, and
    |   links (e.g., 'primary', 'secondary', 'success', etc.)
    |
    */

    'accent_themes' => [
        'default' => [
            'background' => 'bg-body-tertiary',
            'button' => 'secondary',
            'icon' => 'body-tertiary',
            'link' => 'secondary',
        ],
        'blue' => [
            'background' => 'bg-primary-subtle bg-gradient',
            'button' => 'primary',
            'icon' => 'primary',
            'link' => 'primary',
        ],
        'green' => [
            'background' => 'bg-success-subtle bg-gradient',
            'button' => 'success',
            'icon' => 'success',
            'link' => 'success',
        ],
        'red' => [
            'background' => 'bg-danger-subtle bg-gradient',
            'button' => 'danger',
            'icon' => 'danger',
            'link' => 'danger',
        ],
        'yellow' => [
            'background' => 'bg-warning-subtle bg-gradient',
            'button' => 'warning',
            'icon' => 'warning',
            'link' => 'warning',
        ],
        'skyblue' => [
            'background' => 'bg-info-subtle bg-gradient',
            'button' => 'info',
            'icon' => 'info',
            'link' => 'info',
        ],
        'gray' => [
            'background' => 'bg-secondary-subtle bg-gradient',
            'button' => 'secondary',
            'icon' => 'secondary',
            'link' => 'secondary',
        ],
        'black' => [
            'background' => 'bg-dark text-white bg-gradient',
            'button' => 'dark',
            'icon' => 'dark',
            'link' => 'dark',
        ],
    ],
];

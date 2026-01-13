# Authentication Scaffolding Configuration

These settings allow you to customize the appearance and features of the authentication scaffolding provided by *LaradminLte*. The authentication scaffolding is built on top of the [Laravel Fortify](https://laravel.com/docs/fortify) backend, which already includes routes and controllers for login, registration, password reset, and email verification features. *LaradminLte* uses Fortify's backend to provide a complete authentication solution with pre-built views that can be easily customized.

The authentication settings are managed in the `config/ladmin/auth.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## How to Use the Authentication Scaffolding

::: tip IMPORTANT: Users Migrations Required
To use the authentication scaffolding, you need to have the default Laravel's migrations for users already set up in your database. If this is not your case, then you can can install Laravel's default migrations by running: `php artisan migrate`.
:::

If you want to use the built-in authentication scaffolding, make sure to have it enabled in the `config/ladmin/auth.php` file, and at least setup the `home_path`. The `home_path` is the place where users will be redirected after login. Then protect your routes that requires authentication using the `auth` middleware:

::: code-group
```php [In config/ladmin/auth.php]
'enabled' => true,
'home_path' => /* Your home path here */,
```

```php [In routes/web.php]
Route::middleware(['auth'])->group(function () {
    // Add routes that require authentication here...
});
```
:::

Once you have done this, you can access the login page by navigating to `/login` in your application. Also, you will be redirected to the login page automatically when trying to access any protected route without being authenticated. In these cases, you should see a login form styled with the default *LaradminLte* theme:

![LaradminLTE Login Example](/images/login-example.png)

The authentication scaffolding offer additional features that can be enabled or disabled as needed. These features include *registration*, *password reset* and *email verification*. Also, the appearance of the authentication views can be customized by modifying the configuration file. All of these settings are explained in the next sections.

## How to Customize the User Image

By default, *LaradminLTE* uses [Gravatar](https://www.gravatar.com/) to display the user images in the navbar user menu based on their email addresses. However, you can customize the user image by defining a custom attribute in your `User` model.

If you want to use your own user images (stored locally, on S3, or generated dynamically), you can override the default behavior by implementing the `ladmin_image` [accessor](https://laravel.com/docs/eloquent-mutators#defining-an-accessor) on your `User` model. This accessor should return the `URL` of the user image to be displayed.

For example (and reference), assuming you store images locally in the `public/images/users` folder and you use the user `id` to name the image files, then you can define the `ladmin_image` accessor as follows:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /**
     * Get the user's image URL for LaradminLTE.
     */
    protected function ladminImage(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url("images/users/{$this->id}.jpg"),
        );
    }
}
```

::: warning WARNING: Just an Example
The previous example is provided solely to illustrate a potential use case. It is not production-ready code and may require additional logic, validation, error handling, and security considerations before use in a production environment. Please, just use it as a reference of what can be done.
:::

## Main Settings

The main settings for the authentication scaffolding are as follows:

### *enabled*:

- Type: `boolean`
- Example: `'enabled' => true`

This setting enables or fully disables the authentication scaffolding provided by *LaradminLte*. When set to `false`, all of the authentication views and routes will be disabled. When set to `true`, the authentication scaffolding will be available for use with a minimal setup of features: *login*, *logout* and *password confirmation*. All of the other features may be enabled or disabled individually as needed.

### *accent_theme*:

- Type: `string`
- Example: `'accent_theme' => 'blue'`

This setting defines the accent theme used for the authentication pages. You can set this to any of the defined themes in the [accent_themes](#accent-themes) section of the configuration file to change the color scheme of various elements on the authentication pages, such as buttons and links.

### *background_classes*:

- Type: `array<string>`
- Example: `'background_classes' => ['bg-body-secondary', 'bg-gradient']`

This setting allows you to define the CSS classes that will be applied to the `<body>` element of the authentication pages. You can use this to customize the background appearance of the authentication views.

### *background_image*:

- Type: `string|null`
- Example: `'background_image' => '/images/auth-background.jpg'` (*relative path to public folder*)
- Example: `'background_image' => 'https://picsum.photos/id/194/1280/720'` (*absolute URL*)

This setting allows you to specify a background image for the authentication pages. You can provide the URL or path to an image file, and it will be applied as the background of the authentication views. If set to `null`, no background image will be used, and the background color defined by the `background_classes` setting will be applied instead. When using a path, it should be relative to the `public` folder of your Laravel application.

### *home_path*:

- Type: `string`
- Example: `'home_path' => '/home'`

This setting defines the path where users will get redirected by default during authentication or password reset when the operations are successful and the user is authenticated.

## Authentication Logo

The `logo` configuration section allows you to set and customize the logo displayed on the authentication pages.

::: details Quick Example {open}
```php
'logo' => [
    'image' => '/vendor/ladmin/img/LaradminLTE-Auth.png',
    'image_alt' => 'LaradminLTE Logo',
    'image_classes' => ['shadow-sm', 'me-1'],
    'image_height' => '55px',
    'image_width' => '55px',
    'text' => 'LaradminLTE',
    'text_classes' => ['fw-bold', 'text-secondary'],
]
```
:::

### *image*:

- Type: `string`
- Example: `'image' => '/images/auth-logo.png'` (*relative path to public folder*)
- Example: `'image' => 'https://example.com/auth-logo.png'` (*absolute URL*)

This setting specifies the URL path to the logo image file. You can provide a relative path to the `public` directory of your Laravel application or an absolute URL.

### *image_alt*:

- Type: `string`
- Example: `'image_alt' => 'My Application Logo'`

This setting defines the alternative text for the logo image, which is used for accessibility purposes.

### *image_classes*:

- Type: `array<string>`
- Example: `'image_classes' => ['shadow-sm', 'me-1']`

This setting allows you to specify the CSS classes that will be applied to style the logo image.

### *image_height*:

- Type: `string`
- Example: `'image_height' => '55px'`

This setting defines the height of the authentication logo image.

### *image_width*:

- Type: `string`
- Example: `'image_width' => '55px'`

This setting defines the width of the authentication logo image.

### *text*:

- Type: `string`
- Example: `'text' => 'My Application'`

This setting specifies the text that will be displayed alongside the logo image.

### *text_classes*:

- Type: `array<string>`
- Example: `'text_classes' => ['fw-bold', 'text-secondary']`

This setting allows you to define the CSS classes that will be applied to style the logo text.

## Authentication Features

The authentication scaffolding includes several features that can be enabled or disabled individually. These features are managed in the `features` section of the `config/ladmin/auth.php` file.

::: details Quick Example {open}
```php
'features' => [
    'registration' => true,
    'password_reset' => true,
    'email_verification' => false,
]
```
:::


### *registration*:

- Type: `boolean`
- Example: `'registration' => true`

This setting enables or disables the user registration feature. When set to `true`, users will be able to create new accounts using the registration form. When set to `false`, the registration routes and views will be disabled, preventing new user registrations.

### *password_reset*:

- Type: `boolean`
- Example: `'password_reset' => true`

This setting enables or disables the password reset feature. When set to `true`, users will be able to reset their passwords if they forget them. This feature requires you to properly configure a mailing service in your Laravel application, by setting the corresponding `MAIL_*` environment variables. When set to `false`, the password reset routes and views will be disabled.

At next, an example of environment configuration using [Mailtrap](https://mailtrap.io/) is provided for your reference.

::: details Environment Configuration with Mailtrap {open}
```php
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=/* Your Mailtrap username */
MAIL_PASSWORD=/* Your Mailtrap password */
MAIL_FROM_ADDRESS=noreply@app_name.com
MAIL_FROM_NAME="${APP_NAME}"
```
:::

### *email_verification*:

- Type: `boolean`
- Example: `'email_verification' => true`

This setting enables or disables the email verification feature. When set to `true`, users will be required to verify their email addresses upon registration. This feature requires you to properly configure a mailing service in your Laravel application, by setting the corresponding `MAIL_*` environment variables, to implement the `Illuminate\Contracts\Auth\MustVerifyEmail` interface on your `User` model, and to add the `verified` middleware to routes that should only be accessible to verified users.

You can see [password_rest](#password-reset) for an example of environment configuration using [Mailtrap](https://mailtrap.io/). At next we provide an example of how to implement the `MustVerifyEmail` interface in the `User` model and how to protect routes using the `verified` middleware.


::: code-group
```php [In app/Models/User.php]
use Illuminate\Contracts\Auth\MustVerifyEmail;

// Just add the interface to the User model...
class User extends Authenticatable implements MustVerifyEmail
{
    // ...
}
```

```php [In routes/web.php]
Route::middleware(['auth', 'verified'])->group(function () {
    // Add routes that require authenticated and verified users here...
});
```
:::

## Accent Themes

The authentication scaffolding supports various accent themes that can be applied to the authentication pages. These themes change the color scheme of various elements on the pages, such as buttons and links. You can choose from the following predefined accent themes by setting the [accent_theme](#accent-theme) option in the `config/ladmin/auth.php` file: `default`, `blue`, `green`, `red`, `yellow`, `skyblue`, `gray`, and `black`.

You can customize or add new accent themes by modifying the `accent_themes` section of the configuration file. Each theme defines specific options for different elements on the authentication pages. You can add your own themes by following the structure of the existing ones. This structure includes the following options for each theme:

- **_background_**: CSS classes for the header background of the authentication pages.
- **_button_**: Bootstrap color class for buttons.
- **_icon_**: Bootstrap color class for icons.
- **_link_**: Bootstrap color class for links.

::: details Example of Custom Accent Theme {open}
```php
'my_theme' => [
    'background' => 'bg-primary text-light bg-gradient',
    'button' => 'dark',
    'icon' => 'secondary',
    'link' => 'dark',
]
```
:::

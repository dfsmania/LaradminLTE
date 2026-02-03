# Authentication Scaffolding Configuration

These settings allow you to customize the appearance and features of the authentication scaffolding provided by *LaradminLTE*. The authentication scaffolding is built on top of the [Laravel Fortify](https://laravel.com/docs/fortify) backend, which already includes routes and controllers for login, registration, password reset, and email verification features. *LaradminLTE* uses Fortify's backend to provide a complete authentication solution with pre-built views that can be easily customized.

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

Once you have done this, you can access the login page by navigating to `/login` in your application. Also, you will be redirected to the login page automatically when trying to access any protected route without being authenticated. In these cases, you should see a login form styled with the default *LaradminLTE* theme:

![LaradminLTE Login Example](/images/login-example.png)

The authentication scaffolding offer additional features that can be enabled or disabled as needed. These features include *registration*, *password reset* and *email verification*. Also, the appearance of the authentication views can be customized by modifying the configuration file. All of these settings are explained in the next sections.

## Main Settings

The main settings for the authentication scaffolding are as follows:

### *enabled*:

- Type: `boolean`
- Example: `'enabled' => true`

This setting enables or fully disables the authentication scaffolding provided by *LaradminLTE*. When set to `false`, all of the authentication views and routes will be disabled. When set to `true`, the authentication scaffolding will be available for use with a minimal setup of features: *login*, *logout* and *password confirmation*. All of the other features may be enabled or disabled individually as needed.

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
    'profile_image' => true,
    'update_profile_information' => true,
    'update_password' => true,
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

You can see [password_reset](#password-reset) for an example of environment configuration using [Mailtrap](https://mailtrap.io/). At next we provide an example of how to implement the `MustVerifyEmail` interface in the `User` model and how to protect routes using the `verified` middleware.


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

### *profile_image*:

- Type: `boolean`
- Example: `'profile_image' => true`

This setting enables or disables the profile image management feature on the user profile page. When set to `true`, users will be able to upload and display a profile image. When set to `false`, the profile image functionality will be disabled. This feature requires a few steps to be fully functional:

#### 1. Add `profile_image_path` Column to Users Table

Use the provided package migration to add the `profile_image_path` column to your `users` table. You can publish the migration file by running the following command:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="migrations"
```

Then, run the migrations to update your database schema:

```bash
php artisan migrate
```

#### 2. Use `DFSmania\LaradminLte\Models\Concerns\HasProfileImage` Trait

Include the `HasProfileImage` trait in your `User` model to add the necessary methods and relationships for handling profile images. For example:

```php
<?php
namespace App\Models;

use DFSmania\LaradminLte\Models\Concerns\HasProfileImage;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasProfileImage;

    // ...
}
```

#### 3. Setup Your Laravel Filesystem

This feature requires you to have the [Laravel Filesystem](https://laravel.com/docs/filesystem) properly configured in your application to handle file uploads. By default, the profile images are stored in the `public` disk, which is typically linked to the `storage/app/public` directory. Make sure to run `php artisan storage:link` to create a symbolic link from `public/storage` to `storage/app/public` if you haven't done so already.

#### 4. Customize Profile Image Settings (Optional)

You can customize the profile image settings in the `config/ladmin/auth.php` file under the `profile_images` section. This includes options such as the *storage disk*, *maximum file size*, *allowed file types*, and *default image mode* (i.e., the default image to use when a user has not uploaded a profile image). The default image uses external services like [UI Avatars](https://ui-avatars.com/) or [Gravatar](https://gravatar.com/) to generate placeholder images based on the user's name initials or the user's email. Details about these settings can be found in the [Profile Images Configuration](#profile-images) section.

### *update_profile_information*:

- Type: `boolean`
- Example: `'update_profile_information' => true`

This setting enables or disables the ability for users to update their profile information on the user profile page. When set to `true`, users will be able to edit and save changes to their profile details, such as name and email address. When set to `false`, the profile information update functionality will be disabled.

### *update_password*:

- Type: `boolean`
- Example: `'update_password' => true`

This setting enables or disables the ability for users to update their passwords on the user profile page. When set to `true`, users will be able to change their passwords. When set to `false`, the password update functionality will be disabled.

### Password Confirmation

The authentication scaffolding also includes password confirmation functionality, which is used to verify a user's identity before allowing access to sensitive actions or areas of the application. This feature is enabled by default and does not require any additional configuration.

When a user attempts to access a route that requires password confirmation, they will be prompted to enter their password again. This helps to ensure that the user is indeed the rightful owner of the account before proceeding with the sensitive action.

To protect routes with the password confirmation feature, you can use the `password.confirm` middleware of Laravel in your route definitions. For example:

```php
Route::middleware(['auth'])->group(function () {
    // Routes that require authentication...

    Route::middleware(['password.confirm'])->group(function () {
        // Add routes that require password confirmation here...
    });
});
```

Or by assingning the `password.confirm` middleware to specific routes:


```php
Route::middleware(['auth'])->group(function () {
    // Routes that require authentication...

    Route::get('/sensitive-action', function () {
        // Sensitive action that requires password confirmation...
    })->middleware('password.confirm');
});
```

## Profile Images

The `profile_images` configuration section allows you to customize the settings related to user profile images. These settings will only take effect if the [profile_image](#profile-image) feature is enabled in the `features` section of the `config/ladmin/auth.php` file.

::: details Quick Example {open}
```php
'profile_images' => [
    'max_size' => 1024,
    'allowed_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
    ],
    'storage_disk' => 'public',
    'storage_path' => 'profile-images',
    'default_mode' => 'initials',
]
```
:::

### *max_size*:

- Type: `integer`
- Example: `'max_size' => 2048`

This setting defines the maximum allowed file size for profile image uploads, in kilobytes.

### *allowed_mime_types*:

- Type: `array<string>`
- Example:`'allowed_mime_types' => ['image/jpeg', 'image/png', 'image/gif']`

This setting specifies the allowed *MIME types* for profile image uploads. You can add or remove *MIME types* as needed to control the types of images that users can upload.

### *storage_disk*:

- Type: `string`
- Example: `'storage_disk' => 'public'`

This setting defines the storage disk where profile images will be stored. This should correspond to a disk defined in the `filesystems.php` configuration file of your Laravel application.

### *storage_path*:

- Type: `string`
- Example: `'storage_path' => 'profile-images'`

This setting specifies the directory path within the storage disk where profile images will be stored.

### *default_mode*:

- Type: `string ('identicon'|'robohash'|'initials')`
- Example: `'default_mode' => 'initials'`

This setting defines the default image mode to be used when a user has not uploaded a profile image. Supported modes are:

- **identicon**: Uses `Gravatar` service with `identicon` mode based on user's email.
- **robohash**: Uses `Gravatar` service with `robohash` mode based on user's email.
- **initials**: Uses `ui-avatars.com` service to generate an image with the user's initials.

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

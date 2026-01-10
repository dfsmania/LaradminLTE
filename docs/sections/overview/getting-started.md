# Getting Started

::: danger CAUTION: Active Development
This documentation is a work in progress. The installation steps and usage instructions may change as the package evolves. Use them as a temporary guide for testing and exploring the current development state.
:::

## Requirements

- **Laravel**: 10 or higher
- **PHP**: 8.1 or higher

## Installation

Follow these steps to install **LaradminLTE** in your Laravel application:

### 1. Install the Package

Use [Composer](https://getcomposer.org/) to add the package to your Laravel project:

```bash
composer require dfsmania/laradminlte:dev-main --prefer-stable
```

### 2. Publish Required Package Resources

Run the following commands to publish the basic package's assets and configuration files:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="assets" --tag="config"
```

This command will publish the following elements to your application:

- **Assets**: The set of **AdminLTE v4** distribution files (`CSS`, `JS`) and some images in the `public/vendor/ladmin` folder of your Laravel application.
- **Config**: The package configuration files in the `config/ladmin` folder of your Laravel application.

### 3. Other Publishable Resources (Optional)

Additionally, you can also publish the translation files if you want to customize them or add new languages:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="translations"
```

Translation files will be published to the `resources/lang/vendor/ladmin` folder of your Laravel application.

## Usage

Follow these steps to use, configure and test **LaradminLTE** in your Laravel application:

### 1. Create a Test Route and View

Set up a test route in your `routes/web.php` file:

```php
Route::get('ladmin_welcome', function () {
    return view('laradminlte-welcome');
});
```

Next, create a Blade view to test the package's functionality. The package provides a main blade component that should be used to render the full admin layout.
As example, save the following content in `resources/views/laradminlte-welcome.blade.php`:

```blade
<x-ladmin-panel title="Welcome">

    {{-- Setup the content header --}}
    <x-slot name="contentHeader">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold">
                    <i class="bi bi-heart-fill text-danger"></i>
                    Welcome to LaradminLTE!
                </h3>
            </div>
        </div>
    </x-slot>

    {{-- Setup the content body --}}
    <div class="row">
        <div class="col-12">
            <i class="bi bi-rocket-takeoff-fill fs-5 text-primary"></i>
            Now, start building your next administration panel with ease and flexibility.
        </div>
    </div>

    {{-- Push inline scripts if needed --}}
    @push('js')
        <script>
            console.log('LaradminLTE is successfully loaded!');
        </script>
    @endpush

</x-ladmin-panel>
```

- The `title` attribute of the main component sets the page title, which is automatically appended to your application's name and shown in the browser's title bar.
- The `contentHeader` slot is used to define the header section of the content area.
- The content body is placed directly within the main component tags (as the default `slot` of the component).
- The `@push('js')` directive allows you to add custom JavaScript code that will be included in the layout.
- The `@push('css')` directive can also be used to add custom CSS styles if needed.

### 2. Enable the Authentication Scaffolding (Optional)

::: tip IMPORTANT: Users Migrations Required
To use the authentication scaffolding, you need to have the default Laravel's migrations for users already set up in your database. If this is not your case, then you can can install Laravel's default migrations by running: `php artisan migrate`.
:::

If you want to use the built-in authentication scaffolding, make sure to have it enabled in the `config/ladmin/auth.php` file, and setup the `home_path`. The `home_path` is the place where users will be redirected after login. Then protect your routes using the `auth` middleware:

```php
// config/ladmin/auth.php:
'enabled' => true,
'home_path' => '/ladmin_welcome',
```

```php
// routes/web.php:
Route::middleware(['auth'])->group(function () {
    Route::get('ladmin_welcome', function () {
        return view('laradminlte-welcome');
    });

    // Add other protected routes here...
});
```

After this, all the routes within this group will require authentication to be accessed.

### 3. Test your Route/View

To test the admin layout, open your browser and navigate to:

```sh
http://your-app.test/ladmin_welcome
```

Replace `your-app.test` with your local development URL. If authentication is enabled, a login screen will appear. Then, you should see the default admin layout rendered using the package’s out-of-the-box configuration:

![LaradminLTE Layout Example](/images/layout-example.png)

### 4. Customize Configuration

Explore and modify the package's configuration files to suit your needs:

- `config/ladmin/main.php`: General settings for the admin panel.
- `config/ladmin/menu.php`: Define the menu structure.
- `config/ladmin/plugins.php`: Manage plugins and extensions.
- `config/ladmin/auth.php`: Configure authentication scaffolding.

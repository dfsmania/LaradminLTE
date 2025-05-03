# LaradminLte: An AdminLTE v4 Integration for Laravel

LaradminLte is a package designed to integrate the [AdminLTE v4](https://adminlte-v4.netlify.app) administration dashboard template seamlessly into [Laravel](https://laravel.com/) (version 10 or higher). Currently in development, this package aims provides a quick and efficient way to set up an administration panel with advanced configuration options and a [Blade component](https://laravel.com/docs/blade#components) for rendering the layout.

> [!IMPORTANT]
> This package is in active development. So, features, configurations, and behavior are subject to significant changes until the first stable release.

## Requirements

- **Laravel**: 10.x or higher
- **PHP**: 8.1 or higher

## Installation and Setup

Follow these steps to install, configure, and test LaradminLte in your Laravel application:

### 1. Install the Package

Use [Composer](https://getcomposer.org/) to add the package to your Laravel project:

```bash
composer require dfsmania/laradminlte:dev-main --prefer-stable
```

### 2. Publish Package Resources

Run the following commands to publish the basic package's assets and configuration files:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="assets"
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

### 3. Create a Test Route and View

Set up a test route in your `routes/web.php` file:

```php
Route::get('laradminlte_test', function () {
    return view('laradminlte-test');
});
```

Next, create a Blade view to test the package's functionality.
Save the following content in `resources/views/laradminlte-test.blade.php`:

```blade
<x-ladmin-panel>

    {{-- Setup the content header --}}
    <x-slot name="contentHeader">
        <div class="row">
            <div class="col-12 fw-bold">
                CONTENT HEADER
            </div>
        </div>
    </x-slot>

    {{-- Setup the content body --}}
    <div class="row">
        <div class="col-12 fw-bold">
            CONTENT BODY
        </div>
    </div>

</x-ladmin-panel>
```

### 4. Customize Configuration

Explore and modify the package's configuration files to suit your needs:

- `config/ladmin.php`: General settings for the admin panel.
- `config/ladmin_menu.php`: Define the menu structure.
- `config/ladmin_plugins.php`: Manage plugins and extensions.

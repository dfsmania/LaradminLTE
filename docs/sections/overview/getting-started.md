# Getting Started

## Requirements

- **Laravel**: 10 or higher
- **PHP**: 8.1 or higher

## Installation and Setup

Follow these steps to install, configure, and test **LaradminLTE** in your Laravel application:

::: danger CAUTION: Active Development
This documentation is a work in progress. The installation steps and usage instructions may change as the package evolves. Use them as a temporary guide for testing and exploring the current development state.
:::

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

The published assets include the *AdminLTE v4* distribution files and image logos required for the package's layout and branding.

### 3. Create a Test Route and View

Set up a test route in your `routes/web.php` file:

```php
Route::get('ladmin_welcome', function () {
    return view('laradminlte-welcome');
});
```

Next, create a Blade view to test the package's functionality. The package provides a main blade component that should be used to render the layout.
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

</x-ladmin-panel>
```

The `title` attribute of the main component sets the page title, which is automatically appended to your application's name and shown in the browser's title bar.

Finally, to visualize the admin layout, open your browser and navigate to:

```sh
http://your-app.test/ladmin_welcome
```

Replace `your-app.test` with the URL of your local development environment. You should now see the default admin layout rendered using the package’s out-of-the-box configuration:

![LaradminLTE Layout Example](/images/layout-example.png)

### 4. Customize Configuration

Explore and modify the package's configuration files to suit your needs:

- `config/ladmin.php`: General settings for the admin panel.
- `config/ladmin_menu.php`: Define the menu structure.
- `config/ladmin_plugins.php`: Manage plugins and extensions.

# Getting Started

::: danger CAUTION: Active Development
This documentation is a work in progress. The installation steps and usage instructions may change as the package evolves. Use them as a temporary guide for testing and exploring the current development state.
:::

## Requirements

- **Laravel**: 11 or higher
- **PHP**: 8.2 or higher

## Installation

Follow these steps to install **LaradminLTE** in your Laravel application.

### 1. Install the Package

Use [Composer](https://getcomposer.org/) to add the package to your Laravel project:

```bash
composer require dfsmania/laradminlte:^1.0@beta
```

Alternatively, to install the latest development version:

```bash
composer require dfsmania/laradminlte:dev-main --prefer-stable
```

### 2. Install Package Resources

LaradminLTE provides an interactive installer to publish the package resources:

```bash
php artisan ladmin:install
```

The installer automatically publishes the **required resources**:

- **Assets:** AdminLTE v4 distribution files (`CSS`, `JS`) and images, published to `public/vendor/ladmin`.
- **Configuration:** LaradminLTE configuration files, published to `config/ladmin`.

During installation, you can also select **optional resources**:

- **Translations:** Translation files for customization and additional languages, published to `lang/vendor/ladmin`.
- **Migrations:** Database migrations supporting user profile images, published to `database/migrations`.

The installer detects previously published files and asks for confirmation before overwriting them, preserving existing customizations by default.

#### Installing Individual Resources

You can install or republish specific resources at any time using the `--resource` option:

```bash
php artisan ladmin:install --resource=translations
```

To install multiple resources, repeat the option:

```bash
php artisan ladmin:install --resource=translations --resource=migrations
```

For detailed information about available resources, installation options, and updating existing files, see the [Installation Guide](./installation.md).

#### Running Migrations

If you installed the optional **Migrations** resource, run:

```bash
php artisan migrate
```

These migrations add the necessary columns to the `users` table to support profile images. The installer does not execute database migrations automatically.

## Usage

Follow these steps to use, configure and test **LaradminLTE** in your Laravel application:

### 1. Create a Dedicated Route and View

Set up a route in your `routes/web.php` file, for example:

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

To test the admin panel, you first need to ensure that your *Laravel* application is running. You can start the development server using the following *Artisan* command:

```bash
php artisan serve
```

Then, just open your browser and navigate to:

```sh
http://your-app.test/ladmin_welcome
```

Replace `your-app.test` with your local development URL. If authentication is enabled, a login screen will appear. Then, you should see the default admin layout rendered using the package’s out-of-the-box configuration:

![LaradminLTE Layout Example](/images/layout-example.png)

Finally, to define your admin panel menu entries, you can edit the `config/ladmin/menu.php` file. This file allows you to customize the sidebar and navbar menu structure and items according to your application's needs. Remember that each new menu entry that renders a page should provide a blade view that extends the main layout component (`<x-ladmin-panel>`) to ensure the admin layout is applied correctly.

### 4. Customize Configuration

Explore and modify the package's configuration files to suit your needs:

- `config/ladmin/main.php`: General settings for the admin panel.
- `config/ladmin/menu.php`: Define the menu structure.
- `config/ladmin/plugins.php`: Manage plugins and extensions.
- `config/ladmin/auth.php`: Configure authentication scaffolding.

## Updating

To update **LaradminLTE** to the latest version, run:

```bash
composer update dfsmania/laradminlte
```

It's recommended to review the release notes before updating, as new versions may introduce breaking changes, new features, or changes to published resources.

### Updating Package Resources

After updating the package, you may need to republish certain resources to apply the latest changes.

For example, to update the AdminLTE v4 assets:

```bash
php artisan ladmin:install --resource=assets --force
```

You can also update configuration files or other resources using the same installation command.

::: warning CAUTION: Overwriting Existing Files
The `--force` option overwrites previously published files. Be particularly careful when updating configuration files or translations, as your customizations may be lost.
:::

For detailed instructions on updating individual resources, preserving customizations, and comparing configuration changes, see the [Installation Guide](./installation.md).

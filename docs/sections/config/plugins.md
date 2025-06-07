# Plugins Configuration

This section explains how to configure frontend plugins used in the Admin panel layout. Plugins such as `Bootstrap`, `FontAwesome`, and custom `CSS/JS` libraries can be registered to control how and when they are loaded.

These settings apply only when you are not using an **asset bundler** (like `Vite`). If you rely on a bundler, plugin assets should be imported via your build pipeline instead.

The plugins settings are managed in the `config/ladmin_plugins.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## Plugins Overview

Each plugin is registered under a unique name and consists of the following:

- The **always** flag, which determines if the plugin’s resources are loaded on every page or only when explicitly requested.

- A list of **resources** (`CSS` or `JS` files) to be included, each with customizable options.

- The **resource type**, specifying when the resource should be injected relative to the core `AdminLTE v4` assets (e.g., before or after core scripts/styles).

The default `config/ladmin_plugins.php` file comes pre-configured with a set of plugin definitions that are required for working with **Bootstrap 5** and the **AdminLTE v4** template. These examples provide a solid starting point and can be used as templates when adding or customizing plugins to suit your project's needs. Review and adjust these definitions as necessary to integrate additional frontend libraries or modify existing ones.

::: details Quick Example {open}

In this example the **Bootstrap 5** resource file will be included before the **AdminLTE 4 core** script file.

```php
'Bootstrap5' => [
    'always' => true,
    'resources' => [
        [
            'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
            'source' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js',
            'integrity' => 'sha384-...hash...',
            'crossorigin' => 'anonymous',
        ],
    ],
],
```
:::

Please, note plugins are included in your layout in the exact order they are defined within the `config/ladmin_plugins.php` file. This means that dependencies between plugins, such as loading `jQuery` before a plugin that requires it, are respected only if you register them in the correct sequence. Review and arrange your plugin definitions carefully to ensure that all required assets are loaded in the proper order for your application to function as expected.

::: tip TIP: Conditional Plugin Loading
To include a plugin only on certain pages, set its `always` property to `false` in the configuration. Then, you can use the custom `@ladmin_plugin('PluginName')` Blade directive on any view where you want the plugin loaded. For details, refer to the [Conditional Plugin Loading](#conditional-plugin-loading) section.
:::

## Plugin Definition

Before customizing or adding new plugins, it's important to understand the structure of a plugin definition. Each plugin entry in the configuration file specifies how and when its resources are loaded, allowing you to tailor the Admin panel's frontend assets to your needs.

### Plugin Settings

Below is a quick overview of the available plugin settings and how to configure them in your project.

| Property  | Type      | Required | Description                                                                                                              |
|-----------|-----------|----------|--------------------------------------------------------------------------------------------------------------------------|
| always    | `boolean` | No       | If `true`, plugin resources are included on every page using the layout. If `false`, load it with `@ladmin_plugin(...)`. |
| resources | `array`   | **Yes**  | List of `CSS` or `JS` resources to load. See [Resource Definition](#resource-definition) below.                          |

### Resource Definition

Each plugin defines one or more resources, which are the external or local `CSS` and `JS` files that should be loaded as part of the plugin. Resources specify the file location, type (`CSS` or `JS`), and how and when they are injected into the page. This flexible structure allows you to precisely control the inclusion and order of frontend assets for each plugin.

| Property | Type           | Required | Description                                                              |
|----------|----------------|----------|--------------------------------------------------------------------------|
| source   | `string`       | **Yes**  | The URL or asset path to the resource (`JS` or `CSS`).                   |
| type     | `ResourceType` | **Yes**  | The load type (e.g., `PRE_ADMINLTE_SCRIPT`, `POST_ADMINLTE_LINK`).       |
| asset    | `boolean`      | No       | If `true`, the resource will be loaded using Laravel's `asset()` helper. |

::: warning IMPORTANT: Using the `asset` Property
When setting the `asset` property to `true` for a plugin resource, make sure the referenced file exists within your Laravel application's `public` directory (such as `public/plugins/your-plugin/`) or is accessible via the path defined in your `ASSET_URL` environment variable. The `asset()` helper generates `URLs` relative to this location. If the file is missing or not publicly accessible, the browser will not be able to load the resource, which may cause your plugin to malfunction.
:::

### Resource Types

Resource types determine the injection point in the layout. These are defined by the next enum:

```php
DFSmania\LaradminLte\Tools\Plugins\ResourceType
```

| Constant               | Description                      |
|------------------------|----------------------------------|
| `PRE_ADMINLTE_LINK`    | Load link before AdminLTE CSS.   |
| `POST_ADMINLTE_LINK`   | Load link after AdminLTE CSS.    |
| `PRE_ADMINLTE_SCRIPT`  | Load script before AdminLTE JS.  |
| `POST_ADMINLTE_SCRIPT` | Load script after AdminLTE JS.   |

Choose the appropriate resource type based on whether your asset needs to be loaded before or after the core **AdminLTE** styles or scripts.

## Conditional Plugin Loading

To load a plugin only on specific views, set its `always` property to `false` in the `config/ladmin_plugins.php` file. Then, include the plugin in any Blade view where it is needed using the custom directive:

```blade
@ladmin_plugin('PluginName')
```

This directive signals the layout to inject the plugin’s resources for that particular page, ensuring assets are loaded only when required. This approach helps optimize page performance by avoiding unnecessary asset loading on pages that do not use the plugin.

## Adding Extra Properties

Each plugin resource supports a set of standard properties, but you can also add custom properties to further tailor how resources are included in your layout. These extra properties are rendered as `HTML` attributes on the corresponding `<link>` or `<script>` tag, enabling advanced customization such as adding `integrity`, `crossorigin`, or custom data attributes.

For example, you might want to add `integrity`, `crossorigin`, and `defer` attributes to an external-loaded script:
```php
[
    // Standard properties for a plugin resource...
    'type' => ResourceType::POST_ADMINLTE_SCRIPT,
    'source' => 'https://code.jquery.com/jquery-3.7.1.min.js',

    // Extra custom properties...
    'integrity' => 'sha256-...',
    'crossorigin' => 'anonymous',
    'defer' => 'true',
]
```

When rendered in the layout, this resource could produce the following `HTML`:

```html
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-..."
    crossorigin="anonymous"
    defer="true"></script>
```

This approach allows you to extend the functionality and security of your plugin resources without modifying the core configuration structure. Use extra properties to add security attributes, enable CORS, or integrate with other frontend tools as needed.

## Managing Icon Libraries

Both **Bootstrap Icons** and **FontAwesome** are pre-configured as plugins in the default `config/ladmin_plugins.php` file. You can easily switch between them or use both, depending on your project's requirements.

### How to Use a Specific Icon Set

By default, both icon libraries are available and supported, but only the resources for plugins with `'always' => true` will be loaded on every page. To control which icon set is included:

- **_Enable Bootstrap Icons:_**
    Set `'always' => true` for the `BootstrapIcons` plugin and `'always' => false` for `FontAwesome` in the config file.

- **_Enable FontAwesome Icons:_**
    Set `'always' => true` for the `FontAwesome` plugin and `'always' => false` for `BootstrapIcons`.

- **_Use Both:_**
    Set `'always' => true` for both plugins if you want both icon sets available globally.

- **_Load Conditionally:_**
    Set `'always' => false` for either or both plugins, and use the `@ladmin_plugin()` Blade directive in specific views to load the desired icon set only where needed.

::: details Example Configuration {open}
```php
'BootstrapIcons' => [
    'always' => true, // or false
    'resources' => [
        [
            'type' => ResourceType::PRE_ADMINLTE_LINK,
            'source' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
            'integrity' => 'sha256-...',
            'crossorigin' => 'anonymous',
        ],
    ],
],
'FontAwesomeIcons' => [
    'always' => false, // or true
    'resources' => [
        [
            'type' => ResourceType::PRE_ADMINLTE_LINK,
            'source' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css',
            'integrity' => 'sha256-...',
            'crossorigin' => 'anonymous',
        ],
    ],
],
```
:::

### Usage of Icon Set

Once the desired icon set is loaded, you can use their respective classes in your Blade templates or when defining menu entries in your configuration files.

#### **Using Icons in Blade Templates**

- *Bootstrap Icons:*
    ```html
    <i class="bi bi-alarm"></i>
    ```

- *FontAwesome:*
    ```html
    <i class="fa-solid fa-bell"></i>
    ```

#### **Using Icons in Menu Definitions**

When defining menu items (for example, in your `config/ladmin_menu.php`), specify the icon class in the `icon` property:

- *Bootstrap Icons:*
    ```php
    [
        'text' => 'Alarms',
        'url' => '/alarms',
        'icon' => 'bi bi-alarm',
    ],
    ```

- *FontAwesome:*
    ```php
    [
        'text' => 'Notifications',
        'url' => '/notifications',
        'icon' => 'fa-solid fa-bell',
    ],
    ```

The menu system will automatically render the appropriate `<i>` tag with the provided class, ensuring your chosen icon set appears correctly in the sidebar or navigation. This approach allows you to seamlessly integrate and switch between icon libraries throughout your application, both in your views and navigation menus.

::: info INFO: Using Other Icon Sets
You can integrate additional icon libraries just like *Bootstrap Icons* or *FontAwesome Icons*. To do this, register the icon set as a plugin in your `config/ladmin_plugins.php` file and ensure its resources are loaded as needed. For menu items, any icon library will work as long as it uses `CSS` classes applied to `<i>` tags. After registering the plugin, simply use the correct syntax in your Blade templates to display icons from your chosen library.
:::

## Best Practices

- Keep required core plugins like `Bootstrap`, `Popper`, and `OverlayScrollbars` set to `'always' => true`.

- Use `@ladmin_plugin(...)` for additional plugins like `Chart.js`, or custom scripts that are used only on specific pages.

- Avoid mixing **bundler-managed resources** with this configuration unless clearly isolated.

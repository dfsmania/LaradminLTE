# Menu Configuration

This configuration defines the static menu structure of your admin panel. You can use it to declare your `navbar` and `sidebar` menu items.

The menu settings are managed in the `config/ladmin_menu.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## Menu Items

Menu items define the links, headers, dividers, and interactive elements that appear in your admin panel's navigation. Each item is configured as an array with specific properties, allowing you to customize its appearance and behavior. Understanding the available item types and their options helps you build a clear and user-friendly menu structure.

Here is an example of how to define a simple link menu item in your `config/ladmin_menu.php` file:

::: details Example: Defining a Link Menu Item {open}
```php
[
    'type' => MenuItemType::LINK,
    'label' => 'Dashboard',
    'url' => 'dashboard',
    'icon' => 'bi bi-speedometer',
]
```
:::

### Menu Placement

Menu items are grouped by placement using the next enum:

```php
DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement
```

- `MenuPlacement::NAVBAR`: Items for the top navigation bar.
- `MenuPlacement::SIDEBAR`: Items for the side menu panel.

So, your `config/ladmin_menu.php` file should follow this structure:

#### Example: `config/ladmin_menu.php`

```php
<?php

use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;

return [
    MenuPlacement::NAVBAR->value => [
        // Define NAVBAR menu items here...
    ],

    MenuPlacement::SIDEBAR->value => [
        // Define SIDEBAR menu items here...
    ],
];
```

This layout organizes your menu items by their placement, making it easy to manage both the navbar and sidebar menus.

### Menu Item Types

Each menu item must specify a type, defined by the following enum:

```php
DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType
```

The currently available menu item types are:

- `MenuItemType::DIVIDER`: A divider to separate menu sections.
- `MenuItemType::FULLSCREEN_TOGGLER`: A special fullscreen toggle button (navbar only).
- `MenuItemType::HEADER`: A non-clickable heading to visually group related items.
- `MenuItemType::LINK`: A navigational link to a route or URL.
- `MenuItemType::MENU`: A nested menu containing a list of submenu items.

The following sections provide detailed information about the available properties for each menu item type, including usage examples and configuration options.

## MenuItemType::DIVIDER

The `DIVIDER` type inserts a visual separator between menu items, helping to organize and group related links. In the `SIDEBAR`, it appears as a horizontal line; in the `NAVBAR`, it renders as a vertical line. Dividers improve menu clarity, especially in complex navigation structures.

### Accepted Properties

| Property   | Type                    | Description                                                                 |
|------------|-------------------------|-----------------------------------------------------------------------------|
| type       | `MenuItemType::DIVIDER` | (**Required**) Identifies the item as a divider.                            |
| color      | `string`                | (Optional) Bootstrap contextual color (e.g., `primary`, `secondary`).       |
| position   | `'left' or 'right'`     | (Optional) For `NAVBAR` only: places the divider on the left or right side. |
| is_allowed | `callable`              | (Optional) Closure to conditionally display the divider.                    |

### Example

This example shows how you could add a colored divider to the right section of the `NAVBAR`:

```php
[
    'type' => MenuItemType::DIVIDER,
    'color' => 'primary',
    'position' => 'right',
]
```

## Adding Extra Properties

Each menu item type supports a set of standard properties, but you can also add custom properties to further tailor your menu items. These extra properties are included as `HTML` attributes on the rendered menu element, enabling advanced customization such as adding data attributes, custom classes, or ARIA labels.

For example, you might want to add a custom data attribute and a `CSS` class to a menu link:

```php
[
    // Standard Properties for a link...
    'type' => MenuItemType::LINK,
    'label' => 'Reports',
    'url' => 'reports',
    'icon' => 'bi bi-bar-chart',

    // Extra custom properties...
    'data-section' => 'analytics',
    'class' => 'highlighted-link',
    'aria-label' => 'View Reports',
]
```

When rendered on the layout, this menu item could produce the following `HTML`:

```html
<li class="nav-item">
    <a href="{app_url}/reports"
        class="{base_link_classes} highlighted-link"
        data-section="analytics"
        aria-label="View Reports">
        <i class="nav-icon bi bi-bar-chart"></i>
        <p>Reports</p>
    </a>
</li>
```

This approach allows you to extend the functionality and accessibility of your menu items without modifying the core configuration structure. Use extra properties to integrate with JavaScript, apply custom styles, or enhance accessibility as needed.

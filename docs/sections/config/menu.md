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

## DIVIDER

The `DIVIDER` type inserts a visual separator between menu items, helping to organize and group related links. In the `SIDEBAR`, it appears as a horizontal line; in the `NAVBAR`, it renders as a vertical line. Dividers improve menu clarity, especially in complex navigation structures.

### Accepted Properties

| Property   | Type                    | Description                                                           |
|------------|-------------------------|-----------------------------------------------------------------------|
| type       | `MenuItemType::DIVIDER` | (**Required**) Identifies the item as a divider.                      |
| color      | `string`                | (Optional) Bootstrap contextual color (e.g., `primary`, `secondary`). |
| position   | `'left' or 'right'`     | (Optional) Determines placement in the `NAVBAR`.                      |
| is_allowed | `callable`              | (Optional) Closure to conditionally display the divider.              |

### Example

This example shows how you could add a colored divider to the right section of the `NAVBAR`:

```php
[
    'type' => MenuItemType::DIVIDER,
    'color' => 'primary',
    'position' => 'right',
]
```

## FULLSCREEN_TOGGLER

The `FULLSCREEN_TOGGLER` type inserts a special menu item that toggles the browser’s fullscreen mode. It is only supported in the `NAVBAR` and provides visual feedback by switching icons when entering or exiting fullscreen.

This item is useful for enhancing the user experience in data-dense admin interfaces by allowing users to focus on the content without UI distractions.

### Accepted Properties

| Property      | Type                              | Description                                                     |
|---------------|-----------------------------------|-----------------------------------------------------------------|
| type          | `MenuItemType::FULLSCREEN_TOGGLER`| (**Required**) Identifies the item as a fullscreen toggler.     |
| icon_expand   | `string`                          | (**Required**) Icon shown when fullscreen mode is not active.   |
| icon_collapse | `string`                          | (**Required**) Icon shown when fullscreen mode is active.       |
| color         | `string`                          | (Optional) Bootstrap contextual color (e.g., `info`, `danger`). |
| position      | `'left' or 'right'`               | (Optional) Determines placement in the `NAVBAR`.                |
| is_allowed    | `callable`                        | (Optional) Closure to conditionally display the toggler.        |

### Example

This example shows how you could add a fullscreen toggler to the right section of the `NAVBAR`:

```php
[
    'type' => MenuItemType::FULLSCREEN_TOGGLER,
    'icon_expand' => 'bi bi-fullscreen',
    'icon_collapse' => 'bi bi-fullscreen-exit',
    'position' => 'right',
]
```

## HEADER

The `HEADER` type creates a non-interactive label within your menu, helping to visually organize and separate groups of related items. Headers can be enhanced with icons, contextual colors, and custom `CSS` classes for improved clarity and branding.

You can use headers in the `SIDEBAR` to categorize menu sections, or in the `NAVBAR` to display prominent labels. This improves navigation by making complex menus easier to scan and understand.

### Accepted Properties

| Property   | Type                    | Description                                                      |
|------------|-------------------------|------------------------------------------------------------------|
| type       | `MenuItemType::HEADER`  | (**Required**) Identifies the item as a header.                  |
| label      | `string`                | (**Required**) Text to display as the section header.            |
| icon       | `string`                | (Optional) Icon to display alongside the label.                  |
| color      | `string`                | (Optional) Bootstrap contextual color (e.g., `success`, `info`). |
| position   | `'left' or 'right'`     | (Optional) Determines placement in the `NAVBAR`.                 |
| is_allowed | `callable`              | (Optional) Closure to conditionally display the header.          |

### Example

This example shows how to add a styled header with an icon and color, positioned somewhere in the `SIDEBAR`:

```php
[
    'type' => MenuItemType::HEADER,
    'label' => 'Account Management',
    'icon' => 'bi bi-person-fill-gear',
    'color' => 'primary',
]
```

## LINK

The `LINK` type defines a clickable navigation item that routes the user to a specific `URL` or `named route`. It can be displayed in both the `SIDEBAR` and `NAVBAR`, and supports rich visual customization such as icons, badges, and colors.

Links are the most commonly used menu items, ideal for directing users to different parts of your application.

### Accepted Properties

| Property      | Type                         | Description                                                                              |
|---------------|------------------------------|------------------------------------------------------------------------------------------|
| type          | `MenuItemType::LINK`         | (**Required**) Identifies the item as a standard link.                                   |
| label         | `string`                     | (**Required** if no icon) Text to display for the link.                                  |
| icon          | `string`                     | (Optional) Icon to display alongside the label.                                          |
| color         | `string`                     | (Optional) Bootstrap contextual color for the link (e.g., `warning`, `info`).            |
| url           | `string`                     | (**Required** if no route) Target `URL` for the link.                                    |
| route         | `array`                      | (Optional) Named route definition (e.g., `['home']`).                                    |
| badge         | `string`                     | (Optional) Small text badge (e.g., notification count).                                  |
| badge_color   | `string`                     | (Optional) Bootstrap badge color (e.g., `danger`, `success`).                            |
| badge_classes | `string`                     | (Optional) Additional `CSS` classes for styling the badge.                               |
| position      | `'left' or 'right'`          | (Optional) Determines placement in the `NAVBAR`.                                         |
| is_active     | `callable or ActiveStrategy` | (Optional) Closure or custom `ActiveStrategy` to control when the link is marked active. |
| is_allowed    | `callable`                   | (Optional) Closure to conditionally display the link.                                    |

::: info INFO: Usage Notes
- Each link item must have at least an **icon** or a **label**.
- You can specify the link destination using either the `route` or `url` property, but **not both at the same time**.
- Use the `is_active` property to customize when a link is marked as active. By default, a link is active if its `url` or `route` matches the current request.
:::

### Example

This example defines a sidebar link with an icon, badge, and route:

```php
[
    'type' => MenuItemType::LINK,
    'label' => 'Notifications',
    'icon' => 'bi bi-bell-fill',
    'route' => ['notifications'],
    'badge' => '3',
    'badge_color' => 'info',
]
```

## MENU

The `MENU` type defines a menu item that contains a list of child items. It behaves slightly different depending on its location:

- `SIDEBAR`: Renders as a **treeview menu** that can be deeply nested. Suitable for grouping multiple related links.

- `NAVBAR`: Renders as a **dropdown menu**. Only a single level of child items is allowed (no nested submenus).

This item type enhances navigational structure by organizing related links into expandable/collapsible groups.

### Accepted Properties

#### Shared

These are the set of properties shared for `SIDEBAR` and `NAVBAR` menus:

| Property   | Type                  | Description                                                      |
|------------|-----------------------|------------------------------------------------------------------|
| type       | `MenuItemType::MENU`  | (**Required**) Identifies the item as a menu container.          |
| label      | `string`              | (**Required** in sidebar, or when no icon in navbar) Text label. |
| icon       | `string`              | (Optional) Icon to display alongside the label.                  |
| color      | `string`              | (Optional) Bootstrap contextual color for the parent item.       |
| is_allowed | `callable`            | (Optional) Closure to conditionally display the menu.            |
| submenu    | `array`               | (**Required**) Array of child menu items.                        |

#### Additional for `NAVBAR`

The following properties are specific to menus defined within the `NAVBAR`:

| Property   | Type                | Description                                                   |
|------------|---------------------|---------------------------------------------------------------|
| position   | `'left' or 'right'` | (Optional) Determines placement in the `NAVBAR`.              |
| menu_color | `string`            | (Optional) Bootstrap color class for the dropdown background. |

#### Additional for `SIDEBAR`

The following properties are specific to menus defined within the `SIDEBAR`:

| Property      | Type     | Description                                                    |
|---------------|----------|----------------------------------------------------------------|
| badge         | `string` | (Optional) Small badge to display next to the label.           |
| badge_color   | `string` | (Optional) Bootstrap badge color (e.g., `danger`, `primary`).  |
| badge_classes | `string` | (Optional) Additional CSS classes for the badge.               |
| toggler_icon  | `string` | (Optional) Icon used to indicate expand/collapse in treeview.  |

### Allowed Child Types

Each menu supports only certain types of child items. The following table summarizes the current restrictions:

| Context | Allowed Types                                      |
|---------|----------------------------------------------------|
| NAVBAR  | `MenuItemType::LINK`, `HEADER`, `DIVIDER`          |
| SIDEBAR | `MenuItemType::LINK`, `MENU` (recursive)           |

Sidebar treeview menus support unlimited nesting, allowing you to create deeply hierarchical menu structures. In contrast, navbar dropdown menus only allow a single level of submenu items. Nested dropdowns are **not supported** due to **Bootstrap 5 limitation** ([See Allowed Dropdown Content](https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-content)). This ensures consistent behavior and compatibility with the **Bootstrap 5** framework.

### Examples

#### NAVBAR Dropdown Menu

This example defines a dropdown menu for the `NAVBAR`:

```php
[
    'type' => MenuItemType::MENU,
    'label' => 'Tools',
    'icon' => 'bi bi-tools',
    'position' => 'right',
    'submenu' => [
        [
            'type' => MenuItemType::LINK,
            'label' => 'Logs',
            'route' => ['logs.index'],
        ],
        [
            'type' => MenuItemType::DIVIDER,
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Settings',
            'url' => '/settings',
        ],
    ],
]
```

#### SIDEBAR Treeview Menu

This example defines a treeview menu for the `SIDEBAR`:

```php
[
    'type' => MenuItemType::MENU,
    'label' => 'Management',
    'icon' => 'bi bi-gear',
    'submenu' => [
        [
            'type' => MenuItemType::LINK,
            'label' => 'Users',
            'route' => ['users.index'],
        ],
        [
            'type' => MenuItemType::MENU,
            'label' => 'Projects',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Active Projects',
                    'url' => '/projects/active',
                ],
            ],
        ],
    ],
]
```

## Adding Extra Properties

Each menu item type supports a set of standard properties, but you can also add custom properties to further tailor your menu items. These extra properties are included as `HTML` attributes on the rendered menu element, enabling advanced customization such as adding data attributes, custom classes, or ARIA labels.

For example, you might want to add a custom data attribute and a `CSS` class to a menu link:

```php
[
    // Standard properties for a link...
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

## Properties Reference

This section provides a comprehensive reference for all supported menu item properties, including their descriptions and usage. Use this guide to understand each property’s purpose and how it affects the appearance and behavior of your menu items.

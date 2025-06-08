# Menu Configuration

This configuration defines the static menu structure of your admin panel. You can use it to declare your `navbar` and `sidebar` menu items.

The menu settings are managed in the `config/ladmin_menu.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## Menu Items

Menu items define the links, headers, dividers, and interactive elements that appear in your admin panel's navigation. Each item is configured as an array with specific properties, allowing you to customize its appearance and behavior. Understanding the available item types and their options helps you build a clear and user-friendly menu structure.

Here is a quick example of how to define a simple link menu item in your `config/ladmin_menu.php` file:

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

All available menu item properties are thoroughly documented in the [Properties Reference](#properties-reference) section. Refer to this section for detailed descriptions, usage examples, and guidance on how each property affects your menu configuration.

### Menu Placement

Menu items are grouped by placement using the next enum:

```php
DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement
```

- `MenuPlacement::NAVBAR`: Items for the top navigation bar.
- `MenuPlacement::SIDEBAR`: Items for the side menu panel.

So, your `config/ladmin_menu.php` file should follow this structure:

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

| Property                  | Type                    | Description                                                           |
|---------------------------|-------------------------|-----------------------------------------------------------------------|
| [type](#type)             | `MenuItemType::DIVIDER` | (**Required**) Identifies the item as a divider.                      |
| [color](#color)           | `string`                | (Optional) Bootstrap contextual color (e.g., `primary`, `secondary`). |
| [position](#position)     | `'left' or 'right'`     | (Optional) Determines placement in the `NAVBAR`.                      |
| [is_allowed](#is-allowed) | `callable`              | (Optional) Closure to conditionally display the divider.              |

### Example

This example shows how you could add a colored divider to the right section of the `NAVBAR`:

```php
[
    'type' => MenuItemType::DIVIDER,
    'color' => 'primary',
    'position' => 'right',
]
```

## FULLSCREEN TOGGLER

The `FULLSCREEN_TOGGLER` type inserts a special menu item that toggles the browser’s fullscreen mode. It is only supported in the `NAVBAR` and provides visual feedback by switching icons when entering or exiting fullscreen.

This item is useful for enhancing the user experience in data-dense admin interfaces by allowing users to focus on the content without UI distractions.

### Accepted Properties

| Property                  | Type                               | Description                                                     |
|---------------------------|------------------------------------|-----------------------------------------------------------------|
| [type](#type)             | `MenuItemType::FULLSCREEN_TOGGLER` | (**Required**) Identifies the item as a fullscreen toggler.     |
| icon_expand               | `string`                           | (**Required**) Icon shown when fullscreen mode is not active.   |
| icon_collapse             | `string`                           | (**Required**) Icon shown when fullscreen mode is active.       |
| [color](#color)           | `string`                           | (Optional) Bootstrap contextual color (e.g., `info`, `danger`). |
| [position](#position)     | `'left' or 'right'`                | (Optional) Determines placement in the `NAVBAR`.                |
| [is_allowed](#is-allowed) | `callable`                         | (Optional) Closure to conditionally display the toggler.        |

::: info INFO: Icon Properties
The `icon_expand` and `icon_collapse` properties are used to specify the icons displayed for expanding and collapsing the fullscreen toggler. These work similarly to the standard [icon](#icon) property, but allow you to define different icons for each state. You can use any supported icon class (such as `Bootstrap Icons` or `FontAwesome`) to customize the appearance of the toggler in both modes.
:::

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

| Property                  | Type                   | Description                                                      |
|---------------------------|------------------------|------------------------------------------------------------------|
| [type](#type)             | `MenuItemType::HEADER` | (**Required**) Identifies the item as a header.                  |
| [label](#label)           | `string`               | (**Required**) Text to display as the section header.            |
| [icon](#icon)             | `string`               | (Optional) Icon to display alongside the label.                  |
| [color](#color)           | `string`               | (Optional) Bootstrap contextual color (e.g., `success`, `info`). |
| [position](#position)     | `'left' or 'right'`    | (Optional) Determines placement in the `NAVBAR`.                 |
| [is_allowed](#is-allowed) | `callable`             | (Optional) Closure to conditionally display the header.          |

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

| Property                        | Type                         | Description                                                                              |
|---------------------------------|------------------------------|------------------------------------------------------------------------------------------|
| [type](#type)                   | `MenuItemType::LINK`         | (**Required**) Identifies the item as a standard link.                                   |
| [label](#label)                 | `string`                     | (**Required** if no icon) Text to display for the link.                                  |
| [icon](#icon)                   | `string`                     | (Optional) Icon to display alongside the label.                                          |
| [color](#color)                 | `string`                     | (Optional) Bootstrap contextual color for the link (e.g., `warning`, `info`).            |
| [url](#url)                     | `string`                     | (**Required** if no route) Target `URL` or path for the link.                            |
| [route](#route)                 | `array`                      | (Optional) Named route definition (e.g., `['home']`).                                    |
| [badge](#badge)                 | `string`                     | (Optional) Small text badge (e.g., notification count).                                  |
| [badge_color](#badge-color)     | `string`                     | (Optional) Bootstrap badge color (e.g., `danger`, `success`).                            |
| [badge_classes](#badge-classes) | `string`                     | (Optional) Additional `CSS` classes for styling the badge.                               |
| [position](#position)           | `'left' or 'right'`          | (Optional) Determines placement in the `NAVBAR`.                                         |
| [is_active](#is-active)         | `callable or ActiveStrategy` | (Optional) Closure or custom `ActiveStrategy` to control when the link is marked active. |
| [is_allowed](#is-allowed)       | `callable`                   | (Optional) Closure to conditionally display the link.                                    |

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

| Property                  | Type                 | Description                                                      |
|---------------------------|----------------------|------------------------------------------------------------------|
| [type](#type)             | `MenuItemType::MENU` | (**Required**) Identifies the item as a menu container.          |
| [label](#label)           | `string`             | (**Required** in sidebar, or when no icon in navbar) Text label. |
| [icon](#icon)             | `string`             | (Optional) Icon to display alongside the label.                  |
| [color](#color)           | `string`             | (Optional) Bootstrap contextual color for the parent item.       |
| [is_allowed](#is-allowed) | `callable`           | (Optional) Closure to conditionally display the menu.            |
| [submenu](#submenu)       | `array`              | (**Required**) Array of child menu items.                        |

#### Additional for `NAVBAR`

The following properties are specific to menus defined within the `NAVBAR`:

| Property                  | Type                | Description                                                   |
|---------------------------|---------------------|---------------------------------------------------------------|
| [position](#position)     | `'left' or 'right'` | (Optional) Determines placement in the `NAVBAR`.              |
| [menu_color](#menu-color) | `string`            | (Optional) Bootstrap color class for the dropdown background. |

#### Additional for `SIDEBAR`

The following properties are specific to menus defined within the `SIDEBAR`:

| Property                        | Type     | Description                                                   |
|---------------------------------|----------|---------------------------------------------------------------|
| [badge](#badge)                 | `string` | (Optional) Small badge to display next to the label.          |
| [badge_color](#badge-color)     | `string` | (Optional) Bootstrap badge color (e.g., `danger`, `primary`). |
| [badge_classes](#badge-classes) | `string` | (Optional) Additional CSS classes for the badge.              |
| [toggler_icon](#toggler-icon)   | `string` | (Optional) Icon used to indicate expand/collapse in treeview. |

::: info INFO: Toggler Icon
The `toggler_icon` property is used to specify the icon displayed for expanding and collapsing the treeview menu. This work similarly to the standard [icon](#icon) property. You can use any supported icon class (such as `Bootstrap Icons` or `FontAwesome`) to customize the appearance of the toggler.
:::

### Allowed Child Types

Each menu supports only certain types of child items. The following table summarizes the current restrictions:

| Context     | Allowed Child Types         |
|-------------|-----------------------------|
| **NAVBAR**  | `LINK`, `HEADER`, `DIVIDER` |
| **SIDEBAR** | `LINK`, `MENU` (recursive)  |

Sidebar treeview menus support unlimited nesting, allowing you to create deeply hierarchical menu structures. In contrast, navbar dropdown menus only allow a single level of submenu items. Nested dropdowns are **not supported** due to **Bootstrap 5 limitation** ([See Allowed Dropdown Content](https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-content)). This ensures consistent behavior and compatibility with the **Bootstrap 5** framework.

### Examples

#### Dropdown Menu

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

#### Treeview Menu

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
                    'label' => 'All Projects',
                    'url' => '/projects',
                ],
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

| Property                        | Description                                         |
|---------------------------------|-----------------------------------------------------|
| [badge](#badge)                 | Displays a badge next to the item label.            |
| [badge_classes](#badge-classes) | Adds custom `CSS` classes to the badge.             |
| [badge_color](#badge-color)     | Applies a Bootstrap contextual color to the badge.  |
| [color](#color)                 | Sets the Bootstrap contextual color of the item.    |
| [icon](#icon)                   | Adds an icon to the item.                           |
| [is_active](#is-active)         | Determines the active state by custom logic.        |
| [is_allowed](#is-allowed)       | Controls the item visibility based on custom logic. |
| [label](#label)                 | Text displayed for the menu item.                   |
| [menu_color](#menu-color)       | Sets background color for dropdowns (navbar only).  |
| [position](#position)           | Positions item in the navbar: `left` or `right`.    |
| [route](#route)                 | Laravel route definition to generate a `URL`.       |
| [submenu](#submenu)             | List of nested menu items.                          |
| [type](#type)                   | Identifies the kind of menu item (always required). |
| [url](#url)                     | Direct `URL` for the menu item.                     |

### *badge*

The `badge` property can be used to display a small label or count next to the menu item, commonly used to highlight notifications, pending actions, or status indicators. This helps draw attention to important updates or actionable items within your menu.

- **Type**: `string`
- **Example**: `'badge' => '5'`

### *badge_classes*

The `badge_classes` property lets you add one or more custom `CSS` classes to the badge element, enabling advanced styling or integration with your own design system. Use this property to adjust the badge’s shape, borders, spacing, or any other visual aspect beyond the default appearance.

- **Type**: `string`
- **Example**: `'badge_classes' => 'rounded-circle border border-light border-2'`

### *badge_color*

The `badge_color` property allows you to set the Bootstrap contextual color class for the badge, such as `primary`, `danger`, or `success`. This property determines the badge’s background color, making it easy to visually highlight important or status-related information within your menu item.

- **Type**: `string`
- **Example**: `'badge_color' => 'danger'` for a red badge.

### *color*

The `color` property lets you apply a Bootstrap contextual color class (such as `primary`, `success`, or `danger`) to a menu item. This typically changes the text and icon color of a menu item. Use this property to visually highlight or categorize menu items for better navigation clarity.

- **Type**: `string`
- **Example**: `'color' => 'primary'`

### *icon*

The `icon` property allows you to display an icon alongside the menu item's label. Specify any supported icon class, such as those from [Bootstrap Icons](https://icons.getbootstrap.com/) or [FontAwesome](https://fontawesome.com/). Icons enhance visual recognition and help users quickly identify menu items.

- **Type**: `string`
- **Example**: `'icon' => 'bi bi-gear'`

::: info INFO: Default Icon Class
By default, LaradminLte uses `Bootstrap Icons` for all menu item icons. If you prefer to use `FontAwesome` or another icon set, you can easily switch by adjusting the [Plugins](/sections/config/plugins) configuration in your template. Refer to the [Managing Icon Libraries](/sections/config/plugins#managing-icon-libraries) section for setup instructions and compatibility details.
:::

### *is_active*

The **active** state visually highlights the menu item that corresponds to the current page or route, helping users understand where they are in the application.

By default, a link item is marked as active if its `url` or `route` matches the current request. For menu containers, the active state is automatically applied if any of their child items are active. Headers, dividers, and other non-interactive items are never marked as active.

You can customize this behavior for link items using the `is_active` property. This property accepts a closure or a custom `ActiveStrategy` (see below), allowing you to define exactly when a menu item should be considered active, such as matching specific routes, query parameters, or other conditions.

- **Type**: `callable | ActiveStrategy`
- **Example**: `'is_active' => fn() => request()->is('users*')`

::: details Example 1: Using a `callable` with the Menu Config Array

You can define the `is_active` property as a closure that receives the **menu item’s configuration array** as its argument. This gives you flexibility to use any property of the menu item for your custom logic. For example, you might want to mark the item as active if the current request matches the item's URL or a related pattern:

```php
[
    'type' => MenuItemType::LINK,
    'label' => 'Profile',
    'url' => 'profile',
    'is_active' => function (array $item) {
        // Mark as active if the current URL starts with the item's URL.
        // This will match 'profile', 'profile/edit', 'profile/settings', etc.
        return request()->is($item['url']) || request()->is($item['url'].'/*');
    },
]
```

This approach is especially useful when your menu is generated programmatically or when you need to support complex matching logic, such as handling multiple related routes or query parameters.
:::

::: details Example 2: Using a Custom `ActiveStrategy`

Suppose you have a resource listing page with a `state` query parameter (e.g., `state=all`, `state=pending`, `state=completed`). You want the "All Resources" menu item to be active only when `state=all` or when the parameter is missing, and separate menu items for "Pending" and "Completed" states. You can implement a custom `ActiveStrategy` to encapsulate this logic:

::: code-group
```php [ResourceStateActiveStrategy.php]
namespace App\CustomActiveStrategies;

use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;

class ResourceStateActiveStrategy implements ActiveStrategy
{
    protected string $expectedState;

    public function __construct(string $expectedState)
    {
        $this->expectedState = $expectedState;
    }

    public function isActive(): bool
    {
        $currentState = request('state', 'all');

        return reques()->is('resources')
            && $currentState === $this->expectedState;
    }
}
```

```php [Menu Definitions]
use App\CustomActiveStrategies\ResourceStateActiveStrategy;

[
    'type' => MenuItemType::LINK,
    'label' => 'All Resources',
    'url' => '/resources',
    'is_active' => new ResourceStateActiveStrategy('all'),
],
[
    'type' => MenuItemType::LINK,
    'label' => 'Pending',
    'url' => '/resources?state=pending',
    'is_active' => new ResourceStateActiveStrategy('pending'),
],
[
    'type' => MenuItemType::LINK,
    'label' => 'Completed',
    'url' => '/resources?state=completed',
    'is_active' => new ResourceStateActiveStrategy('completed'),
],
```

This approach ensures only the relevant menu item is marked as active based on the current `state` parameter, providing clear navigation for resource filtering.
:::

### *is_allowed*

The `is_allowed` property lets you specify a closure that determines whether a menu item should be visible. This is typically used for role-based access control, permission checks, or integrating with Laravel's Gate and Policy features. If the closure returns `false`, the menu item will not be rendered. Use this property to ensure users only see menu options relevant to their permissions or roles.

- **Type**: `callable`
- **Example**: `'is_allowed' => fn() => auth()->user()?->isAdmin()`

::: details Example: Using Laravel Gate for Menu Visibility

You can use Laravel's Gate or Policy system within the `is_allowed` closure to control menu visibility based on user permissions. For example, to show a menu item only if the user is authorized:

```php
[
    'type' => MenuItemType::LINK,
    'label' => 'Admin Dashboard',
    'url' => '/admin_dashboard',
    'is_allowed' => fn() => auth()->user() && Gate::allows('read-admin-dashboard'),
]
```

This ensures only authorized users see the relevant menu items.
:::

### *label*

The `label` property specifies the text shown for the menu item. It serves as the primary identifier for users navigating the menu. In most cases, `label` is required, but for certain item types (such as links with only an icon), it may be optional if an `icon` is provided. Use clear, concise labels to ensure menu items are easily understood.

- **Type**: `string`
- **Example**: `'label' => 'Settings'`

### *menu_color*

The `menu_color` is a special property that lets you set the background color of **dropdown menus** in the `NAVBAR` by applying a Bootstrap contextual color class (such as `dark`, `primary`, or `info`). Use this property to visually distinguish dropdown menus or align them with your application's branding. It has no effect on sidebar menus.

- **Type**: `string`
- **Example**: `'menu_color' => 'secondary-subtle'`

### *position*

The `position` property specifies the horizontal alignment of the menu item within the `NAVBAR` (which is `left` by default). Use `'left'` to place the item on the left side or `'right'` for the right side of the navbar. This property is ignored for sidebar menu items.

- **Type**: `string ('left' | 'right')`
- **Example**: `'position' => 'right'`

### *route*

The `route` property lets you define a Laravel named route (optionally with parameters) for the menu item. When set, the menu system will automatically generate the correct `URL` using Laravel’s `route()` helper, ensuring your links remain consistent even if route definitions change.

- **Type**: `array`
- **Example**: `'route' => ['users.create']`

::: danger CAUTION: Use Either `route` or `url`, Not Both!
You must specify only one of `route` or `url` for a menu item, never both at the same time.
:::

### *submenu*

The `submenu` property is used to specify an array of child menu items for a parent menu of type `MENU`. This enables you to create hierarchical navigation structures, such as dropdown menus in the `NAVBAR` or expandable treeview menus in the `SIDEBAR`. Please, note each element in the array must be a valid menu item configuration, following the same structure as top-level items.

- **Type**: `array`
- **Allowed child types**:
    - In the `NAVBAR`: Only `LINK`, `HEADER`, and `DIVIDER` types are supported (no nested submenus).
    - In the `SIDEBAR`: Both `LINK` and `MENU` types are supported, allowing for unlimited nesting.

::: details Example: Parent with Submenu Definition {open}
```php
[
    'type' => MenuItemType::MENU,
    'label' => 'Parent',
    'submenu' => [
        [
            'type' => MenuItemType::LINK,
            'label' => 'Child 1',
            'url' => '/child_1',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Child 2',
            'url' => '/child_2',
        ],
    ],
],
```
:::

Use the `submenu` property to organize related links under a common parent, improving navigation clarity and scalability in your admin panel.

### *toggler_icon*

The `toggler_icon` is a special property that allows you to customize the icon used for expanding and collapsing **treeview menus** in the `SIDEBAR`. By default, a caret or arrow icon is shown, but you can specify any supported icon class (such as from `Bootstrap Icons` or `FontAwesome`) to better match your application's style or improve clarity for users.

- **Type**: `string`
- **Example**: `'toggler_icon' => 'bi bi-arrow-right'`

### *type*

The `type` property specifies the kind of menu item you are defining. It determines how the item will be rendered and what additional properties are available for configuration. This property is **mandatory** for every menu item and must be set to one of the values from the `MenuItemType` enum, such as `LINK`, `MENU`, `DIVIDER`, `HEADER`, or `FULLSCREEN_TOGGLER`.

- **Type**: `MenuItemType`
- **Example**: `'type' => MenuItemType::LINK`

### *url*

The `url` property specifies the direct URL or path that a `LINK` menu item should navigate to when clicked. This property is required if the `route` property is not set. Use `url` for static or external links, or when you want to point to a specific path that is not managed by Laravel's named routes.

- **Type**: `string`
- **Example**: `'url' => '/dashboard'`

::: danger CAUTION: Use Either `route` or `url`, Not Both!
You must specify only one of `route` or `url` for a menu item, never both at the same time.
:::

<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\MenuItemType;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

// TODO: Explore the usage of a COMPOSITE pattern for the MenuItem class.
// This pattern allows for creating a tree structure of menu items, where
// each menu item can have child items. The MenuItem class can be the base
// class for all menu items, and it can have child items that are also
// instances of MenuItem.

// TODO: Explore the implementation of Laravel-AdminLTE filters for menu items.
// Should this logic be encapsulated within this class using utility methods
// like isActive(), isVisible(), etc. (use PHP traits)?
// 1) How can we determine if a menu item is currently active, i.e., its URL
// matches the current request's URL path?
// 2) How can we determine if a menu item should be displayed, based on
// Laravel's Gate or Policy checks?

class MenuItem
{
    /**
     * The set of reserved keys in a menu item configuration that have specific
     * meanings. Any other keys will be treated as additional HTML attributes
     * for the menu item.
     * TODO: A menu item should also support next properties:
     * - active: To define when the item should have the active style.
     * - can: Permissions of the item for use with Laravel's Gate.
     *
     * @var string[]
     */
    protected static array $reservedConfigKeys = [
        'badge',
        'badge_classes',
        'badge_color',
        'color',
        'icon',
        'label',
        'position',
        'route',
        'submenu',
        'type',
        'url',
    ];

    /**
     * Validation rules for each supported menu item type. These rules are
     * applied using the Laravel Validator to ensure the configuration matches
     * the expected schema for the given item type.
     *
     * @var array<string, array<string, string>>
     */
    protected static array $cfgValidationRules = [

        // Validation rules for a Header menu item.
        MenuItemType::HEADER->value => [
            'color' => 'sometimes|string',
            'icon' => 'sometimes|string',
            'label' => 'required|string',
            'position' => 'sometimes|in:left,right',
        ],

        // Validation rules for a Link menu item.
        MenuItemType::LINK->value => [
            'badge' => 'sometimes|string',
            'badge_classes' => 'sometimes|string',
            'badge_color' => 'sometimes|string',
            'color' => 'sometimes|string',
            'icon' => 'required_without:label|string',
            'label' => 'required_without:icon|string',
            'position' => 'sometimes|in:left,right',
            'route' => 'required_without:url|array',
            'url' => 'required_without:route|string',
        ],

        // Validation rules for a sidebar treeview-menu item.
        MenuItemType::TREEVIEW_MENU->value => [
            'badge' => 'sometimes|string',
            'badge_classes' => 'sometimes|string',
            'badge_color' => 'sometimes|string',
            'color' => 'sometimes|string',
            'icon' => 'sometimes|string',
            'label' => 'required|string',
            'submenu' => 'required|array',
        ],
    ];

    /**
     * The set of callable functions that will be used to create the blade
     * components for the menu items. The key is the placement of the item
     * (navbar or sidebar) and the value is a callable function that will
     * return the corresponding component.
     *
     * @var array<string, callable>
     */
    protected static array $componentBuilders = [
        'navbar' => [self::class, 'getNavbarComponent'],
        'sidebar' => [self::class, 'getSidebarComponent'],
    ];

    /**
     * The type of the menu item, which dictates its rendering logic by
     * selecting the appropriate blade component for it.
     *
     * @var MenuItemType
     */
    protected MenuItemType $type;

    /**
     * The underlying blade component that will be used to render the menu item.
     * This component is responsible for rendering the menu item in a view.
     *
     * @var Component
     */
    protected Component $bladeComponent;

    /**
     * An array of child menu items that are nested under this menu item. This
     * allows for creating hierarchical menu structures, where a menu item can
     * have sub-items or child items (allow support for treeview menus or
     * dropdowns).
     *
     * @var MenuItem[]
     */
    protected array $children;

    /**
     * Create a new MenuItem instance.
     *
     * @param  MenuItemType  $type  The type of the menu item
     * @param  Component  $component  The blade component for rendering the item
     * @param  MenuItem[]  $children  The child menu items of this item
     * @return void
     */
    public function __construct(
        MenuItemType $type,
        Component $component,
        array $children = []
    ) {
        $this->type = $type;
        $this->bladeComponent = $component;
        $this->children = $children;
    }

    /**
     * Create a new MenuItem instance from a raw menu item configuration array.
     * It will return null when the configuration is invalid.
     *
     * @param  array  $config  The menu item raw configuration array
     * @param  string  $place  The placement of the item (navnar or sidebar)
     * @return ?self
     */
    public static function createFromConfig(array $config, string $place): ?self
    {
        // Ensure the menu item configuration adheres to the expected schema.
        // The schema is determined by the type of the menu item. If the
        // configuration is invalid, we will return null to indicate that the
        // menu item is not valid.

        if (! self::validateMenuItemConfig($config)) {
            return null;
        }

        // Check if the menu item has children. If so, we will first create
        // the child MenuItem instances from its configuration.

        $children = [];

        if (! empty($config['submenu'])) {
            $children = self::getChildrenFromConfig($config['submenu'], $place);
        }

        // Determine the appropriate blade component for the menu item based on
        // its type and placement within the layout. This component will handle
        // the rendering logic for the menu item.

        $component = null;

        if (isset(self::$componentBuilders[$place])) {
            $component = self::$componentBuilders[$place]($config);
        }

        // If the component is null, it means that the menu item type is not
        // recognized for the given placement. In this case, we will return
        // null to indicate that the menu item is invalid. Otherwise, we
        // will return a new MenuItem instance.

        return ! empty($component)
            ? new self($config['type'], $component, $children)
            : null;
    }

    /**
     * Validate a menu item raw configuration. The schema for a menu item
     * depends on its type.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return bool
     */
    protected static function validateMenuItemConfig(array $config): bool
    {
        // First, check that the menu item has a valid type.

        $hasValidType = ! empty($config['type'])
            && $config['type'] instanceof MenuItemType;

        if (! $hasValidType) {
            return false;
        }

        // Check that a set of validation rules are defined for the item type.
        // We use Laravel validation rules that depends on the item type.

        $rules = self::$cfgValidationRules[$config['type']->value] ?? [];

        if (empty($rules)) {
            return false;
        }

        // Now, check that the configuration schema is valid for the item type.

        return Validator::make($config, $rules)->passes();
    }

    /**
     * Get child MenuItem instances from a raw menu item configuration array.
     * This method is used to get the child items of a menu item, recursively.
     *
     * @param  array  $items  The raw menu item configuration array
     * @param  string  $place  The placement of the item (navbar or sidebar)
     * @return MenuItem[]
     */
    protected static function getChildrenFromConfig(
        array $items,
        string $place
    ): array {
        $children = [];

        // Iterate over the raw menu item configuration array and create
        // child MenuItem instances for each item. If a child item is invalid,
        // it will be skipped.

        foreach ($items as $item) {
            $childItem = self::createFromConfig($item, $place);

            if ($childItem !== null) {
                $children[] = $childItem;
            }
        }

        return $children;
    }

    /**
     * Retrieve the blade component for a menu item in the navbar. The component
     * is determined by the type of the menu item. A null value will be
     * returned when the menu item type is not recognized for the navbar.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return ?Component
     */
    protected static function getNavbarComponent(array $config): ?Component
    {
        // First, retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item.

        $extraHtmlAttrs = Arr::except($config, self::$reservedConfigKeys);

        // Check the type of the menu item and return the corresponding
        // component. Note we return null for unrecognized menu item types as
        // they cannot be rendered in the navbar.

        switch ($config['type']) {
            case MenuItemType::HEADER:
                return (new Layout\Navbar\Header(
                    label: $config['label'],
                    icon: $config['icon'] ?? null,
                    color: $config['color'] ?? null,
                ))->withAttributes($extraHtmlAttrs);

            case MenuItemType::LINK:
                return (new Layout\Navbar\Link(
                    icon: $config['icon'] ?? null,
                    label: $config['label'] ?? null,
                    url: self::getUrlFromConfig($config),
                    color: $config['color'] ?? null,
                    badge: $config['badge'] ?? null,
                    badgeColor: $config['badge_color'] ?? null,
                    badgeClasses: $config['badge_classes'] ?? null,
                ))->withAttributes($extraHtmlAttrs);

            default:
                return null;
        }
    }

    /**
     * Retrieve the blade component for a menu item in the sidebar. The
     * component is determined by the type of the menu item. A null value will
     * be returned when the menu item type is not recognized for the sidebar.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return ?Component
     */
    protected static function getSidebarComponent(array $config): ?Component
    {
        // First, retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item.

        $extraHtmlAttrs = Arr::except($config, self::$reservedConfigKeys);

        // Check the type of the menu item and return the corresponding
        // component. Note we return null for unrecognized menu item types as
        // they cannot be rendered in the sidebar.

        switch ($config['type']) {
            case MenuItemType::HEADER:
                return (new Layout\Sidebar\Header(
                    label: $config['label'],
                    icon: $config['icon'] ?? null,
                    color: $config['color'] ?? null,
                ))->withAttributes($extraHtmlAttrs);

            case MenuItemType::LINK:
                return (new Layout\Sidebar\Link(
                    label: $config['label'],
                    icon: $config['icon'] ?? null,
                    url: self::getUrlFromConfig($config),
                    color: $config['color'] ?? null,
                    badge: $config['badge'] ?? null,
                    badgeColor: $config['badge_color'] ?? null,
                    badgeClasses: $config['badge_classes'] ?? null,
                ))->withAttributes($extraHtmlAttrs);

            case MenuItemType::TREEVIEW_MENU:
                return (new Layout\Sidebar\TreeviewMenu(
                    label: $config['label'],
                    icon: $config['icon'] ?? null,
                    color: $config['color'] ?? null,
                    badge: $config['badge'] ?? null,
                    badgeColor: $config['badge_color'] ?? null,
                    badgeClasses: $config['badge_classes'] ?? null,
                ))->withAttributes($extraHtmlAttrs);

            default:
                return null;
        }
    }

    /**
     * Retrieve the URL for the menu item from the configuration. The URL can
     * be either a direct URL (by using 'url' property) or a named route (by
     * using the 'route' property).
     *
     * @param  array  $config  The menu item raw configuration array
     * @return string
     */
    protected static function getUrlFromConfig(array $config): string
    {
        // Check if the 'url' property is defined in the configuration. If so,
        // use it to generate the URL of the item.

        if (! empty($config['url'])) {
            return url($config['url']);
        }

        // If the 'url' property is not defined, check if the 'route' property
        // is defined. If so, use it to generate the URL of the item.
        // The 'route' property is an array where the first element is the
        // route name and the second element, if present, is an array with the
        // route parameters.

        if (! empty($config['route'])) {
            $routeName = $config['route'][0] ?? null;
            $routeParams = is_array($config['route'][1] ?? null)
                ? $config['route'][1]
                : null;

            return $routeName ? route($routeName, $routeParams) : '#';
        }

        // If the 'url' and 'route' properties are not defined, we will
        // return a fallback placeholder URL.

        return '#';
    }

    /**
     * Get the child menu items of this menu item. This method will return an
     * array of MenuItem instances that are nested under this menu item.
     *
     * @return MenuItem[]
     */
    public function children(): array
    {
        return $this->children;
    }

    /**
     * Renders the menu item using its underlying blade component. This method
     * will return the rendered HTML of the menu item.
     *
     * @return string
     */
    public function render(): string
    {
        // First, render all the children of this item and combine them into a
        // single string.

        $childrenHtml = '';

        foreach ($this->children as $child) {
            $childrenHtml .= $child->render();
        }

        // Now, render the underlying root blade component.

        $view = $this->bladeComponent->render();

        // Check if the rendered view is a string. If so, return it as is.

        if (is_string($view)) {
            return str_replace('{{ $slot }}', $childrenHtml, $view);
        }

        // If the rendered view is not a string, it means that it is a View
        // instance. In this case, we will pass the data from the blade
        // component to the view and render it.

        $data = $this->bladeComponent->data();
        $data['slot'] = new HtmlString($childrenHtml);

        return $view->with($data)->render();
    }
}

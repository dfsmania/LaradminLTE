<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\MenuItemType;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Component;

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
     * Create a new MenuItem instance.
     *
     * @param  MenuItemType  $type  The type of the menu item
     * @param  Component  $component  The blade component for rendering the item
     * @return void
     */
    public function __construct(MenuItemType $type, Component $component)
    {
        $this->type = $type;
        $this->bladeComponent = $component;
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

        // Determine the appropriate blade component for the menu item based on
        // its type and placement within the layout. This component will handle
        // the rendering logic for the menu item.

        $component = null;

        if ($place === 'navbar') {
            $component = self::getNavbarComponent($config);
        } elseif ($place === 'sidebar') {
            $component = self::getSidebarComponent($config);
        }

        // If the component is null, it means that the menu item type is not
        // recognized for the given placement. In this case, we will return
        // null to indicate that the menu item is invalid. Otherwise, we
        // will return a new MenuItem instance.

        return ! empty($component)
            ? new self($config['type'], $component)
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
        // component.

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
        // component.

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
                 // TODO: Implement creation of treeview menu component.
                return null;

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
     * Renders the menu item using its underlying blade component. This method
     * will return the rendered HTML of the menu item.
     *
     * @return string
     */
    public function render(): string
    {
        // Render the underlying blade component.

        $view = $this->bladeComponent->render();

        // Check if the rendered view is a string. If so, return it as is.

        if (is_string($view)) {
            return $view;
        }

        // If the rendered view is not a string, it means that it is a View
        // instance. In this case, we will pass the data from the blade
        // component to the view and render it.

        return $view->with($this->bladeComponent->data())->render();
    }
}

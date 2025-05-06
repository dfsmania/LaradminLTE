<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems;

use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Link implements MenuItem
{
    /**
     * Defines the validation rules for this menu item. These rules are used
     * with the Laravel Validator to ensure the configuration adheres to the
     * expected schema for this menu item.
     *
     * @var array<string, string>
     */
    protected static array $cfgValidationRules = [
        'badge' => 'sometimes|string',
        'badge_classes' => 'sometimes|string',
        'badge_color' => 'sometimes|string',
        'color' => 'sometimes|string',
        'icon' => 'required_without:label|string',
        'label' => 'required_without:icon|string',
        'position' => 'sometimes|in:left,right',
        'route' => 'required_without:url|array',
        'type' => 'required',
        'url' => 'required_without:route|string',
    ];

    /**
     * The set of callable functions that will be used to create the blade
     * component for the menu item. The key is the placement of the item
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
     * The underlying blade component that will be used to render the menu item.
     * This component is responsible for rendering the menu item in a view.
     *
     * @var Component
     */
    protected Component $bladeComponent;

    /**
     * Create a new Link instance.
     *
     * @param  Component  $component  The blade component for rendering the item
     * @return void
     */
    public function __construct(Component $component)
    {
        $this->bladeComponent = $component;
    }

    /**
     * Create a new Link instance from a raw menu item configuration array.
     * It will return null when the configuration is invalid.
     *
     * @param  array  $config  The menu item raw configuration array
     * @param  string  $place  The placement of the item (navnar or sidebar)
     * @return ?self
     */
    public static function createFromConfig(array $config, string $place): ?self
    {
        // Ensure the menu item configuration adheres to the expected schema.
        // If the configuration is invalid, we will return null to indicate
        // that the menu item is not valid.

        if (Validator::make($config, self::$cfgValidationRules)->fails()) {
            return null;
        }

        // Check that the placement is valid for this menu item. When placement
        // is not recognized, we will return null to indicate that the menu
        // item is not valid.

        if (! isset(self::$componentBuilders[$place])) {
            return null;
        }

        // Now, retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item blade component.

        $extraHtmlAttrs = Arr::except(
            $config,
            array_keys(self::$cfgValidationRules)
        );

        // Determine the appropriate blade component for the menu item based on
        // its placement within the layout.

        $component = self::$componentBuilders[$place]($config);
        $component->withAttributes($extraHtmlAttrs);

        // Return a new Link instance.

        return new self($component);
    }

    /**
     * Retrieve the blade component that should be used to render a Link item
     * in the navbar.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return Component
     */
    protected static function getNavbarComponent(array $config): Component
    {
        return new Layout\Navbar\Link(
            icon: $config['icon'] ?? null,
            label: $config['label'] ?? null,
            url: self::getUrlFromConfig($config),
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
        );
    }

    /**
     * Retrieve the blade component that should be used to render a Link item
     * in the sidebar.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return Component
     */
    protected static function getSidebarComponent(array $config): Component
    {
        return new Layout\Sidebar\Link(
            icon: $config['icon'] ?? null,
            label: $config['label'] ?? null,
            url: self::getUrlFromConfig($config),
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
        );
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
     * Determines if the menu item has child items.
     *
     * This method should return true for composite menu items that contain
     * child items, and false for leaf menu items.
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        // Header menu items do not have child items, so we return false.

        return false;
    }

    /**
     * Retrieves the child items of the menu item.
     *
     * This method should only be called if `hasChildren()` returns true. It
     * returns an array of `MenuItem` objects representing the children of the
     * menu item. If there are no children, an empty array is returned.
     *
     * @return MenuItem[]
     */
    public function getChildren(): array
    {
        // Header menu items do not have child items, so we return an empty
        // array.

        return [];
    }

    /**
     * Renders the menu item as HTML.
     *
     * This method generates and returns the HTML markup for the menu item.
     *
     * @return HtmlString
     */
    public function renderToHtml(): HtmlString
    {
        // Render the underlying blade component.

        $view = $this->bladeComponent->render();

        // Check if the rendered view is a string. If so, return it as is.

        if (is_string($view)) {
            return new HtmlString($view);
        }

        // If the rendered view is not a string, it means that it is a View
        // instance. In this case, we will pass the data from the blade
        // component to the view and render it.

        $data = $this->bladeComponent->data();

        return new HtmlString($view->with($data)->render());
    }
}

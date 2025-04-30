<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems;

use DFSmania\LaradminLte\Tools\Menu\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItemFactory;
use DFSmania\LaradminLte\Tools\Menu\MenuItemType;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class TreeviewMenu implements MenuItem
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
        'icon' => 'sometimes|string',
        'label' => 'required|string',
        'submenu' => 'required|array',
        'type' => 'required',
    ];

    /**
     * The set of allowed child types for this menu item. This is used to
     * determine which types of menu items can be nested under this item.
     *
     * @var MenuItemType[]
     */
    protected static array $allowedChildTypes = [
        MenuItemType::LINK,
        MenuItemType::TREEVIEW_MENU,
    ];

    /**
     * The underlying blade component that will be used to render the menu item.
     * This component is responsible for rendering the menu item in a view.
     *
     * @var Component
     */
    protected Component $bladeComponent;

    /**
     * An array of child menu items that are nested under this menu item. This
     * allows for creating a hierarchical menu structure.
     *
     * @var MenuItem[]
     */
    protected array $children;

    /**
     * Create a new TreeviewMenu instance.
     *
     * @param  Component  $component  The blade component for rendering the item
     * @param  MenuItem[]  $children  The child menu items of this item
     * @return void
     */
    public function __construct(Component $component, array $children = [])
    {
        $this->bladeComponent = $component;
        $this->children = $children;
    }

    /**
     * Create a new TreeviewMenu instance from a raw menu item configuration
     * array. It will return null when the configuration is invalid.
     *
     * @param  array  $config  The menu item raw configuration array
     * @return ?self
     */
    public static function createFromConfig(array $config): ?self
    {
        // Ensure the menu item configuration adheres to the expected schema.
        // If the configuration is invalid, we will return null to indicate
        // that the menu item is not valid.

        if (Validator::make($config, self::$cfgValidationRules)->fails()) {
            return null;
        }

        // Check if the menu item has children. If so, we will first create
        // the child menu item instances from its configuration.

        $children = [];

        if (! empty($config['submenu'])) {
            $children = self::getChildrenFromConfig($config['submenu']);
        }

        // Now, retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item blade component.

        $extraHtmlAttrs = Arr::except(
            $config,
            array_keys(self::$cfgValidationRules)
        );

        // Get the appropriate blade component for the menu item.

        $component = new Layout\Sidebar\TreeviewMenu(
            label: $config['label'],
            icon: $config['icon'] ?? null,
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
        );

        $component->withAttributes($extraHtmlAttrs);

        // Return a new Treeview menu instance.

        return new self($component, $children);
    }

    /**
     * Get child MenuItem instances from a raw submenu items configuration
     * array. This method is used to get the child items of a menu item,
     * recursively.
     *
     * @param  array  $items  The raw submenu items configuration array
     * @return MenuItem[]
     */
    protected static function getChildrenFromConfig(array $items): array
    {
        $children = [];

        // Iterate over the raw submenu items configuration array and create
        // child MenuItem instances for each item. If a child item is invalid,
        // it will be skipped.

        foreach ($items as $itemCfg) {
            // Check if the child item has a valid type. If not, skip it.

            $childType = $itemCfg['type'] ?? null;

            if (! in_array($childType, self::$allowedChildTypes)) {
                continue;
            }

            // Attempt to create a new menu item instance from the provided
            // configuration. If the configuration is invalid, the resulting
            // menu item instance will be null, and the item will be skipped.

            $child = MenuItemFactory::createFromConfig($itemCfg, 'sidebar');

            if ($child !== null) {
                $children[] = $child;
            }
        }

        return $children;
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

        return true;
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

        return $this->children;
    }

    /**
     * Renders the menu item as HTML.
     *
     * This method generates and returns the HTML markup for the menu item.
     *
     * @return HtmlString
     */
    public function render(): HtmlString
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
            return new HtmlString(
                str_replace('{{ $slot }}', $childrenHtml, $view)
            );
        }

        // If the rendered view is not a string, it means that it is a View
        // instance. In this case, we will pass the data from the blade
        // component to the view and render it.

        $data = $this->bladeComponent->data();
        $data['slot'] = new HtmlString($childrenHtml);

        return new HtmlString($view->with($data)->render());
    }
}
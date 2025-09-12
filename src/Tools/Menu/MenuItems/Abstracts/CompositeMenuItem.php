<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Abstracts;

use DFSmania\LaradminLte\Tools\Menu\ActiveStrategies\CompositeActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\AllowStrategies\CallableAllowStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\AllowStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\BuildableFromConfig;
use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;
use DFSmania\LaradminLte\Tools\Menu\MenuItemFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Abstract class representing a composite menu item in the menu system.
 *
 * This class serves as a base for creating composite menu items that may have
 * child items. It provides methods for creating instances from configuration,
 * rendering the menu item as HTML, and checking for child items.
 */
abstract class CompositeMenuItem implements BuildableFromConfig, MenuItem
{
    /**
     * Defines the validation rules for the menu item configuration. These
     * rules are used with the Laravel Validator to ensure the configuration
     * adheres to the expected schema.
     *
     * @var array<string, string|array>
     */
    protected static array $cfgValidationRules = [];

    /**
     * Defines the set of allowed child types for this menu item. This is used
     * to determine which types of menu items can be nested under this item.
     *
     * @var MenuItemType[]
     */
    protected static array $allowedChildTypes = [];

    /**
     * Specifies where the child items will be rendered within the admin panel
     * layout. This is required because the building process of a menu item
     * may be different depending on its placement.
     *
     * @var MenuPlacement
     */
    protected static MenuPlacement $childrenPlacement;

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
     * Indicates whether the menu item is currently active. An active menu item
     * will be rendered as selected or highlighted in the menu.
     *
     * @var bool
     */
    protected bool $isActive;

    /**
     * Create a new class instance.
     *
     * @param  Component  $component  The blade component for rendering the item
     * @param  MenuItem[]  $children  The child menu items of this item
     * @param  bool  $isActive  Whether the item should be marked as active
     * @return void
     */
    public function __construct(
        Component $component,
        array $children = [],
        bool $isActive = false
    ) {
        $this->bladeComponent = $component;
        $this->children = $children;
        $this->isActive = $isActive;
    }

    /**
     * Creates a new instance of the class from the provided menu item
     * configuration array. The method should validate the configuration and
     * return a new instance of the class if the configuration is valid. If the
     * configuration is invalid, it should return null.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return ?static
     */
    public static function createFromConfig(array $config): ?static
    {
        // Ensure the menu item configuration adheres to the expected schema.
        // If the configuration is invalid, we will return null to indicate
        // that the menu item configuration is not valid.

        if (Validator::make($config, static::$cfgValidationRules)->fails()) {
            return null;
        }

        // Retrieve the allow strategy for the menu item. This strategy is used
        // to determine if the menu item is allowed to be shown. Note a
        // concrete class inheriting from this abstract class may override the
        // 'makeAllowStrategy' method to provide a custom allow strategy.

        $allowStrategy = static::makeAllowStrategy($config);
        $isAllowed = $allowStrategy ? $allowStrategy->isAllowed() : true;

        // If the menu item is not allowed to be shown, we will return null to
        // indicate that the menu item should not be displayed and avoid
        // further menu item creation.

        if (! $isAllowed) {
            return null;
        }

        // Retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item blade component. Note that we only
        // include scalar values and null values, as arrays or objects are
        // not valid HTML attributes.

        $extraAttrs = collect($config)
            ->except(array_keys(static::$cfgValidationRules))
            ->filter(fn ($value) => is_scalar($value) || is_null($value))
            ->all();

        // Check if the menu item has children. If so, we will first create
        // the child menu item instances from their configuration.

        $childrenKey = static::getChildrenConfigKey();
        $children = ! empty($config[$childrenKey])
            ? static::getChildrenFromConfig($config[$childrenKey])
            : [];

        // If the menu item has no children, we will avoid further build
        // processing and return null to indicate that the menu item is invalid.

        if (empty($children)) {
            return null;
        }

        // Retrieve the active strategy for the menu item. This strategy will be
        // used to determine if the menu item is currently active. Note a
        // concrete class inheriting from this abstract class may override the
        // 'makeActiveStrategy' method to provide a custom active strategy.

        $activeStrategy = static::makeActiveStrategy($config, $children);
        $isActive = $activeStrategy ? $activeStrategy->isActive() : false;

        // Create the blade component for the menu item. This component will be
        // responsible for rendering the menu item in a view. We notify the
        // blade component about the active state of the menu item, so it can
        // render it accordingly.

        $component = static::makeBladeComponent($config, $isActive);
        $component->withAttributes($extraAttrs);

        // Return a new instance of the class. Note, we save the active state
        // on the menu item instance, so it can be used later to guess the
        // active state of a possible parent of that item.

        return new static($component, $children, $isActive);
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

            if (! in_array($childType, static::$allowedChildTypes)) {
                continue;
            }

            // Attempt to create a new menu item instance from the provided
            // configuration. If the configuration is invalid, the resulting
            // menu item instance will be null, and the item will be skipped.

            $child = MenuItemFactory::createFromConfig(
                $itemCfg,
                static::$childrenPlacement
            );

            if ($child !== null) {
                $children[] = $child;
            }
        }

        return $children;
    }

    /**
     * Retrieves the key in the configuration array that contains the child
     * items for this menu item. This is used to identify where the child
     * items are located in the configuration. Note this method can be
     * overriden in subclasses to provide a different key if needed.
     *
     * @return string
     */
    protected static function getChildrenConfigKey(): string
    {
        return 'submenu';
    }

    /**
     * Retrieves the name of the slot variable used to render child items
     * within the blade component. This is used to inject the rendered child
     * items into the main slot of the component. By default, it is set to
     * 'slot', but it can be overridden in subclasses if a different slot
     * name is used in the blade component.
     *
     * @return string
     */
    protected static function getChildrenSlotVariable(): string
    {
        return 'slot';
    }

    /**
     * Creates a new instance of the blade component for the menu item.
     *
     * This method is responsible for creating the appropriate blade component
     * based on the provided configuration. It should return an instance of the
     * component that will be used to render the menu item.
     *
     * @param  array  $config  The configuration array of the menu item
     * @param  bool  $isActive  Whether the component should be marked as active
     * @return Component
     */
    abstract protected static function makeBladeComponent(
        array $config,
        bool $isActive = false
    ): Component;

    /**
     * Creates a new instance of the active strategy for the menu item.
     *
     * This method is responsible for creating the appropriate active strategy
     * based on the provided configuration. It should return an instance of the
     * active strategy that'll be used to determine if the menu item is active.
     *
     * @param  array  $config  The configuration array of the menu item
     * @param  MenuItem[]  $children  The child menu items of this item
     * @return ?ActiveStrategy
     */
    protected static function makeActiveStrategy(
        array $config,
        array $children
    ): ?ActiveStrategy {
        // By default, we return a CompositeActiveStrategy instance, which
        // checks if any of the child items are active. Concrete classes
        // inheriting from this abstract class may override this method to
        // provide a custom active strategy.

        return new CompositeActiveStrategy($children);
    }

    /**
     * Creates a new instance of the allow's strategy for the menu item.
     *
     * This method is responsible for creating the appropriate allow's strategy
     * based on the provided configuration. It should return an instance of the
     * strategy that'll be used to determine if the menu item is allowed to be
     * shown.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return ?AllowStrategy
     */
    protected static function makeAllowStrategy(array $config): ?AllowStrategy
    {
        // If a callable or a custom AllowStrategy is provided in the
        // configuration, we will use it to determine the allowed status of the
        // menu item.

        if (! empty($config['is_allowed'])) {
            // If an instance of AllowStrategy is provided, we will use it
            // directly. This add support for custom allow strategies to be
            // used in the configuration.

            if ($config['is_allowed'] instanceof AllowStrategy) {
                return $config['is_allowed'];
            }

            // If a callable is provided, we will create a new instance of
            // the CallableAllowStrategy class. This allows for custom logic
            // to be used to determine the allowed status of the menu item.

            if (is_callable($config['is_allowed'])) {
                return new CallableAllowStrategy(
                    $config['is_allowed'],
                    $config
                );
            }
        }

        // By default, we return null, indicating that no allow's strategy is
        // defined. Concrete classes inheriting from this abstract class may
        // override this method to provide a custom allow strategy.

        return null;
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
        return ! empty($this->children);
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
        return $this->children;
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
        // First, render all the children of this item and combine them into a
        // single string.

        $childrenHtml = implode('', array_map(
            fn (MenuItem $child) => $child->renderToHtml(),
            $this->children
        ));

        // Now, render the underlying blade component with the children inside
        // the configured slot. This will return a string or a View instance.

        $slotVar = static::getChildrenSlotVariable();
        $view = $this->bladeComponent->render()
            ->with([$slotVar => new HtmlString($childrenHtml)]);

        // If the rendered output is a View instance, we will pass the data
        // from the blade component to the view and render it again.

        if ($view instanceof View) {
            $viewData = $this->bladeComponent->data();
            $view = $view->with($viewData)->render();
        }

        // Finally, we will return the rendered output as an HtmlString. This
        // ensures that the output is treated as safe HTML and can be directly
        // inserted into the DOM without escaping.

        return new HtmlString($view);
    }

    /**
     * Returns whether the menu item is currently active.
     *
     * An active menu item is rendered as selected or highlighted in the menu.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }
}

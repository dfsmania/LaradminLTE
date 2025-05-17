<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Base;

use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\BuildableFromConfig;
use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Abstract class representing a leaf menu item in the menu system.
 *
 * This class serves as a base for creating leaf menu items that do not have
 * child items. It provides methods for creating instances from configuration,
 * rendering the menu item as HTML, and checking for child items.
 */
abstract class AbstractLeafMenuItem implements BuildableFromConfig, MenuItem
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
     * The underlying blade component that will be used to render the menu item.
     * This component is responsible for rendering the menu item in a view.
     *
     * @var Component
     */
    protected Component $bladeComponent;

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
     * @param  bool  $isActive  Whether the item should be marked as active
     * @return void
     */
    public function __construct(Component $component, bool $isActive = false)
    {
        $this->bladeComponent = $component;
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

        // Retrieve the additional attributes for the menu item. These
        // attributes will be rendered as extra HTML attributes on the main
        // wrapper tag of the menu item blade component. Note that we only
        // include scalar values and null values, as arrays or objects are
        // not valid HTML attributes.

        $extraAttrs = collect($config)
            ->except(array_keys(static::$cfgValidationRules))
            ->filter(fn ($value) => is_scalar($value) || is_null($value))
            ->all();

        // Retrieve the active strategy for the menu item. This strategy is
        // used to determine if the menu item is currently active. Note a
        // concrete class inheriting from this abstract class may override the
        // 'makeActiveStrategy' method to provide a custom active strategy.

        $activeStrategy = static::makeActiveStrategy($config);
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

        return new static($component, $isActive);
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
     * @return ?ActiveStrategy
     */
    protected static function makeActiveStrategy(array $config): ?ActiveStrategy
    {
        // By default, we return null, indicating that no active strategy is
        // defined. Concrete classes inheriting from this abstract class may
        // override this method to provide a custom active strategy.

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
        // Render the underlying blade component. This will return a string or
        // a View instance.

        $view = $this->bladeComponent->render();

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

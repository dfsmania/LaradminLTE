<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Navbar;

use DFSmania\LaradminLte\Tools\Menu\MenuItems\Base\AbstractLeafMenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits\ResolvesItemLocalization;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\View\Component;

class DropdownHeader extends AbstractLeafMenuItem
{
    use ResolvesItemLocalization;

    /**
     * Defines the validation rules for the menu item configuration. These
     * rules are used with the Laravel Validator to ensure the configuration
     * adheres to the expected schema.
     *
     * @var array<string, string|array>
     */
    protected static array $cfgValidationRules = [
        'color' => 'sometimes|string',
        'icon' => 'sometimes|string',
        'is_allowed' => 'sometimes',
        'label' => 'required|string',
        'type' => 'required',
    ];

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
    protected static function makeBladeComponent(
        array $config,
        bool $isActive = false
    ): Component {
        return new Layout\Navbar\DropdownHeader(
            label: static::getTranslation($config['label']),
            icon: $config['icon'] ?? null,
            color: $config['color'] ?? null,
        );
    }
}

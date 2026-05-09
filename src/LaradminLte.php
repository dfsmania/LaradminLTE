<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\Events\BuildingMenu;
use DFSmania\LaradminLte\Support\Menu\MenuManager;
use DFSmania\LaradminLte\Support\Plugins\PluginsManager;

class LaradminLte
{
    /**
     * An instance of the menu manager. This is used to read, validate, and
     * classify the set of configured menu items.
     *
     * @var MenuManager
     */
    public MenuManager $menu;

    /**
     * An instance of the plugins manager. This is used to read, validate, and
     * classify the set of configured plugins resources.
     *
     * @var PluginsManager
     */
    public PluginsManager $plugins;

    /**
     * A flag indicating whether Vite is enabled for assets management. This is
     * determined based on the presence of Vite configuration in the
     * package's main configuration file.
     *
     * @var bool
     */
    public bool $isViteEnabled;

    /**
     * The list of entry points that will be bundled by Vite, as configured
     * in your Vite setup. These entry points should include the CSS and JS
     * files that are required for your admin panel.
     *
     * @var array<string>
     */
    public array $viteInput;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Determine if Vite is enabled by configuration, and load the list of
        // entry points if it is.

        $this->isViteEnabled = config('ladmin.main.vite.enabled', false);

        $this->viteInput = $this->isViteEnabled
            ? config('ladmin.main.vite.input', [])
            : [];

        // Load static menu from configuration file.

        $menuCfg = is_array(config('ladmin.menu'))
            ? config('ladmin.menu')
            : [];

        // Dispatch an event, allowing listeners to modify the menu
        // configuration programmatically before it is used.

        event(new BuildingMenu($menuCfg));

        // Init the menu manager with the provided menu items configuration.

        $this->menu = new MenuManager($menuCfg);

        // Init the plugins manager with the provided plugins configuration.
        // If Vite is enabled, we will not load plugins from configuration, as
        // they should be included in the Vite entry points instead.

        $plugins = is_array(config('ladmin.plugins')) && ! $this->isViteEnabled
            ? config('ladmin.plugins')
            : [];

        $this->plugins = new PluginsManager($plugins);
    }
}

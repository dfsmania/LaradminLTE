<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\Tools\Menu\MenuManager;
use DFSmania\LaradminLte\Tools\Plugins\PluginsManager;

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
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Init the menu manager with the provided menu items configuration.

        $this->menu = new MenuManager(
            is_array(config('ladmin_menu')) ? config('ladmin_menu') : []
        );

        // Init the plugins manager with the provided plugins configuration.

        $this->plugins = new PluginsManager(
            is_array(config('ladmin_plugins')) ? config('ladmin_plugins') : []
        );
    }
}

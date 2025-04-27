<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\Tools\Plugins\PluginsManager;

class LaradminLte
{
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
        // Init the plugins manager with the provided plugins configuration.

        $this->plugins = new PluginsManager(
            is_array(config('ladmin_plugins')) ? config('ladmin_plugins') : []
        );
    }
}

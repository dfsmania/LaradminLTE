<?php

namespace DFSmania\LaradminLte\Tools\Menu\Contracts;

/**
 * Interface BuildableFromConfig
 *
 * Defines the interface or contract for menu item classes that can be created
 * from a configuration array. This interface is used to enforce a consistent
 * method for creating menu items from configuration data.
 */
interface BuildableFromConfig
{
    /**
     * Creates a new instance of the class from the provided menu item
     * configuration array. The method should validate the configuration and
     * return a new instance of the class if the configuration is valid. If the
     * configuration is invalid, it should return null.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return ?static
     */
    public static function createFromConfig(array $config): ?static;
}

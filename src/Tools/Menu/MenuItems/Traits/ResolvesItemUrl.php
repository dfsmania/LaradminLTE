<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits;

trait ResolvesItemUrl
{
    /**
     * Resolves the URL associated with a menu item from its configuration.
     *
     * This utility supports two configuration styles: a direct URL using the
     * 'url' key, or a named route using the 'route' key. If neither is
     * defined, a fallback placeholder is returned.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return string
     */
    protected static function getUrlFromConfig(array $config): string
    {
        // Check if the 'url' key is defined in the configuration. If so, use
        // it to generate the URL of the item.

        if (static::hasValidUrlKey($config)) {
            return url($config['url']);
        }

        // If the 'url' key is not defined, check if the 'route' key is
        // defined. If so, use it to generate the URL of the item. The 'route'
        // property should be an array where the first element is the route
        // name and the second element, if present, is an array with additional
        // route parameters.

        if (static::hasValidRouteKey($config)) {
            $routeName = $config['route'][0] ?? null;
            $routeParams = is_array($config['route'][1] ?? null)
                ? $config['route'][1]
                : [];

            return $routeName ? route($routeName, $routeParams) : '#';
        }

        // If the 'url' and 'route' key are not well defined, we will return a
        // fallback placeholder URL.

        return '#';
    }

    /**
     * Check if the 'url' key is defined in the configuration and is a valid
     * string.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return bool
     */
    protected static function hasValidUrlKey(array $config): bool
    {
        return ! empty($config['url']) && is_string($config['url']);
    }

    /**
     * Check if the 'route' key is defined in the configuration and is a valid
     * array.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return bool
     */
    protected static function hasValidRouteKey(array $config): bool
    {
        return ! empty($config['route']) && is_array($config['route']);
    }
}

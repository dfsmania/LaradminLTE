<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits;

trait ResolvesMenuItemUrl
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

        if (! empty($config['url']) && is_string($config['url'])) {
            return url($config['url']);
        }

        // If the 'url' key is not defined, check if the 'route' key is
        // defined. If so, use it to generate the URL of the item. The 'route'
        // property should be an array where the first element is the route
        // name and the second element, if present, is an array with additional
        // route parameters.

        if (! empty($config['route']) && is_array($config['route'])) {
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
}

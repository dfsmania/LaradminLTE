<?php

use DFSmania\LaradminLte\LaradminLte;

if (! function_exists('ladmin')) {
    /**
     * Retrieve the LaradminLte singleton instance from the service container.
     *
     * This helper provides convenient access to the core LaradminLte class,
     * which is registered as a singleton within the application's container.
     * The same instance is shared throughout the current request lifecycle.
     *
     * @return LaradminLte
     */
    function ladmin(): LaradminLte
    {
        return resolve(LaradminLte::class);
    }
}

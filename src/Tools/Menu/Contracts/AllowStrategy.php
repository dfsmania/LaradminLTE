<?php

namespace DFSmania\LaradminLte\Tools\Menu\Contracts;

/**
 * Interface AllowStrategy
 *
 * Defines the interface or contract for an allow's strategy implementation of
 * a menu item. This interface is designed to implement the STRATEGY pattern
 * to determine if a menu item is allowed to be shown. The allow's strategy
 * can be customized to suit different needs, such as checking against Laravel
 * policies, user permissions, or other criteria.
 */
interface AllowStrategy
{
    /**
     * Determines whether the menu item is allowed to be shown based on
     * specific criteria.
     *
     * @return bool
     */
    public function isAllowed(): bool;
}

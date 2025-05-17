<?php

namespace DFSmania\LaradminLte\Tools\Menu\Contracts;

/**
 * Interface ActiveStrategy
 *
 * Defines the interface or contract for an active strategy implementation of a
 * menu item. This interface is designed to implement the STRATEGY pattern to
 * determine if a menu item is currently active. The active strategy can be
 * customized to suit different needs, such as checking against the current
 * request's URL, checking whether there's a children active, or other criteria.
 */
interface ActiveStrategy
{
    /**
     * Determines whether the menu item is active based on specific criteria.
     * The criteria may vary depending on the implementation or the menu item's
     * context.
     *
     * @return bool
     */
    public function isActive(): bool;
}

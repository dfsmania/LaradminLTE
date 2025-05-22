<?php

namespace DFSmania\LaradminLte\Tools\Menu\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface MenuItem
 *
 * Defines the interface or contract for a menu item. This interface is
 * designed to implement a COMPOSITE pattern, allowing menu items to be treated
 * uniformly whether they are individual items or composites with children. This
 * allows for creating hierarchical menu structures, where a menu item can have
 * sub-items or child items.
 */
interface MenuItem
{
    /**
     * Determines if the menu item has child items.
     *
     * This method should return true for composite menu items that contain
     * child items, and false for leaf menu items.
     *
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * Retrieves the child items of the menu item.
     *
     * This method should only be called if `hasChildren()` returns true. It
     * returns an array of `MenuItem` objects representing the children of the
     * menu item. If there are no children, an empty array is returned.
     *
     * @return MenuItem[]
     */
    public function getChildren(): array;

    /**
     * Renders the menu item as HTML.
     *
     * This method generates and returns the HTML markup for the menu item.
     *
     * @return HtmlString
     */
    public function renderToHtml(): HtmlString;

    /**
     * Returns whether the menu item is currently active.
     *
     * An active menu item is rendered as selected or highlighted in the menu.
     *
     * @return bool
     */
    public function isActive(): bool;
}

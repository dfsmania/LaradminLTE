<?php

namespace DFSmania\LaradminLte\Events;

class BuildingMenu
{
    /**
     * The array of initial menu items to build from. This array is populated
     * from the 'ladmin/menu.php' configuration file and is passed by reference
     * to allow modifications during the event handling process.
     *
     * @var array<string, list<array<array-key, mixed>>>
     */
    public array $menu;

    /**
     * Create a new event instance.
     * It receives the initial menu configuration array by reference.
     *
     * @param  array<string, list<array<array-key, mixed>>>  $menu
     */
    public function __construct(array &$menu)
    {
        // Pass by reference to allow mutation.

        $this->menu = &$menu;
    }
}

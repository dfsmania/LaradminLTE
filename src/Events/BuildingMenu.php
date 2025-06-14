<?php

namespace DFSmania\LaradminLte\Events;

class BuildingMenu
{
    /**
     * The array of initial menu items to build from. This array is populated
     * from the 'ladmin_menu.php' configuration file and is passed by reference
     * to allow modifications during the event handling process.
     *
     * @var array
     */
    public array $menu;

    /**
     * Create a new event instance.
     *
     * @param  array  $menu  The initial menu configuration.
     */
    public function __construct(array &$menu)
    {
        // Pass by reference to allow mutation.

        $this->menu = &$menu;
    }
}

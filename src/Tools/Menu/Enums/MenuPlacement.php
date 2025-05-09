<?php

namespace DFSmania\LaradminLte\Tools\Menu\Enums;

/**
 * MenuPlacement enum class.
 * This class defines the allowed placements for menu items in the AdminLTE
 * template. The placement determines where the menu item will be rendered
 * within the admin panel layout.
 */
enum MenuPlacement: string
{
    case NAVBAR = 'navbar';
    case SIDEBAR = 'sidebar';
}

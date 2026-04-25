<?php

namespace DFSmania\LaradminLte\Support\Menu\Enums;

/**
 * MenuItemType enum class.
 * This class defines the allowed menu item types that can be included in the
 * AdminLTE template.
 */
enum MenuItemType: string
{
    case DIVIDER = 'divider';
    case FULLSCREEN_TOGGLER = 'fullscreen-toggler';
    case HEADER = 'header';
    case LINK = 'link';
    case MENU = 'menu';
}

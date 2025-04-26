<?php

namespace DFSmania\LaradminLte\Tools\Menu;

/**
 * MenuItemType enum class.
 * This class defines the allowed menu item types that can be included in the
 * AdminLTE template.
 */
enum MenuItemType: string
{
    case HEADER = 'header';
    case LINK = 'link';
    case TREEVIEW_MENU = 'treeview-menu';
}

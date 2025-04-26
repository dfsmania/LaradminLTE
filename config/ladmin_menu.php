<?php

use DFSmania\LaradminLte\Tools\Menu\MenuItemType;

return [

    /*
    |--------------------------------------------------------------------------
    | Navbar Menu
    |--------------------------------------------------------------------------
    |
    | This section defines the menu items that will be displayed in the top
    | navbar of your admin panel. You can customize the items, their order, and
    | their appearance by modifying this configuration.
    |
    */

    'navbar' => [
        // Hamburger button to toggle the sidebar (required).
        // ---------------------------------------------------------------------
        [
            'type' => MenuItemType::LINK,
            'icon' => 'fas fa-bars',
            'url' => '#',
            'position' => 'left',
            'role' => 'button',
            'data-lte-toggle' => 'sidebar',
        ],

        // Add your custom menu items here to extend the navbar menu.
        // ---------------------------------------------------------------------
        [
            'type' => MenuItemType::LINK,
            'label' => 'Home',
            'url' => 'home',
            'color' => 'primary',
            'position' => 'left',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Contact',
            'url' => 'contact',
            'color' => 'success',
            'position' => 'left',
            'id' => 'link-contact',
        ],
        [
            'type' => MenuItemType::LINK,
            'icon' => 'far fa-lg fa-bell',
            'url' => 'notifications',
            'badge' => '5',
            'badge_color' => 'info',
            'badge_classes' => 'border border-dark border-1 rounded-circle',
            'position' => 'right',
        ],
        [
            'type' => MenuItemType::LINK,
            'icon' => 'far fa-lg fa-envelope',
            'url' => 'messages',
            'badge' => '7',
            'badge_color' => 'danger',
            'badge_classes' => 'border border-dark border-1 rounded-circle animate__animated animate__infinite animate__flash animate__slower',
            'position' => 'right',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar Menu
    |--------------------------------------------------------------------------
    |
    | This section defines the menu items that will be displayed in the sidebar
    | of your admin panel. You can customize the items, their order, and their
    | appearance by modifying this configuration.
    |
    */

    'sidebar' => [
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Basic Link Tests',
            'icon' => 'far fa-bookmark',
            'class' => 'text-uppercase fw-bold',
            'color' => 'success',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 1',
            'url' => 'link_1',
            'icon' => 'far fa-circle',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 2',
            'url' => 'link_2',
            'icon' => 'far fa-square',
            'color' => 'warning',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 3',
            'url' => 'link_3',
            'icon' => 'far fa-circle-dot',
            'badge' => '5',
            'badge_color' => 'info',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 4',
            'url' => 'link_4',
            'icon' => 'fas fa-star',
            'color' => 'info',
            'badge' => '7',
            'badge_color' => 'danger',
            'badge_classes' => 'rounded-circle',
        ],
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Treeview Menu Tests',
            'icon' => 'far fa-bookmark',
            'class' => 'text-uppercase fw-bold',
            'color' => 'success',
        ],
        [
            'type' => MenuItemType::TREEVIEW_MENU,
            'label' => 'Menu 1',
            'icon' => 'fas fa-cubes',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link A',
                    'url' => 'link_a',
                    'icon' => 'far fa-circle',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link B',
                    'url' => 'link_b',
                    'icon' => 'far fa-circle',
                ],
                [
                    'type' => MenuItemType::TREEVIEW_MENU,
                    'label' => 'SubMenu 1-1',
                    'icon' => 'fas fa-cubes',
                    'color' => 'info',
                    'badge' => '2',
                    'badge_color' => 'warning',
                    'submenu' => [
                        [
                            'type' => MenuItemType::LINK,
                            'url' => 'link_c',
                            'label' => 'Link C',
                            'icon' => 'far fa-circle',
                        ],
                        [
                            'type' => MenuItemType::LINK,
                            'url' => 'link_d',
                            'label' => 'Link D',
                            'icon' => 'far fa-circle',
                        ],
                    ],
                ],
            ]
        ],
    ],
];

<?php

use DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;

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

    MenuPlacement::NAVBAR->value => [
        // Hamburger button to toggle the sidebar (REQUIRED).
        // --------------------------------------------------------------------
        [
            'type' => MenuItemType::LINK,
            'icon' => 'bi bi-list fs-5',
            'url' => '#',
            'position' => 'left',
            'role' => 'button',
            'data-lte-toggle' => 'sidebar',
        ],

        // Fullscreen toggler (OPTIONAL).
        // --------------------------------------------------------------------
        [
            'type' => MenuItemType::FULLSCREEN_TOGGLER,
            'icon_expand' => 'bi bi-fullscreen fs-5',
            'icon_collapse' => 'bi bi-fullscreen-exit fs-5',
            'position' => 'right',
        ],

        // Add your custom menu items here to extend the navbar menu.
        // --------------------------------------------------------------------
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Header',
            'icon' => 'bi bi-bookmark-fill',
            'color' => 'dark',
            'position' => 'left',
            'class' => 'text-uppercase fw-bold',
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
            'icon' => 'bi bi-bell-fill fs-5',
            'url' => 'notifications',
            'badge' => '5',
            'badge_color' => 'info',
            'badge_classes' => 'border border-dark border-1 rounded-circle',
            'position' => 'right',
        ],
        [
            'type' => MenuItemType::LINK,
            'icon' => 'bi bi-envelope-fill fs-5',
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

    MenuPlacement::SIDEBAR->value => [
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Basic Link Tests',
            'icon' => 'bi bi-bookmark fs-5',
            'class' => 'text-uppercase fw-bold',
            'color' => 'success',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 1',
            'url' => 'link_1',
            'icon' => 'bi bi-circle fs-5',
            'class' => 'active',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 2',
            'url' => 'link_2',
            'icon' => 'bi bi-square fs-5',
            'color' => 'warning',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 3',
            'url' => 'link_3',
            'icon' => 'bi bi-record-circle fs-5',
            'badge' => '5',
            'badge_color' => 'info',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Link 4',
            'url' => 'link_4',
            'icon' => 'bi bi-star-fill fs-5 text-primary',
            'color' => 'info',
            'badge' => '7',
            'badge_color' => 'danger',
            'badge_classes' => 'rounded-circle',
        ],
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Treeview Menu Tests',
            'icon' => 'bi bi-bookmark fs-5',
            'class' => 'text-uppercase fw-bold',
            'color' => 'success',
        ],
        [
            'type' => MenuItemType::MENU,
            'label' => 'Menu 1',
            'icon' => 'bi bi-boxes fs-5',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link A',
                    'url' => 'link_a',
                    'icon' => 'bi bi-circle',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link B',
                    'url' => 'link_b',
                    'icon' => 'bi bi-circle',
                ],
                [
                    'type' => MenuItemType::MENU,
                    'label' => 'SubMenu 1-1',
                    'icon' => 'bi bi-boxes text-primary',
                    'color' => 'info',
                    'badge' => '2',
                    'badge_color' => 'warning',
                    'submenu' => [
                        [
                            'type' => MenuItemType::LINK,
                            'url' => 'link_c',
                            'label' => 'Link C',
                            'icon' => 'bi bi-circle-fill',
                        ],
                        [
                            'type' => MenuItemType::LINK,
                            'url' => 'link_d',
                            'label' => 'Link D',
                            'icon' => 'bi bi-circle-fill',
                        ],
                    ],
                ],
            ],
        ],
        [
            'type' => MenuItemType::MENU,
            'label' => 'Menu 2',
            'color' => 'warning',
            'icon' => 'bi bi-boxes fs-5',
            'toggler_icon' => 'bi bi-arrow-right fs-5',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link E',
                    'url' => 'link_e',
                    'icon' => 'bi bi-circle-fill',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link F',
                    'url' => 'link_f',
                    'icon' => 'bi bi-circle-fill',
                ],
            ],
        ],
    ],
];

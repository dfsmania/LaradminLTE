<?php

use DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;

/*
|------------------------------------------------------------------------------
| LaradminLTE Menu Configuration
|------------------------------------------------------------------------------
|
| This file lets you statically define the menu items for your admin panel.
| You can fully customize their placement, appearance, icons, URLs, and other
| properties to tailor the navigation experience to your needs.
|
| For more details, refer to the online documentation:
| https://dfsmania.github.io/LaradminLTE/sections/config/menu.html
|
*/
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
        [
            'type' => MenuItemType::LINK,
            'icon' => 'bi bi-list fs-5',
            'url' => '#',
            'position' => 'left',
            'role' => 'button',
            'data-lte-toggle' => 'sidebar',
        ],

        // Fullscreen toggler (OPTIONAL).
        [
            'type' => MenuItemType::FULLSCREEN_TOGGLER,
            'icon_expand' => 'bi bi-fullscreen fs-5',
            'icon_collapse' => 'bi bi-fullscreen-exit fs-5',
            'position' => 'right',
        ],

        // The next items are just examples that you can use as a reference
        // for creating your own menu items.
        [
            'type' => MenuItemType::LINK,
            'icon' => 'bi bi-house-door-fill fs-5',
            'url' => '#',
            'position' => 'left',
        ],
        [
            'type' => MenuItemType::MENU,
            'icon' => 'bi bi-gear fs-5',
            'menu_color' => 'light-subtle',
            'position' => 'right',
            'submenu' => [
                [
                    'type' => MenuItemType::HEADER,
                    'label' => 'Settings',
                    'icon' => 'bi bi-tag fs-5',
                    'class' => 'text-uppercase fw-bold',
                    'color' => 'primary',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Profile',
                    'icon' => 'bi bi-person-fill fs-5',
                    'url' => '#',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Preferences',
                    'icon' => 'bi bi-sliders fs-5',
                    'url' => '#',
                    'badge' => 'new',
                    'badge_color' => 'primary',
                    'badge_classes' => 'rounded-pill',
                ],
                [
                    'type' => MenuItemType::DIVIDER,
                    'class' => 'mx-1',
                ],
                [
                    'type' => MenuItemType::HEADER,
                    'label' => 'Support',
                    'icon' => 'bi bi-tag fs-5',
                    'class' => 'text-uppercase fw-bold',
                    'color' => 'primary',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Help',
                    'icon' => 'bi bi-question-circle-fill fs-5',
                    'url' => '#',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'About Us',
                    'icon' => 'bi bi-info-circle-fill fs-5',
                    'url' => '#',
                ],
            ],
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
        // The next items are just examples that you can use as a reference
        // for creating your own menu items.
        [
            'type' => MenuItemType::LINK,
            'label' => 'Welcome',
            'icon' => 'bi bi-emoji-wink-fill',
            'url' => 'ladmin_welcome',
        ],
        [
            'type' => MenuItemType::DIVIDER,
        ],
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Links',
            'icon' => 'bi bi-bookmark-fill',
            'class' => 'text-uppercase fw-bold',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Basic Link',
            'icon' => 'bi bi-circle',
            'url' => '#',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Highlighted Link',
            'icon' => 'bi bi-exclamation-triangle-fill',
            'url' => '#',
            'color' => 'warning',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Badge Link',
            'icon' => 'bi bi-bell-fill text-info',
            'url' => '#',
            'badge' => '5',
            'badge_color' => 'info',
        ],
        [
            'type' => MenuItemType::LINK,
            'label' => 'Not Allowed Link',
            'icon' => 'bi bi-ban',
            'url' => '#',
            'is_allowed' => fn () => false,
        ],
        [
            'type' => MenuItemType::DIVIDER,
        ],
        [
            'type' => MenuItemType::HEADER,
            'label' => 'Treeview Menus',
            'icon' => 'bi bi-bookmark-fill',
            'class' => 'text-uppercase fw-bold',
        ],
        [
            'type' => MenuItemType::MENU,
            'label' => 'Basic Menu',
            'icon' => 'bi bi-menu-down',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Child Link',
                    'icon' => 'bi bi-circle',
                    'url' => '#',
                ],
                [
                    'type' => MenuItemType::MENU,
                    'label' => 'Child Menu',
                    'icon' => 'bi bi-menu-down',
                    'submenu' => [
                        [
                            'type' => MenuItemType::LINK,
                            'label' => 'Child Link',
                            'icon' => 'bi bi-circle-fill',
                            'url' => '#',
                        ],
                        [
                            'type' => MenuItemType::LINK,
                            'label' => 'Child Link',
                            'icon' => 'bi bi-circle-fill',
                            'url' => '#',
                        ],
                    ],
                ],
            ],
        ],
        [
            'type' => MenuItemType::MENU,
            'label' => 'Styled Menu',
            'icon' => 'bi bi-boxes text-warning',
            'color' => 'info',
            'badge' => '2',
            'badge_color' => 'danger',
            'badge_classes' => 'rounded-pill me-4',
            'toggler_icon' => 'bi bi-caret-right-fill text-warning',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Child Link',
                    'icon' => 'bi bi-star-fill',
                    'url' => '#',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Child Link',
                    'icon' => 'bi bi-star-fill',
                    'url' => '#',
                ],
            ],
        ],
    ],
];

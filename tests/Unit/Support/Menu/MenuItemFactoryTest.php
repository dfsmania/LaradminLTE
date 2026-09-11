<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Menu;

use DFSmania\LaradminLte\Support\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Support\Menu\Contracts\AllowStrategy;
use DFSmania\LaradminLte\Support\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Support\Menu\Enums\MenuPlacement;
use DFSmania\LaradminLte\Support\Menu\MenuItemFactory;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Navbar\DropdownLink;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Navbar\Link as NavLink;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Navbar\Menu as NavMenu;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Sidebar\Link as SideLink;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Sidebar\Menu as SideMenu;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Support\HtmlString;

class MenuItemFactoryTest extends TestCase
{
    public function test_factory_rejects_invalid_item_configs(): void
    {
        $this->assertNull(
            MenuItemFactory::createFromConfig([], MenuPlacement::NAVBAR)
        );

        $this->assertNull(
            SideLink::createFromConfig(['type' => MenuItemType::LINK])
        );

        $this->assertNull(
            MenuItemFactory::createFromConfig(
                ['type' => MenuItemType::FULLSCREEN_TOGGLER],
                MenuPlacement::SIDEBAR
            )
        );
    }

    public function test_factory_builds_leaf_items_for_each_placement(): void
    {
        $items = [
            [MenuPlacement::NAVBAR, MenuItemType::DIVIDER, []],
            [
                MenuPlacement::NAVBAR,
                MenuItemType::FULLSCREEN_TOGGLER,
                ['icon_expand' => 'expand', 'icon_collapse' => 'collapse'],
            ],
            [
                MenuPlacement::NAVBAR,
                MenuItemType::HEADER,
                ['label' => 'Header'],
            ],
            [
                MenuPlacement::NAVBAR,
                MenuItemType::LINK,
                ['label' => 'Link', 'url' => '/link'],
            ],
            [MenuPlacement::NAVBAR_DROPDOWN, MenuItemType::DIVIDER, []],
            [
                MenuPlacement::NAVBAR_DROPDOWN,
                MenuItemType::HEADER,
                ['label' => 'Dropdown'],
            ],
            [
                MenuPlacement::NAVBAR_DROPDOWN,
                MenuItemType::LINK,
                ['label' => 'Dropdown link', 'url' => '/link'],
            ],
            [MenuPlacement::SIDEBAR, MenuItemType::DIVIDER, []],
            [
                MenuPlacement::SIDEBAR,
                MenuItemType::HEADER,
                ['label' => 'Sidebar'],
            ],
            [
                MenuPlacement::SIDEBAR,
                MenuItemType::LINK,
                ['label' => 'Sidebar link', 'url' => '/link'],
            ],
        ];

        foreach ($items as [$placement, $type, $config]) {
            $item = MenuItemFactory::createFromConfig(
                array_merge($config, ['type' => $type]),
                $placement
            );

            $this->assertNotNull($item);
            $this->assertFalse($item->hasChildren());
            $this->assertSame([], $item->getChildren());
            $this->assertInstanceOf(HtmlString::class, $item->renderToHtml());
        }

        $navbarLink = NavLink::createFromConfig([
            'type' => MenuItemType::LINK,
            'label' => 'Navbar link',
            'url' => '/navbar',
        ]);

        $this->assertNotNull($navbarLink);
        $this->assertInstanceOf(HtmlString::class, $navbarLink->renderToHtml());

        $navbarLinkWithBadge = NavLink::createFromConfig([
            'type' => MenuItemType::LINK,
            'icon' => 'icon',
            'url' => '/navbar',
            'badge' => 'new',
            'is_active' => fn () => true,
        ]);

        $this->assertTrue($navbarLinkWithBadge->isActive());
    }

    public function test_factory_builds_composite_items(): void
    {
        $navbar = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::MENU,
            'icon' => 'gear',
            'submenu' => [
                ['type' => MenuItemType::HEADER, 'label' => 'Header'],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Link',
                    'url' => '/link',
                ],
                ['type' => MenuItemType::DIVIDER],
            ],
        ], MenuPlacement::NAVBAR);

        $sidebar = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::MENU,
            'label' => 'Sidebar menu',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Child',
                    'url' => '/child',
                ],
                ['type' => MenuItemType::HEADER, 'label' => 'Ignored'],
            ],
        ], MenuPlacement::SIDEBAR);

        $this->assertCount(3, $navbar->getChildren());
        $this->assertCount(1, $sidebar->getChildren());
        $this->assertInstanceOf(HtmlString::class, $navbar->renderToHtml());
        $this->assertInstanceOf(HtmlString::class, $sidebar->renderToHtml());

        $navbarMenu = NavMenu::createFromConfig([
            'type' => MenuItemType::MENU,
            'label' => 'Navbar menu',
            'submenu' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Child',
                    'url' => '/child',
                ],
            ],
        ]);

        $this->assertNotNull($navbarMenu);
        $this->assertInstanceOf(HtmlString::class, $navbarMenu->renderToHtml());

        $dropdownLink = DropdownLink::createFromConfig([
            'type' => MenuItemType::LINK,
            'label' => 'Dropdown link',
            'url' => '/dropdown',
            'is_active' => fn () => true,
        ]);

        $this->assertNotNull($dropdownLink);
        $this->assertTrue($dropdownLink->isActive());

        $invalidComposite = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::MENU,
            'label' => 'Empty menu',
            'submenu' => [
                ['type' => MenuItemType::HEADER, 'label' => 'Not allowed'],
            ],
        ], MenuPlacement::SIDEBAR);

        $this->assertNull($invalidComposite);

        $this->assertNull(SideMenu::createFromConfig([
            'type' => MenuItemType::MENU,
            'submenu' => [],
        ]));

        $this->assertNull(SideMenu::createFromConfig([
            'type' => MenuItemType::MENU,
            'label' => 'Denied menu',
            'is_allowed' => fn () => false,
            'submenu' => [[
                'type' => MenuItemType::LINK,
                'label' => 'Child',
                'url' => '/child',
            ]],
        ]));
    }

    public function test_factory_applies_allow_and_active_strategies(): void
    {
        $notAllowed = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::LINK,
            'label' => 'Hidden',
            'url' => '/hidden',
            'is_allowed' => fn () => false,
        ], MenuPlacement::SIDEBAR);

        $active = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::LINK,
            'label' => 'Active',
            'url' => '/active',
            'is_active' => fn () => true,
        ], MenuPlacement::SIDEBAR);

        $this->assertNull($notAllowed);
        $this->assertTrue($active->isActive());

        $customActive = new class implements ActiveStrategy
        {
            public function isActive(): bool
            {
                return true;
            }
        };

        $navbarActive = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::LINK,
            'icon' => 'icon',
            'url' => '/custom',
            'is_active' => $customActive,
        ], MenuPlacement::NAVBAR);

        $this->assertTrue($navbarActive->isActive());

        $dropdownActive = MenuItemFactory::createFromConfig([
            'type' => MenuItemType::LINK,
            'icon' => 'icon',
            'url' => '/custom',
            'is_active' => $customActive,
        ], MenuPlacement::NAVBAR_DROPDOWN);

        $this->assertTrue($dropdownActive->isActive());

        $this->assertNotNull(MenuItemFactory::createFromConfig([
            'type' => MenuItemType::LINK,
            'label' => 'Custom strategy',
            'url' => '/custom',
            'is_active' => new class implements ActiveStrategy
            {
                public function isActive(): bool
                {
                    return false;
                }
            },
            'is_allowed' => new class implements AllowStrategy
            {
                public function isAllowed(): bool
                {
                    return true;
                }
            },
        ], MenuPlacement::SIDEBAR));
    }
}

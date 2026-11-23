<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Menu;

use DFSmania\LaradminLte\Support\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Support\Menu\Contracts\AllowStrategy;
use DFSmania\LaradminLte\Support\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\Support\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Support\Menu\Enums\MenuPlacement;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Abstracts\CompositeMenuItem;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Abstracts\LeafMenuItem;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\Component;

class MenuItemAbstractsTest extends TestCase
{
    public function test_leaf_component_exposes_default_hooks(): void
    {
        $leaf = new TestLeafComponent(new FakeComponent);

        $this->assertFalse($leaf->hasChildren());
        $this->assertSame([], $leaf->getChildren());
        $this->assertFalse($leaf->isActive());
        $this->assertNull($leaf->activeStrategy([]));
        $this->assertNull($leaf->allowStrategy([]));
        $this->assertSame('', (string) $leaf->renderToHtml());
    }

    public function test_composite_component_exposes_default_hooks(): void
    {
        $leaf = new TestLeafComponent(new FakeComponent);
        $composite = new TestCompositeComponent(new FakeComponent, [$leaf]);

        $this->assertSame('submenu', $composite->childrenKey());
        $this->assertSame('slot', $composite->slotVariable());
        $this->assertInstanceOf(
            ActiveStrategy::class,
            $composite->activeStrategy([], [$leaf])
        );
        $this->assertNull($composite->allowStrategy([]));
    }

    public function test_leaf_component_renders_htmlable_output(): void
    {
        // Create a test component that renders HTML.

        $component = new class extends Component
        {
            public function render(): Htmlable
            {
                return new class implements Htmlable
                {
                    public function toHtml(): string
                    {
                        return '<span>Item</span>';
                    }
                };
            }
        };

        // Create a test leaf component with the HTML-rendering component.

        $leaf = new TestLeafComponent($component);

        // Assert that the rendered HTML matches the expected output.

        $this->assertSame(
            '<span>Item</span>',
            $leaf->renderToHtml()->toHtml()
        );
    }

    public function test_leaf_component_rejects_closure_output(): void
    {
        // Create a test component that renders a closure.

        $component = new class extends Component
        {
            public function render(): \Closure
            {
                return fn () => 'Item';
            }
        };

        // Create a test leaf component with the closure-rendering component
        // and expect an exception when rendering it.

        $this->expectException(\UnexpectedValueException::class);

        $this->expectExceptionMessage(
            'Leaf menu components must render a view or HTML.'
        );

        (new TestLeafComponent($component))->renderToHtml();
    }

    public function test_empty_composite_exposes_default_hooks(): void
    {
        $emptyComposite = new TestCompositeComponent(new FakeComponent);

        $this->assertFalse($emptyComposite->hasChildren());

        $allowStrategy = $emptyComposite->allowStrategy([
            'is_allowed' => new class implements AllowStrategy
            {
                public function isAllowed(): bool
                {
                    return true;
                }
            },
        ]);

        $this->assertTrue($allowStrategy->isAllowed());
    }

    public function test_composite_component_requires_a_view(): void
    {
        // Create a test composite component without a view.

        $composite = new TestCompositeComponent(new FakeComponent);

        // Expect an exception when attempting to render it.

        $this->expectException(\UnexpectedValueException::class);

        $this->expectExceptionMessage(
            'Composite menu components must render a view.'
        );

        $composite->renderToHtml();
    }

    public function test_composite_creation_from_empty_config(): void
    {
        $composite = TestCompositeComponent::createFromConfig([]);
        $this->assertNull($composite);
    }
}

/**
 * A test leaf menu item used for testing purposes, which allow accessing some
 * of the protected methods for testing purposes.
 */
class TestLeafComponent extends LeafMenuItem
{
    /**
     * Make a fake Blade component for the leaf menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @param  bool  $isActive
     * @return Component
     */
    protected static function makeBladeComponent(
        array $config,
        bool $isActive = false
    ): Component {
        return new FakeComponent;
    }

    /**
     * Get the active strategy for the leaf menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @return ActiveStrategy|null
     */
    public function activeStrategy(array $config): ?ActiveStrategy
    {
        return self::makeActiveStrategy($config);
    }

    /**
     * Get the allow strategy for the leaf menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @return AllowStrategy|null
     */
    public function allowStrategy(array $config): ?AllowStrategy
    {
        return self::makeAllowStrategy($config);
    }
}

/**
 * A test composite menu item used for testing purposes, which allow accessing
 * some of the protected methods for testing purposes.
 */
class TestCompositeComponent extends CompositeMenuItem
{
    /**
     * The allowed child types for the composite menu item.
     *
     * @var array<MenuItemType>
     */
    protected static array $allowedChildTypes = [
        MenuItemType::LINK,
    ];

    /**
     * The children placement for the composite menu item.
     *
     * @var MenuPlacement
     */
    protected static MenuPlacement $childrenPlacement = MenuPlacement::SIDEBAR;

    /**
     * Make a fake Blade component for the composite menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @param  bool  $isActive
     * @return Component
     */
    protected static function makeBladeComponent(
        array $config,
        bool $isActive = false
    ): Component {
        return new FakeComponent;
    }

    /**
     * Get the children key for the composite menu item.
     *
     * @return string
     */
    public function childrenKey(): string
    {
        return self::getChildrenConfigKey();
    }

    /**
     * Get the slot variable for the composite menu item.
     *
     * @return string
     */
    public function slotVariable(): string
    {
        return self::getChildrenSlotVariable();
    }

    /**
     * Get the active strategy for the composite menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @param  MenuItem[]  $children
     * @return ActiveStrategy|null
     */
    public function activeStrategy(
        array $config,
        array $children
    ): ?ActiveStrategy {
        return self::makeActiveStrategy($config, $children);
    }

    /**
     * Get the allow strategy for the composite menu item.
     *
     * @param  array<array-key, mixed>  $config
     * @return AllowStrategy|null
     */
    public function allowStrategy(array $config): ?AllowStrategy
    {
        return self::makeAllowStrategy($config);
    }
}

/**
 * A fake Blade component used for testing purposes.
 */
class FakeComponent extends Component
{
    /**
     * Render the fake component.
     *
     * @return string
     */
    public function render(): string
    {
        return '';
    }
}

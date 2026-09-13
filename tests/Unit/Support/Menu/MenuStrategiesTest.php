<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Menu;

use DFSmania\LaradminLte\Support\Menu\ActiveStrategies\CallableActiveStrategy;
use DFSmania\LaradminLte\Support\Menu\ActiveStrategies\CompositeActiveStrategy;
use DFSmania\LaradminLte\Support\Menu\ActiveStrategies\UrlActiveStrategy;
use DFSmania\LaradminLte\Support\Menu\AllowStrategies\CallableAllowStrategy;
use DFSmania\LaradminLte\Support\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class MenuStrategiesTest extends TestCase
{
    public function test_callable_strategies_support_callables(): void
    {
        $config = ['label' => 'Example'];

        $this->assertTrue(
            (new CallableActiveStrategy(fn () => true))->isActive()
        );

        $this->assertTrue(
            (new CallableActiveStrategy(
                fn (array $value) => $value !== [],
                $config
            ))->isActive()
        );

        $this->assertTrue(
            (new CallableAllowStrategy(fn () => true))->isAllowed()
        );

        $this->assertTrue(
            (new CallableAllowStrategy(
                fn (array $value) => $value,
                $config
            ))->isAllowed()
        );
    }

    public function test_composite_active_strategy_stops_if_child_active(): void
    {
        $inactive = new FakeMenuItem(false);
        $active = new FakeMenuItem(true);

        $this->assertTrue(
            (new CompositeActiveStrategy(
                [$inactive, $active, $inactive]
            ))->isActive()
        );

        $this->assertFalse(
            (new CompositeActiveStrategy([$inactive]))->isActive()
        );
    }

    public function test_url_active_strategy_matches_query_strings(): void
    {
        $request = Request::create('http://localhost/dashboard?tab=home');

        $this->app->instance('request', $request);

        $this->assertTrue(
            (new UrlActiveStrategy('http://localhost/dashboard'))->isActive()
        );

        $this->assertTrue(
            (new UrlActiveStrategy(
                'http://localhost/dashboard?tab=home'
            ))->isActive()
        );

        $this->assertFalse(
            (new UrlActiveStrategy('/other'))->isActive()
        );
    }
}

/**
 * Fake menu item for testing purposes.
 */
class FakeMenuItem implements MenuItem
{
    /**
     * Constructor.
     *
     * @param  bool  $active  Whether the menu item is active.
     */
    public function __construct(private bool $active) {}

    /**
     * Indicates whether the menu item has children.
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        return false;
    }

    /**
     * Retrieves the children of the menu item.
     *
     * @return array
     */
    public function getChildren(): array
    {
        return [];
    }

    /**
     * Renders the menu item to HTML.
     *
     * @return HtmlString
     */
    public function renderToHtml(): HtmlString
    {
        return new HtmlString('');
    }

    /**
     * Indicates whether the menu item is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}

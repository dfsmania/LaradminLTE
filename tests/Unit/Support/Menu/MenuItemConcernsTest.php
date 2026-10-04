<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Menu;

use DFSmania\LaradminLte\Support\Menu\MenuItems\Concerns\ResolvesItemLocalization;
use DFSmania\LaradminLte\Support\Menu\MenuItems\Concerns\ResolvesItemUrl;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

class MenuItemConcernsTest extends TestCase
{
    public function test_url_concern_resolves_supported_configs(): void
    {
        Route::get('/dashboard', fn () => 'Dashboard')->name('dashboard');

        $this->assertSame(
            'http://localhost/dashboard',
            MenuConcernConsumer::url(['url' => '/dashboard'])
        );

        $this->assertSame(
            'http://localhost/dashboard',
            MenuConcernConsumer::url(['route' => ['dashboard']])
        );

        $this->assertSame(
            'http://localhost/dashboard?tab=home',
            MenuConcernConsumer::url([
                'route' => ['dashboard', ['tab' => 'home']],
            ])
        );

        $this->assertSame('#', MenuConcernConsumer::url(['route' => []]));
        $this->assertSame('#', MenuConcernConsumer::url([]));
    }

    public function test_translation_concern_resolves_supported_configs(): void
    {
        config(['ladmin.main.menu_translations.enabled' => false]);

        $this->assertSame(
            'Literal',
            MenuConcernConsumer::translation('Literal')
        );

        $this->assertSame('Key', MenuConcernConsumer::translation(['Key']));

        config(['ladmin.main.menu_translations.enabled' => true]);
        config(['ladmin.main.menu_translations.php_file' => 'menu']);

        Lang::addLines(['menu.title' => 'Translated'], 'en');
        Lang::addLines(['JSON.title' => 'JSON translated'], 'en');

        $this->assertSame(
            'Translated',
            MenuConcernConsumer::translation('title')
        );

        $this->assertSame(
            'JSON translated',
            MenuConcernConsumer::translation('JSON.title')
        );

        Lang::addLines(['menu.greeting' => 'Hello :name'], 'en');

        $this->assertSame(
            'Hello Jane',
            MenuConcernConsumer::translation(['greeting', ['name' => 'Jane']])
        );

        $this->assertSame(
            'Missing',
            MenuConcernConsumer::translation('Missing')
        );
    }
}

/**
 * A test consumer class for menu concerns, which allows accessing some
 * of the protected methods for testing purposes.
 */
class MenuConcernConsumer
{
    use ResolvesItemLocalization, ResolvesItemUrl;

    /**
     * Get the URL from the given configuration.
     *
     * @param  array  $config
     * @return string
     */
    public static function url(array $config): string
    {
        return self::getUrlFromConfig($config);
    }

    /**
     * Get the translation for the given value.
     *
     * @param  string|array  $value
     * @return string
     */
    public static function translation(string|array $value): string
    {
        return self::getTranslation($value);
    }
}

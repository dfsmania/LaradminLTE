<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Auth;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Auth\AuthBase;
use Illuminate\View\View;

class AuthBaseTest extends TestCase
{
    public function test_it_defaults_to_ltr_when_rtl_is_disabled(): void
    {
        config(['ladmin.main.layout.rtl' => false]);

        $auth = new AuthBase;

        $this->assertSame('ltr', $auth->htmlDir);
        $this->assertStringContainsString(
            'adminlte.min.css',
            $auth->adminlteCssFile
        );
    }

    public function test_it_uses_rtl_when_enabled(): void
    {
        config(['ladmin.main.layout.rtl' => true]);

        $auth = new AuthBase;

        $this->assertSame('rtl', $auth->htmlDir);
        $this->assertStringContainsString(
            'adminlte.rtl.min.css',
            $auth->adminlteCssFile
        );
    }

    public function test_it_sets_the_html_lang_from_the_current_locale(): void
    {
        app()->setLocale('en_US');

        $auth = new AuthBase;

        $this->assertSame('en-US', $auth->htmlLang);
    }

    public function test_it_accepts_a_valid_bootstrap_theme(): void
    {
        config(['ladmin.main.layout.bootstrap_theme' => 'dark']);

        $auth = new AuthBase;

        $this->assertSame('dark', $auth->bootstrapTheme);
    }

    public function test_it_rejects_an_invalid_bootstrap_theme(): void
    {
        config(['ladmin.main.layout.bootstrap_theme' => 'invalid']);

        $auth = new AuthBase;

        $this->assertSame('', $auth->bootstrapTheme);
    }

    public function test_it_uses_app_name_as_title_when_no_subtitle(): void
    {
        config(['app.name' => 'MyApp']);

        $auth = new AuthBase;

        $this->assertSame('MyApp', $auth->title);
    }

    public function test_it_appends_the_subtitle_to_the_app_name(): void
    {
        config(['app.name' => 'MyApp']);

        $auth = new AuthBase('Login');

        $this->assertSame('MyApp - Login', $auth->title);
    }

    public function test_it_uses_background_classes_when_no_image(): void
    {
        config(['ladmin.auth.background_image' => null]);

        $auth = new AuthBase;

        $this->assertStringContainsString(
            'bg-body-secondary',
            $auth->bodyClasses
        );

        $this->assertStringContainsString('bg-gradient', $auth->bodyClasses);
        $this->assertSame('', $auth->bodyStyles);
    }

    public function test_it_uses_custom_background_classes_from_config(): void
    {
        config([
            'ladmin.auth.background_image' => null,
            'ladmin.auth.background_classes' => ['custom-bg'],
        ]);

        $auth = new AuthBase;

        $this->assertStringContainsString('custom-bg', $auth->bodyClasses);
    }

    public function test_it_sets_inline_styles_when_image_is_configured(): void
    {
        config([
            'ladmin.auth.background_image' => 'https://example.com/bg.jpg',
        ]);

        $auth = new AuthBase;

        $this->assertStringNotContainsString(
            'bg-body-secondary',
            $auth->bodyClasses
        );

        $this->assertStringContainsString(
            "background-image: url('https://example.com/bg.jpg')",
            $auth->bodyStyles
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new AuthBase)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::auth.auth-base', $view->getName());
    }
}

<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\AdminPanel;
use Illuminate\View\View;

class AdminPanelTest extends TestCase
{
    public function test_it_defaults_to_ltr_when_rtl_is_disabled(): void
    {
        config(['ladmin.main.layout.rtl' => false]);

        $panel = new AdminPanel;

        $this->assertSame('ltr', $panel->htmlDir);

        $this->assertStringContainsString(
            'adminlte.min.css',
            $panel->adminlteCssFile
        );
    }

    public function test_it_uses_rtl_when_enabled(): void
    {
        config(['ladmin.main.layout.rtl' => true]);

        $panel = new AdminPanel;

        $this->assertSame('rtl', $panel->htmlDir);

        $this->assertStringContainsString(
            'adminlte.rtl.min.css',
            $panel->adminlteCssFile
        );
    }

    public function test_it_sets_the_html_lang_from_the_current_locale(): void
    {
        app()->setLocale('en_US');

        $panel = new AdminPanel;

        $this->assertSame('en-US', $panel->htmlLang);
    }

    public function test_it_accepts_a_valid_bootstrap_theme(): void
    {
        config(['ladmin.main.layout.bootstrap_theme' => 'dark']);

        $panel = new AdminPanel;

        $this->assertSame('dark', $panel->bootstrapTheme);
    }

    public function test_it_rejects_an_invalid_bootstrap_theme(): void
    {
        config(['ladmin.main.layout.bootstrap_theme' => 'invalid']);

        $panel = new AdminPanel;

        $this->assertSame('', $panel->bootstrapTheme);
    }

    public function test_it_uses_app_name_as_title_if_no_subtitle_given(): void
    {
        config(['app.name' => 'MyApp']);

        $panel = new AdminPanel;

        $this->assertSame('MyApp', $panel->title);
    }

    public function test_it_appends_the_subtitle_to_the_app_name(): void
    {
        config(['app.name' => 'MyApp']);

        $panel = new AdminPanel('Dashboard');

        $this->assertSame('MyApp - Dashboard', $panel->title);
    }

    public function test_it_uses_the_default_sidebar_expand_breakpoint(): void
    {
        config(['ladmin.main.sidebar.expand_breakpoint' => null]);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'sidebar-expand-lg',
            $panel->bodyClasses
        );
    }

    public function test_it_uses_a_valid_sidebar_expand_breakpoint(): void
    {
        config(['ladmin.main.sidebar.expand_breakpoint' => 'md']);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'sidebar-expand-md',
            $panel->bodyClasses
        );
    }

    public function test_it_falls_back_on_invalid_sidebar_expand_breakpoint(): void
    {
        config(['ladmin.main.sidebar.expand_breakpoint' => 'invalid']);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'sidebar-expand-lg',
            $panel->bodyClasses
        );
    }

    public function test_it_adds_the_mini_sidebar_class_when_enabled(): void
    {
        config(['ladmin.main.sidebar.mini_sidebar' => true]);

        $panel = new AdminPanel;

        $this->assertStringContainsString('sidebar-mini', $panel->bodyClasses);
    }

    public function test_it_adds_the_sidebar_collapse_class_when_enabled(): void
    {
        config(['ladmin.main.sidebar.default_collapsed' => true]);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'sidebar-collapse',
            $panel->bodyClasses
        );
    }

    public function test_it_adds_the_compact_mode_class_when_enabled(): void
    {
        config(['ladmin.main.layout.compact_mode' => true]);

        $panel = new AdminPanel;

        $this->assertStringContainsString('compact-mode', $panel->bodyClasses);
    }

    public function test_it_adds_fixed_layout_classes_when_enabled(): void
    {
        config([
            'ladmin.main.layout.fixed_sidebar' => true,
            'ladmin.main.layout.fixed_navbar' => true,
            'ladmin.main.layout.fixed_footer' => true,
        ]);

        $panel = new AdminPanel;

        $this->assertStringContainsString('layout-fixed', $panel->bodyClasses);
        $this->assertStringContainsString('fixed-header', $panel->bodyClasses);
        $this->assertStringContainsString('fixed-footer', $panel->bodyClasses);
    }

    public function test_it_omits_optional_classes_when_disabled(): void
    {
        config([
            'ladmin.main.sidebar.mini_sidebar' => false,
            'ladmin.main.sidebar.default_collapsed' => false,
            'ladmin.main.layout.compact_mode' => false,
            'ladmin.main.layout.fixed_sidebar' => false,
            'ladmin.main.layout.fixed_navbar' => false,
            'ladmin.main.layout.fixed_footer' => false,
        ]);

        $bodyClasses = (new AdminPanel)->bodyClasses;

        $this->assertStringNotContainsString('sidebar-mini', $bodyClasses);
        $this->assertStringNotContainsString('sidebar-collapse', $bodyClasses);
        $this->assertStringNotContainsString('compact-mode', $bodyClasses);
        $this->assertStringNotContainsString('layout-fixed', $bodyClasses);
        $this->assertStringNotContainsString('fixed-header', $bodyClasses);
        $this->assertStringNotContainsString('fixed-footer', $bodyClasses);
    }

    public function test_it_disables_the_adminlte_color_palette(): void
    {
        config(['ladmin.main.colors.enabled' => false]);

        $panel = new AdminPanel;

        $this->assertNull($panel->adminlteColorsCssFile);
    }

    public function test_it_ignores_an_invalid_color_palette(): void
    {
        config([
            'ladmin.main.colors.enabled' => true,
            'ladmin.main.colors.palette' => 'invalid',
        ]);

        $panel = new AdminPanel;

        $this->assertNull($panel->adminlteColorsCssFile);
    }

    public function test_it_uses_the_default_color_palette_file(): void
    {
        config([
            'ladmin.main.colors.enabled' => true,
            'ladmin.main.colors.palette' => 'default',
        ]);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'adminlte-colors.min.css',
            $panel->adminlteColorsCssFile
        );
    }

    public function test_it_uses_the_v3_color_palette_file(): void
    {
        config([
            'ladmin.main.colors.enabled' => true,
            'ladmin.main.colors.palette' => 'v3',
        ]);

        $panel = new AdminPanel;

        $this->assertStringContainsString(
            'adminlte-colors-v3.min.css',
            $panel->adminlteColorsCssFile
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new AdminPanel)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.admin-panel', $view->getName());
    }
}

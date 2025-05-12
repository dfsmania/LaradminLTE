<?php

namespace DFSmania\LaradminLte\View\Components\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminPanel extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied to the entire
     * layout.
     *
     * @var string[]
     */
    protected array $validBootstrapThemes = [
        'light',
        'dark',
    ];

    /**
     * The set of valid Bootstrap screen breakpoints.
     *
     * @var string[]
     */
    protected array $validScreenBreakpoints = ['sm', 'md', 'lg', 'xl', 'xxl'];

    /**
     * The 'dir' attribute for the main HTML tag. This is used to switch between
     * LTR (left-to-right) and RTL (right-to-left) layouts.
     */
    public string $htmlDir;

    /**
     * The 'lang' attribute for the main HTML tag. This is used to specify the
     * language of the document.
     */
    public string $htmlLang;

    /**
     * The Bootstrap theme that will be applied to the entire layout.
     *
     * @var string
     */
    public string $bootstrapTheme;

    /**
     * The title that will be displayed on the browser's window. Defaults to
     * config('app.name') when not provided.
     *
     * @var string
     */
    public string $title;

    /**
     * The URL path to the AdminLTE stylesheet file. Different stylesheet files
     * are used to switch between LTR (left-to-right) and RTL (right-to-left)
     * layouts.
     *
     * @var string
     */
    public string $adminlteCssFile;

    /**
     * The set of CSS classes for the body tag, as a space-separated string.
     * This is used to apply different layout styles.
     *
     * @var string
     */
    public string $bodyClasses;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $title  The title for the browser's window.
     * @return void
     */
    public function __construct(?string $title = null)
    {
        $this->htmlDir = $this->getHtmlDir();
        $this->htmlLang = $this->getHtmlLang();
        $this->bootstrapTheme = $this->getBootstrapTheme();
        $this->title = $title ?? config('app.name');

        // Setup the AdminLTE stylesheet file path (LTR or RTL).

        $this->adminlteCssFile = $this->getAdminlteCssFile();

        // Setup the body classes.

        $this->bodyClasses = $this->getBodyClasses();
    }

    /**
     * Gets the 'dir' attribute for the main HTML tag. This property depends on
     * whether layout RTL configuration is enabled or not.
     *
     * @return string
     */
    protected function getHtmlDir(): string
    {
        return empty(config('ladmin.layout.rtl', false)) ? 'ltr' : 'rtl';
    }

    /**
     * Gets the 'lang' attribute for the main HTML tag. This property depends
     * on the current locale of the Laravel application.
     *
     * @return string
     */
    protected function getHtmlLang(): string
    {
        return str_replace('_', '-', app()->getLocale());
    }

    /**
     * Gets the Bootstrap theme for the entire layout.
     *
     * @return string
     */
    protected function getBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.layout.bootstrap_theme', '');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Gets the AdminLTE stylesheet file. The file to use depends on whether
     * layout RTL configuration is enabled or not.
     *
     * @return string
     */
    protected function getAdminlteCssFile(): string
    {
        $file = empty(config('ladmin.layout.rtl', false))
            ? 'adminlte.min.css'
            : 'adminlte.rtl.min.css';

        return asset("vendor/ladmin/css/{$file}");
    }

    /**
     * Gets the set of CSS classes for the body tag. The set of classes to be
     * used depends mostly on the layout configuration.
     *
     * @return string
     */
    protected function getBodyClasses(): string
    {
        // Initialize the CSS classes with the default layout classes. Class
        // 'user-select-none' is used to prevent text selection on the layout.

        $classes = [
            'user-select-none',
            $this->getSidebarExpandBreakpointClass(),
        ];

        // Add the mini sidebar class if the feature is enabled.

        if (! empty(config('ladmin.sidebar.mini_sidebar', false))) {
            $classes[] = 'sidebar-mini';
        }

        // Add the sidebar collapsed class if the feature is enabled.

        if (! empty(config('ladmin.sidebar.default_collapsed', false))) {
            $classes[] = 'sidebar-collapse';
        }

        // Add CSS classes relative to fixed layout options.

        if (! empty(config('ladmin.layout.fixed_sidebar', false))) {
            $classes[] = 'layout-fixed';
        }

        if (! empty(config('ladmin.layout.fixed_navbar', false))) {
            $classes[] = 'fixed-header';
        }

        if (! empty(config('ladmin.layout.fixed_footer', false))) {
            $classes[] = 'fixed-footer';
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the sidebar expand breakpoint CSS class. This class depends on the
     * configured expand breakpoint for the sidebar, and determines the screen
     * width at which the sidebar transitions between expanded and collapsed
     * states.
     *
     * @return string
     */
    protected function getSidebarExpandBreakpointClass(): string
    {
        $breakpoint = config('ladmin.sidebar.expand_breakpoint', 'lg');

        if (! in_array($breakpoint, $this->validScreenBreakpoints)) {
            $breakpoint = 'lg';
        }

        return "sidebar-expand-{$breakpoint}";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.admin-panel');
    }
}

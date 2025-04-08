<?php

namespace DFSmania\LaradminLte\View\Components\Layout;

use DFSmania\LaradminLte\Tools\Plugins\PluginsManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class AdminPanel extends Component
{
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
     * An instance of the plugins manager. This is used to read, validate, and
     * classify the set of configured plugins resources.
     *
     * @var PluginsManager
     */
    public PluginsManager $plugins;

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
        $this->title = $title ?? config('app.name');

        // Setup the AdminLTE stylesheet file path (LTR or RTL).

        $this->adminlteCssFile = $this->getAdminlteCssFile();

        // Setup the body classes.

        $this->bodyClasses = $this->getBodyClasses();

        // Init the plugins manager with the provided plugins configuration.

        $this->plugins = new PluginsManager(
            is_array(config('ladmin_plugins')) ? config('ladmin_plugins') : []
        );
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

        return asset("vendor/laradmin/css/{$file}");
    }

    /**
     * Gets the set of CSS classes for the body tag. The set of classes to be
     * used depends mostly on the layout configuration.
     *
     * @return string
     */
    protected function getBodyClasses(): string
    {
        // TODO: This logic should be improved based on the package config
        // file. For example, the breakpoint for expand sidebar and the
        // background color.

        $classes = [
            'sidebar-expand-lg',
            'bg-body-tertiary',
        ];

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
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.admin-panel');
    }
}

<?php

namespace DFSmania\LaradminLte\View\Components\Layout;

use DFSmania\LaradminLte\Tools\Plugins\PluginsManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class AdminPanel extends Component
{
    /**
     * The title that will be displayed on the browser's window. Defaults to
     * config('app.name') when not provided.
     *
     * @var string
     */
    public $title;

    /**
     * An instance of the plugins manager, this will be used to read and
     * classify the set of configured plugins resources.
     *
     * @var PluginsManager
     */
    public $plugins;

    /**
     * Create a new component instance.
     *
     */
    public function __construct(?string $title = null)
    {
        $this->title = $title ?? config('app.name');

        // Init the plugins manager with the provided plugins configuration.

        $this->plugins = new PluginsManager(
            is_array(config('ladmin_plugins')) ? config('ladmin_plugins') : []
        );
    }

    /**
     * Make the 'dir' attribute for the main HTML tag.
     *
     * @return string
     */
    public function makeHtmlDir(): string
    {
        return empty(config('ladmin.layout.rtl', false)) ? 'ltr' : 'rtl';
    }

    /**
     * Make the 'lang' attribute for the main HTML tag.
     *
     * @return string
     */
    public function makeHtmlLang(): string
    {
        return str_replace('_', '-', app()->getLocale());
    }

    /**
     * Make the 'href' attribute for the AdminLTE stylesheet link. This is used
     * to switch between LTR (left-to-right) and RTL (right-to-left) layouts.
     *
     * @return string
     */
    public function makeAdminlteHref(): string
    {
        $rtlSuffix = empty(config('ladmin.layout.rtl', false)) ? '' : '.rtl';

        return asset("vendor/laradmin/css/adminlte{$rtlSuffix}.min.css");
    }

    /**
     * Make the set of classes for the body tag.
     *
     * @return string
     */
    public function makeBodyClasses(): string
    {
        // TODO: This logic should be improved based on the package
        // configuration. For example, the breakpoint for expand sidebar and
        // the background color.

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
     * @return View
     */
    public function render(): View
    {
        return view('ladmin::components.layout.admin-panel');
    }
}

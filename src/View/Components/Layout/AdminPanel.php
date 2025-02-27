<?php

namespace DFSmania\LaradminLte\View\Components\Layout;

use DFSmania\LaradminLte\Tools\Plugins\PluginsManager;
use Illuminate\View\Component;

/**
 * TODO: Should we use a Livewire component with turbo links instead?
 */
class AdminPanel extends Component
{
    /**
     * The title that will be displayed on a browser's window. Defaults to
     * config('app.name') when not provided.
     *
     * @var string
     */
    public $title;

    /**
     * An instance of the plugins manager, this will be used to read and
     * classify the configuration of the plugins resources.
     *
     * @var PluginsManager
     */
    public $plugins;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');

        // Init the plugins manager with the provided plugins configuration.

        $this->plugins = new PluginsManager(
            is_array(config('ladmin_plugins')) ? config('ladmin_plugins') : []
        );
    }

    /**
     * Make the 'dir' attribute for the HTML tag.
     *
     * @return string
     */
    public function makeHtmlDir()
    {
        return empty(config('ladmin.layout.rtl', false)) ? 'ltr' : 'rtl';
    }

    /**
     * Make the 'lang' attribute for the HTML tag.
     *
     * @return string
     */
    public function makeHtmlLang()
    {
        return str_replace('_', '-', app()->getLocale());
    }

    /**
     * Make the 'href' attribute for the AdminLTE stylesheet link. This is used
     * to switch between LTR (left-to-right) and RTL (right-to-left) layouts.
     *
     * @return string
     */
    public function makeAdminlteHref()
    {
        $rtlSuffix = empty(config('ladmin.layout.rtl', false)) ? '' : '.rtl';

        return asset("vendor/laradmin/css/adminlte{$rtlSuffix}.min.css");
    }

    /**
     * Make the set of classes for the body tag.
     *
     * @return string
     */
    public function makeBodyClasses()
    {
        // TODO: This logic should be improved based on the package
        // configuration.

        $classes = [
            'sidebar-expand-lg',
            'bg-body-tertirary',
        ];

        if (! empty(config('ladmin.layout.fixed_sidebar', false))) {
            $classes[] = 'layout-fixed';
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.admin-panel');
    }
}

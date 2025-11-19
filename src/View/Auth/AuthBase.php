<?php

namespace DFSmania\LaradminLte\View\Auth;

use DFSmania\LaradminLte\Tools\Plugins\PluginResource;
use DFSmania\LaradminLte\Tools\Plugins\ResourceType;
use Illuminate\View\Component;
use Illuminate\View\View;

class AuthBase extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied to the
     * authentication scaffolding layout.
     *
     * @var string[]
     */
    protected array $validBootstrapThemes = [
        'light',
        'dark',
    ];

    /**
     * The list of plugins to be included before the AdminLTE asset files.
     *
     * @var string[]
     */
    protected array $preAdminltePlugins = [
        'Bootstrap5',
        'BootstrapIcons',
        'JsDeliverFont',
    ];

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
     * The Bootstrap theme that will be applied to the entire authentication
     * scaffolding layout.
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
     * The inline styles for the body tag, usually used to apply a background
     * image when configured.
     *
     * @var string
     */
    public string $bodyStyles;

    /**
     * The list of plugin links to be included in the head section, before the
     * AdminLTE stylesheet link.
     *
     * @var PluginResource[]
     */
    public array $preAdminlteLinks;

    /**
     * The list of plugin scripts to be included in the body tag, before the
     * AdminLTE script.
     *
     * @var PluginResource[]
     */
    public array $preAdminlteScripts;

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
        $this->title = $this->getBrowserTitle($title);

        // Setup the AdminLTE stylesheet file path (LTR or RTL).

        $this->adminlteCssFile = $this->getAdminlteCssFile();

        // Setup the body classes and styles.

        $this->bodyClasses = $this->getBodyClasses();
        $this->bodyStyles = $this->getBodyStyles();

        // Setup the pre-AdminLTE plugin resources.

        $this->preAdminlteLinks = ladmin()->plugins->getPluginResources(
            $this->preAdminltePlugins,
            ResourceType::PRE_ADMINLTE_LINK
        );

        $this->preAdminlteScripts = ladmin()->plugins->getPluginResources(
            $this->preAdminltePlugins,
            ResourceType::PRE_ADMINLTE_SCRIPT
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::auth.auth-base');
    }

    /**
     * Gets the 'dir' attribute for the main HTML tag. This property depends on
     * whether layout RTL configuration is enabled or not.
     *
     * @return string
     */
    protected function getHtmlDir(): string
    {
        return empty(config('ladmin.main.layout.rtl', false)) ? 'ltr' : 'rtl';
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
     * Gets the Bootstrap theme for the authentication layout.
     *
     * @return string
     */
    protected function getBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.main.layout.bootstrap_theme', '');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Gets the title for the browser's window. The title would be a combination
     * of the application name and the provided subtitle, if any.
     *
     * @param  ?string  $subtitle  The subtitle to be displayed.
     * @return string
     */
    protected function getBrowserTitle(?string $subtitle = null): string
    {
        $appName = config('app.name');

        return ! empty($subtitle) ? "{$appName} - {$subtitle}" : $appName;
    }

    /**
     * Gets the AdminLTE stylesheet file. The file to use depends on whether
     * layout RTL configuration is enabled or not.
     *
     * @return string
     */
    protected function getAdminlteCssFile(): string
    {
        $file = empty(config('ladmin.main.layout.rtl', false))
            ? 'adminlte.min.css'
            : 'adminlte.rtl.min.css';

        return asset("vendor/ladmin/css/{$file}");
    }

    /**
     * Gets the set of CSS classes for the body tag of the authentication
     * layout, as a space-separated string.
     *
     * @return string
     */
    protected function getBodyClasses(): string
    {
        // Initialize the CSS classes with the default layout classes. Class
        // 'user-select-none' is used to prevent text selection on the layout.

        $classes = [
            'user-select-none',
            'login-page',
        ];

        // Add background classes from the configuration file.

        if (empty(config('ladmin.auth.background_image', null))) {
            $bgClasses = config('ladmin.auth.background_classes', [
                'bg-body-secondary',
                'bg-gradient',
            ]);

            if (is_array($bgClasses)) {
                $classes = array_merge($classes, array_filter($bgClasses));
            }
        }

        // Return the CSS classes as a space-separated string.

        return implode(' ', $classes);
    }

    /**
     * Gets the inline styles for the body tag, usually used to apply a
     * background image when configured.
     *
     * @return string
     */
    protected function getBodyStyles(): string
    {
        $styles = [];
        $bgImage = config('ladmin.auth.background_image', null);

        // If a background image is configured, set it up to cover the entire
        // body of the authentication layout.

        if (! empty($bgImage)) {
            $styles[] = "background-image: url('{$bgImage}')";
            $styles[] = 'background-repeat: no-repeat';
            $styles[] = 'background-size: cover';
            $styles[] = 'background-position: center';
        }

        // Return the inline styles as a semicolon-separated string.

        return implode(';', $styles);
    }
}

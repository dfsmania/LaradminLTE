<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout\Plugins;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class PluginsFiles extends Component
{
    /**
     * The array of files that will be rendered. These files belongs to some
     * of the configured plugins.
     *
     * @var array
     */
    public $files;

    /**
     * The type of the plugins files that should be rendered. The accepted
     * values are: 'pre-adminlte-js', 'post-adminlte-js', 'pre-adminlte-css'
     * and 'post-adminlte-css'.
     *
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = null)
    {
        // Setup the plugins files type. This is mainly used to filter the set
        // of plugins files that will be rendered.

        $this->type = $type;

        // Initialize the array of plugins files from the provided config.

        $this->files = is_array(config('ladmin_plugins'))
            ? $this->getFilesFrom(config('ladmin_plugins'))
            : [];
    }

    /**
     * Gets an array of files from the provided set of plugins, filtered by
     * the specified type property of the instance.
     *
     * @param  array  $plugins  An array with the plugins to be inspected
     * @return array  An array with the filtered files
     */
    protected function getFilesFrom($plugins)
    {
        $files = [];

        // Get the required files from each plugin.

        foreach ($plugins as $pluginName => $plugin) {

            // Check whether the plugin should be included.

            if (! $this->shouldIncludePlugin($plugin)) {
                continue;
            }

            // Add the files from the plugin that matches the type specified
            // for this instance.

            // TODO: Instead of require to the client to specify the file type
            // (CSS, JS) on the configuration of each file, we can guess it
            // from the file extension. This way, the client may only specify
            // whether the file should be included before or after the AdminLte
            // template.

            $files = array_merge($files, array_filter(
                $plugin['files'],
                [$this, 'shouldIncludePluginFile']
            ));
        }

        // Return the set of extracted files.

        return array_map([$this, 'normalizePluginFile'], $files);
    }

    /**
     * Checks if a plugin should be included. A plugin should be included when
     * it's valid and required by the current request or view.
     *
     * @param  array  $plugin  An array representing the plugin
     * @return bool  Whether the plugin should be included or not
     */
    protected function shouldIncludePlugin($plugin)
    {
        return $this->isValidPlugin($plugin)
            && $this->isRequiredPlugin($plugin);
    }

    /**
     * Checks if the structure of a plugin is valid (i.e. contains the required
     * data). A plugin should follow the below schema:
     *
     * [
     *     'always' => required|bool,
     *     'files'  => required|array,
     * ]
     *
     * @param  array  $plugin  An array representing the plugin data
     * @return bool  Whether the plugin structure is valid or not
     */
    protected function isValidPlugin($plugin)
    {
        return is_array($plugin)
            && isset($plugin['always'])
            && is_array($plugin['files'])
            && ! empty($plugin['files']);
    }

    /**
     * Checks if a plugin is currently required. A plugin is required when its
     * 'always' property is set, or when it's explicitly required by the
     * current request/view using a custom blade directive (TBD).
     *
     * @param  array  $plugin  An array representing the plugin data
     * @return bool  Whether the plugin must be included or not
     */
    protected function isRequiredPlugin($plugin)
    {
        // TODO: We should also check whether the plugin is required by the
        // current request/view using some sort of blade directive (TBD). By
        // the moment, it's always (on all views) or never required.

        return ! empty($plugin['always']);
    }

    /**
     * Checks if a plugin file should be included. A plugin file should be
     * included when it's valid and matchs with the specified type.
     *
     * @param  array  $file  An array representing the plugin file
     * @return bool  Whether the plugin file should be included or not
     */
    protected function shouldIncludePluginFile($file)
    {
        return $this->isValidPluginFile($file)
            && (! isset($this->type) || $file['type'] === $this->type);
    }

    /**
     * Checks if the structure of a plugin file is valid (i.e. contains the
     * required data). A plugin file should follow the below schema:
     *
     * [
     *     'asset'    => optional|bool,
     *     'location' => required|string,
     *     'type'     => required|string,
     * ]
     *
     * @param  array  $file  An array representing the plugin file
     * @return bool  Whether the file structure is valid or not
     */
    protected function isValidPluginFile($file)
    {
        return is_array($file)
            && isset($file['location'])
            && isset($file['type']);
    }

    /**
     * Applies normalizations to a plugin file.
     *
     * @param  array  $file  An array representing the plugin file
     * @return array  The normalized version of the plugin file
     */
    protected function normalizePluginFile($file)
    {
        if (! empty($file['asset'])) {
            $file['location'] = asset($file['location']);
        }

        return $file;
    }

    /**
     * Computes a string (with HTML like format) that represents the set of
     * attributes for the specified plugin file.
     *
     * @param  array  $file  An array representing the plugin file
     * @param  string  $type  The type of the plugin file (css or js)
     * @return string  A string representing the list of attributes
     */
    public function computePluginFileAttributes($file, $type)
    {
        $attrs = new ComponentAttributeBag();

        // Grab the set of attributes that are explicitly defined (these have
        // the 'attr_' token prefixed on its name), and save they into the bag.

        foreach($file as $attr => $val) {
            if (Str::startsWith($attr, 'attr_')) {
                $attrs[substr($attr, 5)] = $val;
            }
        }

        // Now, depending on the type of the plugin file, add some required
        // attributes, including the one that references the plugin location.

        if ($type === 'css') {
            $attrs['href'] = $attrs['href'] ?? $file['location'];
            $attrs['rel'] = $attrs['rel'] ?? 'stylesheet';
        } else if ($type === 'js') {
            $attrs['src'] = $attrs['src'] ?? $file['location'];
        }

        // Return a string representing the list of attributes.

        return $attrs->toHtml();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.plugins.plugins-files');
    }
}

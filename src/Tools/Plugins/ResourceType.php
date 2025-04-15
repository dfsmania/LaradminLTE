<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

/**
 * ResourceType enum class.
 * This class defines the types of the plugin resources that can be included in
 * the AdminLTE template. Each type corresponds to a specific location in the
 * HTML document, relative to the AdminLTE CSS and JS files, where the resource
 * will be included.
 */
enum ResourceType: string
{
    case PRE_ADMINLTE_LINK = 'pre-adminlte-link';
    case POST_ADMINLTE_LINK = 'post-adminlte-link';
    case PRE_ADMINLTE_SCRIPT = 'pre-adminlte-script';
    case POST_ADMINLTE_SCRIPT = 'post-adminlte-script';
}

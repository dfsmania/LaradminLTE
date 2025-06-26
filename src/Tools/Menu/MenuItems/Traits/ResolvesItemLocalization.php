<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits;

use Illuminate\Support\Facades\Lang;

trait ResolvesItemLocalization
{
    /**
     * Resolves the translation for a given menu item value.
     * The value can be a short key or a full string, and it will return the
     * translated string if available, or the original value if no translation
     * is found.
     *
     * This method will check for both Laravel's translation approaches:
     * 1. Short key translations (i.e. using PHP array syntax).
     * 2. JSON translations (i.e. using full string as key in a JSON file).
     *
     * @param  string  $value  The value to translate (key or full string).
     * @return string
     */
    protected static function getTranslation(string $value): string
    {
        // Check that the value is not empty and that translations are enabled.

        $enabled = config('ladmin.menu_translations.enabled', false);

        if (empty($value) || ! $enabled) {
            return $value;
        }

        // First, try to lookup for a short key translation, as namespaced key
        // (i.e. using PHP array translation mode).

        $phpFile = config('ladmin.menu_translations.php_file', 'ladmin_menu');
        $key = "{$phpFile}.{$value}";

        if (Lang::has($key)) {
            return __($key);
        }

        // Then, try to lookup for a JSON string translation, this is useful if
        // the end user has defined the translations in a JSON file using the
        // translation string as the key.

        if (Lang::has($value)) {
            return __($value);
        }

        // Otherwise, fallback to the original value.

        return $value;
    }
}

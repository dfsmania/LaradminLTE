<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Concerns;

use Illuminate\Support\Facades\Lang;

trait ResolvesItemLocalization
{
    /**
     * Gets the translation for a given menu item value. The value can be
     * either a translation key (string) or an array containing the key and
     * the parameters for the translation.
     *
     * This method will check for both Laravel's translation approaches:
     * 1. Short key translations (i.e. using PHP array syntax).
     * 2. JSON translations (i.e. using full string as key in a JSON file).
     *
     * @param  string|array  $value  The value to translate, it can be:
     *                               A plain string (translation key or literal)
     *                               An array: [key_or_string, parameters]
     * @return string
     */
    protected static function getTranslation(string|array $value): string
    {
        // Check that the value is not empty and that translations are enabled.

        $enabled = config('ladmin.main.menu_translations.enabled', false);

        if (! $enabled || empty($value)) {
            return is_array($value) ? ($value[0] ?? '') : $value;
        }

        // Retrieve the key string and the parameters for the translation.

        if (is_array($value)) {
            $params = is_array($value[1] ?? null) ? $value[1] : [];
            $key = $value[0];
        } else {
            $params = [];
            $key = $value;
        }

        // Resolve and return the translation.

        return static::resolveTranslation($key, $params);
    }

    /**
     * Reolves the translation for a given key, checking both PHP file
     * translations and JSON string translations.
     *
     * This method first checks for a short key translation in a PHP file, then
     * checks for a JSON string translation, and finally returns the original
     * key if no translation is found.
     *
     * @param  string  $key  The translation key to resolve.
     * @param  array  $params  Optional parameters for the translation.
     * @return string
     */
    private static function resolveTranslation(
        string $key,
        array $params = []
    ): string {
        // First, try to lookup for a short key translation, as namespaced key
        // (i.e. using PHP array translation mode).

        $phpFile = config(
            'ladmin.main.menu_translations.php_file',
            'ladmin_menu'
        );
        $phpKey = "{$phpFile}.{$key}";

        if (Lang::has($phpKey)) {
            return Lang::get($phpKey, $params);
        }

        // Then, try to lookup for a JSON string translation, this is useful if
        // the end user has defined the translations in a JSON file using the
        // translation string as the key.

        if (Lang::has($key)) {
            return Lang::get($key, $params);
        }

        // Otherwise, fallback to the original value.

        return $key;
    }
}

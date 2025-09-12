<?php

namespace DFSmania\LaradminLte\View\Forms\Concerns;

/**
 * Trait for resolving error keys for form inputs. This trait provides
 * methods to generate and resolve error keys based on the input field's
 * name.
 */
trait ResolvesErrorKey
{
    /**
     * The lookup error key to use when searching for validation errors inside
     * the Laravel's errors bag. The lookup key is usually generated from the
     * "name" property of an input field.
     *
     * @var string
     */
    public string $errorKey;

    /**
     * Resolves the error key property by generating it from the provided
     * name. This method should be called during the component's construction
     * phase to ensure the error key is ready for use.
     *
     * @param  string  $name  The name of the input field
     * @return void
     */
    public function resolveErrorKey(string $name): void
    {
        $this->errorKey = $this->getErrorKeyFromName($name);
    }

    /**
     * Generates the error key that will be used to search for validation
     * errors. The error key is generated from a "name" property.
     *
     * Examples:
     * - files[]             => files
     * - person[2][name]     => person.2.name
     * - addresses[][street] => addresses.*.street
     *
     * @param  string  $name  The name of the input field
     * @return string
     */
    protected function getErrorKeyFromName(string $name): string
    {
        // Strip trailing "[]", so "files[]" becomes "files".

        $key = preg_replace('@\[\]$@', '', $name);

        // Convert brackets to dot notation, empty brackets become "*".

        $key = preg_replace_callback('@\[([^\]]*)\]@', function ($matches) {
            return $matches[1] === '' ? '.*' : '.'.$matches[1];
        }, $key);

        return $key;
    }
}

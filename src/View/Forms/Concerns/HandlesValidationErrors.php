<?php

namespace DFSmania\LaradminLte\View\Forms\Concerns;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

/**
 * Trait for handling validation errors on form inputs. This trait provides
 * methods to generate and resolve error keys based on the input field's
 * name, and to look up for validation errors in the Laravel's error bag.
 */
trait HandlesValidationErrors
{
    /**
     * The name of the errors bag to use when looking for validation errors.
     * If null, the default error bag will be used when searching for errors.
     *
     * @var ?string
     */
    public ?string $errorsBag = null;

    /**
     * The lookup error key to use when searching for validation errors inside
     * an errors bag. The lookup key is usually generated from the "name"
     * property of an input field.
     *
     * @var string
     */
    public string $errorKey;

    /**
     * Initializes the validation error handling properties. This method sets
     * up the error key and errors bag based on the provided parameters.
     *
     * @param  string  $name  The name of the input field to look up errors for
     * @param  ?string  $errorsBag  The name of the errors bag to inspect
     * @return void
     */
    protected function initValidationErrors(
        string $name,
        ?string $errorsBag = null
    ): void {
        $this->errorKey = $this->getErrorKeyFromName($name);
        $this->errorsBag = $errorsBag;
    }

    /**
     * Checks if there are validation errors for the configured error key and
     * errors bag.
     *
     * Note this methods takes a ViewErrorBag instance as parameter, this is
     * usually the $errors variable available in Blade views. The caller is
     * responsible for passing the correct errors bag.
     *
     * @param  ViewErrorBag  $errors  The ViewErrorBag instance
     * @return bool
     */
    public function hasError(ViewErrorBag $errors): bool
    {
        return $this->getBag($errors)->has($this->errorKey);
    }

    /**
     * Retrieves the first validation error message for the configured error
     * key and errors bag.
     *
     * Note this methods takes a ViewErrorBag instance as parameter, this is
     * usually the $errors variable available in Blade views. The caller is
     * responsible for passing the correct errors bag.
     *
     * @param  ViewErrorBag  $errors  The ViewErrorBag instance
     * @return ?string
     */
    public function firstError(ViewErrorBag $errors): ?string
    {
        return $this->getBag($errors)->first($this->errorKey);
    }

    /**
     * Checks if there are any validation errors in the specified errors bag.
     *
     * Note this methods takes a ViewErrorBag instance as parameter, this is
     * usually the $errors variable available in Blade views. The caller is
     * responsible for passing the correct errors bag.
     *
     * @param  ViewErrorBag  $errors  The ViewErrorBag instance
     * @return bool
     */
    public function anyErrors(ViewErrorBag $errors): bool
    {
        return $this->getBag($errors)->any();
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

    /**
     * Retrieves the appropriate MessageBag instance based on the configured
     * errors bag name. If an errors bag name is specified, it retrieves that
     * specific bag; otherwise, it returns the default errors bag.
     *
     * @param  ViewErrorBag  $errors  The ViewErrorBag instance
     * @return MessageBag
     */
    protected function getBag(ViewErrorBag $errors): MessageBag
    {
        return $errors->getBag($this->errorsBag ?? 'default');
    }
}

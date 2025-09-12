<?php

namespace DFSmania\LaradminLte\View\Forms\Concerns;

/**
 * Trait for handling old input values in forms. This trait provides methods to
 * resolve old input values from the session, allowing for easier form
 * repopulation after validation errors.
 */
trait HandlesOldInput
{
    /**
     * Whether to use previously submitted values when re-displaying the form
     * after validation errors.
     *
     * @var bool
     */
    public bool $useOldInput = true;

    /**
     * Resolve the value for an input field, using the old submitted value if
     * available (and old input support is enabled). Default value is used
     * when there isn't an old value.
     *
     * @param  string  $key  The key to use for look up the old value
     * @param  mixed  $default  Default value to use when there isn't old value
     * @return mixed
     */
    public function resolveOldInput(string $key, mixed $default = null): mixed
    {
        return $this->useOldInput ? old($key, $default) : $default;
    }
}

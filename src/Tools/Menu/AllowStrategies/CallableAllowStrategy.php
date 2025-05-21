<?php

namespace DFSmania\LaradminLte\Tools\Menu\AllowStrategies;

use DFSmania\LaradminLte\Tools\Menu\Contracts\AllowStrategy;

/**
 * Class CallableAllowStrategy
 *
 * This class implements the AllowStrategy interface to determine if a menu
 * item is allowed to be shown based on a custom callable.
 */
class CallableAllowStrategy implements AllowStrategy
{
    /**
     * The callable to determine the allowed status of the menu item.
     * This property contains a callable that will be executed to determine if
     * the menu item is allowed to be shown. The callable may optional accept
     * the menu item raw configuration as an argument and return a boolean
     * value indicating whether the item is allowed.
     *
     * @var callable
     */
    protected $callable;

    /**
     * The raw configuration of the menu item.
     * This property contains the raw configuration array of the menu item that
     * will be passed to the callable. This may be really useful when the menu
     * is built dynamically.
     *
     * @var array
     */
    protected array $rawConfig;

    /**
     * Create a new class instance.
     *
     * @param  callable  $callable  The callable to determine the allowed status
     * @param  array  $rawConfig  The raw configuration of the menu item
     * @return void
     */
    public function __construct(callable $callable, array $rawConfig = [])
    {
        $this->callable = $callable;
        $this->rawConfig = $rawConfig;
    }

    /**
     * Determines the allowed status by executing the internal callable.
     *
     * @return bool
     */
    public function isAllowed(): bool
    {
        $ref = new \ReflectionFunction(\Closure::fromCallable($this->callable));

        // If the callable accepts no parameters, we call it without any
        // arguments. Otherwise, we pass the raw configuration array.

        $isAllowed = $ref->getNumberOfParameters() === 0
            ? call_user_func($this->callable)
            : call_user_func($this->callable, $this->rawConfig);

        return (bool) $isAllowed;
    }
}

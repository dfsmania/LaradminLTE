<?php

namespace DFSmania\LaradminLte\Tools\Menu\ActiveStrategies;

use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;

/**
 * Class CallableActiveStrategy
 *
 * This class implements the ActiveStrategy interface to determine if a menu
 * item is currently active based on a custom callable.
 */
class CallableActiveStrategy implements ActiveStrategy
{
    /**
     * The callable to determine the active status of the menu item.
     * This property contains a callable that will be executed to determine if
     * the menu item is active. The callable should return a boolean indicating
     * whether the item is active or not.
     *
     * @var callable
     */
    protected $callable;

    /**
     * Create a new class instance.
     *
     * @param  callable  $callable  The callable to determine the active status
     * @return void
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Determines the active status by executing the internal callable.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) call_user_func($this->callable);
    }
}

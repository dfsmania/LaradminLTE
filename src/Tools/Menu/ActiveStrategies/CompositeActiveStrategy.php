<?php

namespace DFSmania\LaradminLte\Tools\Menu\ActiveStrategies;

use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;

/**
 * Class CompositeActiveStrategy
 *
 * This class implements the ActiveStrategy interface to determine if a menu
 * item is currently active based on its children.
 */
class CompositeActiveStrategy implements ActiveStrategy
{
    /**
     * The child menu items to inspect for active status.
     * This property contains an array of child menu items, and the active
     * status is determined by whether any child is active.
     *
     * @var MenuItem[]
     */
    protected array $children;

    /**
     * Create a new class instance.
     *
     * @param  MenuItem[]  $children  The child items to check for active status
     */
    public function __construct(array $children)
    {
        $this->children = $children;
    }

    /**
     * Determines the active status by inspecting if any of the stored menu
     * items is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        foreach ($this->children as $child) {
            if ($child->isActive()) {
                return true;
            }
        }

        return false;
    }
}

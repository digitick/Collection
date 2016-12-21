<?php

namespace Digitick\Foundation\Collection;

/**
 * Interface InterfaceSet
 * @package Digitick\Foundation\Collection
 */
interface InterfaceSet extends InterfaceCollection
{

    /**
     * Add an element to the set.
     * @param mixed $element Element to add to the set.
     * @return bool Return if the element has been added. False if the element already exists in the set.
     */
    public function add($element);

    /**
     * Remove an element from the set.
     * @param mixed $element The element to remove.
     * @return bool True if the element has been removed. False otherwise.
     */
    public function remove($element);

}
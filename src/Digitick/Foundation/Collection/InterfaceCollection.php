<?php

namespace Digitick\Foundation\Collection;

/**
 * Interface InterfaceCollection
 * @package Digitick\Foundation\Collection
 */
interface InterfaceCollection extends \Iterator, \Countable
{

    /**
     * Add every element from the given collection.
     * @param InterfaceCollection $elementCollection
     * @return void
     */
    public function addAll(InterfaceCollection $elementCollection);

    /**
     * Remove all elements from the collection.
     * @return bool True if the collection have been correctly cleared.
     */
    public function clear();

    /**
     * Check whether the given element is on the collection.
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element);

    /**
     * Check whether every element in the given elementCollection is on the collection.
     * @param InterfaceCollection $elementCollection
     * @return bool
     */
    public function containsAll(InterfaceCollection $elementCollection);

    /**
     * Check if collection is empty.
     * @return bool
     */
    public function isEmpty();

    /**
     * Remove from current collection every element within the elementCollection.
     * @see clear()
     * @param InterfaceCollection $elementCollection
     * @return bool
     */
    public function removeAll(InterfaceCollection $elementCollection);

    /**
     * Return the collection as a native PHP array
     * @return array
     */
    public function toArray();

}
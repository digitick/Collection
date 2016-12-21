<?php

namespace Digitick\Foundation\Collection;

use Digitick\Foundation\Collection\Exception\InvalidArgumentException;
use Digitick\Foundation\Collection\Exception\OutOfBoundException;


/**
 * Interface InterfaceList
 * @package Digitick\Foundation\Collection
 */
interface InterfaceList extends InterfaceCollection, \ArrayAccess
{

    /**
     * Add an element to the list.
     * @param int $offset Offset where the element must be inserted.
     * @param mixed $element The element to add.
     * @return bool
     */
    public function add($offset, $element);

    /**
     * Remove from current list the element matching the given offset.
     * @param int $offset Offset where the element must be removed.
     * @return void
     * @throws OutOfBoundException
     */
    public function remove($offset);

    /**
     * Return the element matching the given offset.
     * @param int $offset Offset of the element.
     * @return mixed
     */
    public function get($offset);

    /**
     * Set the given element in the list at the offset position. (same as add())
     * @see add($offset, $element)
     * @param int $offset Offset where the element must be set.
     * @param mixed $element The element to set.
     * @return void
     * @throws OutOfBoundException
     */
    public function set($offset, $element);

    /**
     * Return the position of a given element if it exists.
     * @param mixed $element Element to search.
     * @return int
     */
    public function indexOf($element);

    /**
     * Return a sublist of the current list.
     * @param int $fromIndex Start of extraction.
     * @param int $toIndex End of extraction.
     * @return InterfaceList
     * @throws InvalidArgumentException
     */
    public function subList($fromIndex, $toIndex);

}
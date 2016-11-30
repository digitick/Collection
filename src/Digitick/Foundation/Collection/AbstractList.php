<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of elements
 * Class AbstractList
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractList extends \SplFixedArray implements InterfaceList
{
    use TraitCollection {
        indexOf as traitIndexOf;
        contains as traitContains;
    }

    /**
     * AbstractList constructor.
     * @param $size
     */
    public function __construct($size)
    {
        parent::__construct($size);
    }

    /**
     * Add every element from the given collection.
     *
     * @param InterfaceCollection $elementCollection
     */
    public function addAll(InterfaceCollection $elementCollection)
    {
        $currentSize = $this->size();
        $addedSize = $elementCollection->size();
        $newSize = $currentSize + $addedSize;
        $this->setSize($newSize);
        for ($i = $currentSize; $i < $newSize; $i++) {
            $this->add($i, $elementCollection[$i - $currentSize]);
        }

    }

    /**
     * Get current list size
     */
    public function size()
    {
        return $this->count();
    }

    /**
     * Add given element at the offset position.
     *
     * @param $offset
     * @param $element
     */
    public function add($offset, $element)
    {
        $this->set($offset, $element);
    }

    /**
     * Set the given element in the list at the offset position. (same as add())
     *
     * @param offset
     * @param mixed $element
     */
    public function set($offset, $element)
    {
        $this->offsetSet($offset, $element);
    }

    /**
     * Empty current list.
     *
     * @return bool
     */
    public function clear()
    {
        $size = $this->size();
        for ($i = 0; $i < $size; $i++) {
            $this->remove($i);
        }
        return true;
    }

    /**
     * Remove from current list the element matching the given offset.
     */
    public function remove($offset)
    {
        $this->offsetUnset($offset);
    }

    /**
     * Check whether the given element is on the list.
     *
     * @param $element
     * @return bool
     */
    public function contains($element)
    {
        return $this->traitContains($element, $this);
    }

    /**
     * Return the position of a given element if it exists
     *
     * @param $element
     * @return int
     */
    public function indexOf($element)
    {
        return $this->traitIndexOf($element, $this);
    }

    /**
     * Check whether every element in the given elementCollection is on the list.
     *
     * @param InterfaceCollection $elementCollection
     * @return bool|int
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        $otherCollectionSize = $elementCollection->size();
        $i = 0;
        $found = true;
        while ($i < $otherCollectionSize && $found) {
            $found = ($this->contains($elementCollection[$i]));
            $i++;
        }

        return $found;
    }

    /**
     * Check whether the list is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        $isEmpty = true;
        $i = 0;
        $size = $this->size();

        while ($isEmpty && $i < $size) {
            if ($this->offsetExists($i))
                $isEmpty = false;
            $i++;
        }

        return ($isEmpty);
    }

    /**
     * Remove from current list every element within the elementCollection.
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {

    }

    /**
     * Return a sublist of the current list from given indexes
     *
     * @param $fromIndex
     * @param $toIndex
     * @return static
     * @throws \InvalidArgumentException
     */
    public function subList($fromIndex, $toIndex)
    {
        if ($fromIndex > $toIndex)
            throw new \InvalidArgumentException('Parameter $fromIndex (=' . $fromIndex . ') cannot be greater than $toIndex (=' . $toIndex . ')');

        $subSize = $toIndex - $fromIndex + 1;
        $subList = new static($subSize);
        $subIndex = 0;
        for ($i = $fromIndex; $i <= $toIndex; $i++) {
            $subList->set($subIndex, $this->get($i));
            $subIndex++;
        }
        return $subList;
    }

    /**
     * Return the element matching the given offset.
     *
     * @param $offset
     * @return mixed
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }
}

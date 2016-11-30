<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 * Class AbstractScalarSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractScalarSet implements InterfaceSet
{
    use TraitTypedCollection {
        indexOf as traitIndexOf;
        contains as traitContains;
    }

    const DEFAULT_SIZE = 10;
    /**
     * @var int
     */
    protected $nextAvailableOffset = 0;
    /**
     * @var \SplFixedArray
     */
    protected $storageArray;


    /**
     * AbstractScalarSet constructor.
     *
     * @param int $size
     */
    public function __construct($size = self::DEFAULT_SIZE)
    {
        $this->storageArray = new \SplFixedArray($size);
        $this->nextAvailableOffset = 0;
    }

    /**
     * clear empties current list.
     */
    public function clear()
    {
        $size = $this->nextAvailableOffset;
        for ($i = ($size-1); $i >= 0; $i--) {
            $this->removeOffset($i);
        }
        $this->nextAvailableOffset = 0;
        return true;
    }

    /**
     * Return list size
     *
     * @return int
     */
    public function size()
    {
        return $this->storageArray->getSize();
    }

    /**
     * Remove offset
     *
     * @param $offset
     * @throws \InvalidArgumentException
     */
    protected function removeOffset($offset)
    {
        $this->shift($offset);
        $this->decreaseSize();
    }

    /**
     * Shift from offset
     *
     * @param $fromOffset
     * @throws \InvalidArgumentException
     */
    protected function shift($fromOffset)
    {
        if ($fromOffset > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (=' . $fromOffset . ') greater than its size (=' . $this->nextAvailableOffset . ')');
        for ($i = $fromOffset; $i < $this->nextAvailableOffset; $i++) {
            $this->storageArray->offsetSet($i, $this->get($i + 1));
        }
    }

    /**
     * Get element from offset
     *
     * @param $offset
     * @return mixed
     */
    public function get($offset)
    {
        return $this->storageArray->offsetGet($offset);
    }

    /**
     * Decrease list size
     *
     * @param int $quantity
     * @throws \InvalidArgumentException
     */
    protected function decreaseSize($quantity = 1)
    {
        if ($quantity > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (=' . $quantity . ') greater than its size (=' . $this->nextAvailableOffset . ')');
        $this->nextAvailableOffset = $this->nextAvailableOffset - $quantity;
    }

    /**
     * fromArray override.
     *
     * @param InterfaceCollection $elementCollection
     */
    public function addAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $this->add($element);
        }
    }

    /**
     * Add an element to list
     *
     * @param $element
     * @return bool
     */
    public function add($element)
    {
        if (is_scalar($element) && !$this->contains($element)) {
            $this->storageArray->offsetSet($this->nextAvailableOffset, $element);
            $this->increaseSize();
            return true;
        } else
            return false;
    }

    protected function indexOf($element)
    {
        return $this->traitIndexOf($element, $this->storageArray);
    }

    /**
     * Increase list size
     *
     * @param int $quantity
     */
    protected function increaseSize($quantity = 1)
    {
        $this->nextAvailableOffset = $this->nextAvailableOffset + $quantity;
        $currentSize = $this->storageArray->getSize();
        if ($this->nextAvailableOffset >= $currentSize) {
            $this->storageArray->setSize($currentSize + static::DEFAULT_SIZE);
        }
    }

    /**
     * Check element existence in list
     *
     * @param $element
     * @return bool
     */
    public function contains($element)
    {
        return $this->traitContains($element, $this->storageArray);
    }

    /**
     * Check if list is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->nextAvailableOffset === 0);
    }

    /**
     * Transform list to array
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $size = $this->nextAvailableOffset;

        for ($i = 0; $i < $size; $i++) {
            $array[$i] = $this->get($i);
        }
        return $array;
    }

    /**
     * Check whether every element in the given elementCollection is on the list.
     *
     * @param InterfaceCollection $elementCollection
     * @return bool|int
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        $found = true;
        foreach($elementCollection as $element) {
            $found = $this->contains($element);
            if (!$found)
                return false;
        }

        return $found;

    }

    /**
     * Remove elements from a list
     *
     * @param InterfaceCollection $elementCollection
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $this->remove($element);
        }

    }

    /**
     * Remove element from list
     *
     * @param $element
     * @return bool
     */
    public function remove($element)
    {
        $offset = $this->indexOf($element);
        if ($offset != -1) {
            $this->removeOffset($offset);
            return true;
        } else
            return false;
    }

    /**
     * Overload Spl current()
     *
     * @return mixed
     */
    public function current()
    {
        return $this->storageArray->current();
    }

    /**
     * Overload Spl key()
     *
     * @return mixed
     */
    public function key()
    {
        return $this->storageArray->key();
    }

    /**
     * Overload Spl next()
     */
    public function next()
    {
        $this->storageArray->next();
    }

    /**
     * Overload Spl rewind()
     */
    public function rewind()
    {
        $this->storageArray->rewind();
    }

    /**
     * Overload Spl valid()
     *
     * @return mixed
     */
    public function valid()
    {
        return $this->storageArray->valid();
    }

    /**
     * Overload Spl count()
     *
     * @return mixed
     */
    public function count()
    {
        return $this->storageArray->count();
    }
}

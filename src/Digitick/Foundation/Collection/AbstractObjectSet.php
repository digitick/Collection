<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 * Class AbstractObjectSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractObjectSet implements InterfaceSet
{
    /**
     * @var int
     */
    protected $nextAvailableOffset = 0;
    /**
     * @var \SplObjectStorage
     */
    protected $storageArray;


    /**
     * AbstractObjectSet constructor.
     */
    public function __construct()
    {
        $this->storageArray = new \SplObjectStorage();
        $this->nextAvailableOffset = 0;
    }

    /**
     * clear empties current list.
     */
    public function clear()
    {
        $this->storageArray->removeAll($this->storageArray);
    }

    /**
     * Add all elements that are not already in the collection
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
     * Add a specific element
     *
     * @param $element
     */
    public function add($element)
    {
        if(is_object($element))
            $this->storageArray->attach($element);
    }

    /**
     * Remove the given element
     *
     * @param $element
     */
    public function remove($element)
    {
        $this->storageArray->detach($element);
    }

    /**
     * Test if the storage is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->storageArray->count() === 0);
    }

    /**
     * Get the current size of storage
     *
     * @return mixed
     */
    public function size()
    {
        return $this->storageArray->count();
    }

    /**
     * Transform storage in array of objects
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $i = 0;
        foreach ($this->storageArray as $object) {
            $array[$i] = $object;
            $i++;
        }
        return $array;
    }

    /**
     * Test if a collection exists in storage
     *
     * @param InterfaceCollection $elementCollection
     * @return bool
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $isContained = $this->contains($element);
            if (!$isContained) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if an element exists in storage
     *
     * @param $element
     * @return mixed
     */
    public function contains($element)
    {
        return $this->storageArray->contains($element);
    }

    /**
     * Remove all elements in storage from given list
     *
     * @param InterfaceCollection $elementCollection
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {
        $this->storageArray->removeAll($elementCollection);
    }

    /**
     * Get the current object
     *
     * @return mixed
     */
    public function current()
    {
        return $this->storageArray->current();
    }

    /**
     * Get the current key value
     *
     * @return mixed
     */
    public function key()
    {
        return $this->storageArray->key();
    }

    /**
     * Makes the pointer move forward in storage
     */
    public function next()
    {
        $this->storageArray->next();
    }

    /**
     * Make the pointer go back to first element
     */
    public function rewind()
    {
        $this->storageArray->rewind();
    }

    /**
     * Test if the storage is valid
     *
     * @return mixed
     */
    public function valid()
    {
        return $this->storageArray->valid();
    }

    /**
     * Get the number of elements (SplObjectStorage count() overload)
     *
     * @return mixed
     */
    public function count()
    {
        return $this->storageArray->count();
    }

    /**
     * Get an element from storage
     *
     * @param $object
     * @return mixed
     */
    public function get($object)
    {
        return $this->storageArray->offsetGet($object);
    }

    /**
     * Set data to an element of storage
     *
     * @param $element
     */
    public function set($element, $data)
    {
        $this->storageArray->offsetSet($element, $data);
    }
}

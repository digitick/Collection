<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 * Class AbstractTypedObjectSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractTypedObjectSet extends AbstractObjectSet
{
    use TraitTypedCollection;

    /**
     * Build from array
     *
     * @param $array
     * @return \SplObjectStorage
     * @throws \InvalidArgumentException
     */
    public function fromArray($array)
    {
        $total = count($array);
        for ($i = 0; $i < $total; $i++) {
            $this->add($array[$i]);
        }

        return $this->storageArray;
    }

    /**
     * Add a specific element
     *
     * @param $element
     */
    public function add($element)
    {
        static::checkElementType($element);
        if (!parent::contains($element) && !in_array($element, (array)$this->toArray()))
            parent::add($element);
    }

    /**
     * Set data to an element of storage
     *
     * @param $element
     */
    public function set($element, $data)
    {
        static::checkElementType($element);
        parent::set($element, $data);
    }

    /**
     * Check if an element exists in storage
     *
     * @param $element
     * @return mixed
     */
    public function contains($element)
    {
        return parent::contains($element);
    }
}

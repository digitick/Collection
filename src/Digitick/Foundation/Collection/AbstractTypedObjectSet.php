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
            static::checkElementType($array[$i]);
            $this->add($array[$i]);
        }

        return $this->storageArray;
    }

    /**
     * @inheritdoc
     */
    public function add($element)
    {
        static::checkElementType($element);
        return parent::add($element);
    }

    /**
     * @inheritdoc
     */
    public function set($element, $data)
    {
        static::checkElementType($element);
        parent::setData($element, $data);
    }

    /**
     * @inheritdoc
     *
     */
    public function contains($element)
    {
        static::checkElementType($element);
        return parent::contains($element);
    }
}

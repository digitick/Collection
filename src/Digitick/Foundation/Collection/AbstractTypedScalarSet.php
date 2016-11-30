<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of scalars
 * Class AbstractTypedScalarSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractTypedScalarSet extends AbstractScalarSet
{
    use TraitTypedCollection;

    /**
     * fromArray override
     *
     * @param $array
     * @param bool $saves_indexes
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function fromArray($array, $saves_indexes = true)
    {
        $total = count($array);
        for ($i = 0; $i < $total; $i++) {
            static::checkElementType($array[$i]);
        }
        $collection = new static($total);
        $parentCollection = parent::fromArray($array, $saves_indexes);

        for ($i = 0; $i < $total; $i++) {
            $collection[$i] = $parentCollection[$i];
        }
        return $collection;
    }

    /**
     * Find the offset matching the given element
     *
     * @param $element
     * @return int
     */
    public function indexOf($element)
    {
        static::checkElementType($element);
        return parent::indexOf($element);
    }
    
    /**
     * Add an element to list
     *
     * @param $element
     * @return bool
     */
    public function add($element)
    {
        static::checkElementType($element);
        parent::add($element);
    }

}

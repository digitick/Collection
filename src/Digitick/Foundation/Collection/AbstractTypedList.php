<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 * Class AbstractTypedList
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractTypedList extends AbstractList
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
     * offsetSet override.
     * @param $index
     * @param $newval
     */
    public function offsetSet($index, $newval)
    {
        static::checkElementType($newval);
        parent::offsetSet($index, $newval);
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
        return $this->traitIndexOf($element, $this);
    }


}

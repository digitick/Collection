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
        foreach ($array as $item) {
            static::checkElementType($item);
        }
        $parentCollection = parent::fromArray($array, $saves_indexes);
        $collection = new static($parentCollection->count());

        foreach ($parentCollection as $key => $val) {
            $collection [$key] = $val;
        }
        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($index, $newval)
    {
        static::checkElementType($newval);
        parent::offsetSet($index, $newval);
    }

    /**
     * @inheritdoc
     */
    public function indexOf($element)
    {
        static::checkElementType($element);
        return $this->traitIndexOf($element, $this);
    }


}

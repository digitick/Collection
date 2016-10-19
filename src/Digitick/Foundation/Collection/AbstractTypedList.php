<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 */
use Digitick\Foundation\Collection\InterfaceList;
use Digitick\Foundation\Collection\TraitTypedCollection;

abstract class AbstractTypedList extends AbstractList
{
    use TraitTypedCollection {
        indexOf as traitIndexOf;
    }

    /**
     * offsetSet override.
     * @param $index
     * @param $newval
     */
    public function offsetSet( $index, $newval)
    {
        static::checkElementType($newval);
        parent::offsetSet($index, $newval);
    }

    /**
     * indexOf : find the offset matching the given element.
     * @param $element
     */

    public function indexOf($element)
    {
        return $this->traitIndexOf($element);
    }


    /**
     * fromArray override.
     * @param $array
     * @param $saves_indexes
     */
    public static function fromArray($array, $saves_indexes=true)
    {
        $total=count($array);
        for($i=0;$i<$total;$i++)
        {
            static::checkElementType($array[$i]);
        }
        $collection = new static($total);
        $parentCollection = parent::fromArray($array, $saves_indexes);

        for($i=0;$i<$total;$i++)
        {
            $collection[$i]=$parentCollection[$i];
        }
        return $collection;
    }


}

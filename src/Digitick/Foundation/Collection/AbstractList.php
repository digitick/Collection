<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 */
use Digitick\Foundation\Collection\InterfaceList;
use Digitick\Foundation\Collection\TraitTypedCollection;

abstract class AbstractList extends \SplFixedArray implements InterfaceList
{
    use TraitTypedCollection {
        indexOf as traitIndexOf;
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
     * offsetSet override.
     * @param $index
     * @param $newval
     */
    public function offsetSet( $index, $newval)
    {
        static::checkElementType($newval);
        try {
            parent::offsetSet($index, $newval);
        } catch (\RuntimeException $exc) {
            $msg = sprintf ("Code : %s<br/>\nMessage : %s<br/>\nSize : %d<br/>\nIndex : %d<br/>\n",
                $exc->getCode(),
                $exc->getMessage(),
                $this->getSize(),
                $index
            );
            throw $exc;
        }
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

    /**
     * clear empties current list.
     *
     */
    public function clear()
    {
        $size=$this->size();
        for($i=0;$i<$size;$i++)
        {
            $this->remove($i);
        }
        return TRUE;
    }

    /**
     * fromArray override.
     * @param $array
     * @param $saves_indexes
     */
    public function addAll(InterfaceCollection $elementCollection)
    {
        $currentSize=$this->size();
        $addedSize=$elementCollection->size();
        $newSize=$currentSize+$addedSize;
        $this->setSize($newSize);
        for($i=$currentSize;$i<$newSize;$i++)
        {
            $this->add($i, $elementCollection[$i-$currentSize]);
        }

    }

    public function add($offset, $element)
    {
        return $this->set($offset, $element);
    }


    public function set($offset, $element)
    {
        return $this->offsetSet($offset, $element);
    }

    public function get($offset)
    {
        return $this->offsetGet($offset);
    }


    public function remove($offset)
    {
        return $this->offsetUnset($offset);
    }


    public function contains($element)
    {
        return ($this->indexOf($element)!==-1);
    }


    public function isEmpty()
    {
        $isEmpty = true;
        $i=0;
        $size=$this->size();

        while($isEmpty AND $i<$size)
        {
            if ($this->offsetExists($i))
                $isEmpty = false;
            $i++;
        }

        return ($isEmpty);
    }

    public function size()
    {
        return $this->count();
    }

    public function toArray()
    {
        $array = array();
        $size=$this->size();

        for($i=0;$i<$size;$i++)
        {
            $array[$i] = $this->get($i);
        }
        return $array;
    }

    public function containsAll(InterfaceCollection $elementCollection)
    {

    }

    public function removeAll(InterfaceCollection $elementCollection)
    {

    }

    public function subList($fromIndex, $toIndex)
    {
        if ($fromIndex>$toIndex)
            throw new \InvalidArgumentException('Parameter $fromIndex (='.$fromIndex.') cannot be greater than $toIndex (='.$toIndex.')');

        $subSize=$toIndex-$fromIndex+1;
        $subList = new static($subSize);
        $subIndex = 0;
        for($i=$fromIndex;$i<=$toIndex;$i++)
        {
            $subList->set($subIndex, $this->get($i));
            $subIndex++;
        }
        return $subList;
    }

    public function indexOf($element)
    {
        return $this->traitIndexOf($element);
    }
}

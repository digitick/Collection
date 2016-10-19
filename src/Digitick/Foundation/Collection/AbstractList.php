<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 */
use Digitick\Foundation\Collection\InterfaceList;

abstract class AbstractList extends \SplFixedArray implements InterfaceList
{

    /**
     * AbstractList constructor.
     * @param $size
     */
    public function __construct($size)
    {
        parent::__construct($size);
    }

    /**
     * addAll : add every element from the given collection.
     * @param InterfaceCollection $elementCollection
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

    /**
     * add : add given element at the offset position.
     * @param offset
     * @param mixed $element
     */
    public function add($offset, $element)
    {
        return $this->set($offset, $element);
    }

    /**
     * clear : empty current list.
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
     * contains : check whether the given element is on the list.
     * @param $element
     */
    public function contains($element)
    {
        return ($this->indexOf($element)!==-1);
    }


    /**
     * contains : check whether every element in the given elementCollection is on the list.
     * @param $elementCollection
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        $otherCollectionSize=$elementCollection->size();
        $i=0;
        $found=true;
        while($i<$otherCollectionSize and $found)
        {
            $found = ($this->indexOf($elementCollection[$i]) !== -1);
            $i++;
        }

        return ($found);

    }

    /**
     * get : return the element matching the given offset.
     * @param $element
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }


    protected function compare($element1, $element2)
    {
        if (is_object($element1) and is_object($element2))
            return ($element1 == $element2);
        if (!is_object($element1) and !is_object($element2))
            return ($element1 === $element2);
        return false;
    }


    public function indexOf($element)
    {
        $size=$this->size();
        $found=false;
        $i=0;

        while(!$found and $i<$size)
        {
            $found=$this->compare($element, $this->get($i));
            $i++;
        }
        if ($found)
            return $i-1;
        else
            return -1;
    }


    /**
     * isEmpty : check whether the list is empty or not.
     *
     */
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


    /**
     * remove : remove from current list the element matching the given offset.
     *
     */
    public function remove($offset)
    {
        return $this->offsetUnset($offset);
    }


    /**
     * removeAll : remove from current list every element within the elementCollection.
     *
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {

    }

    /**
     * set : set the given element in the list at the offset position. (same as add())
     * @param offset
     * @param mixed $element
     */
    public function set($offset, $element)
    {
        return $this->offsetSet($offset, $element);
    }


    /**
     * size : get current list size
     *
     */
    public function size()
    {
        return $this->count();
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



}

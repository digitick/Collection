<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 */
use Digitick\Foundation\Collection\InterfaceSet;
use Digitick\Foundation\Collection\TraitTypedCollection;

abstract class AbstractSet extends \SplFixedArray implements InterfaceSet
{
    use TraitTypedCollection;
    const DEFAULT_SIZE = 5;
    protected $nextAvailableOffset=0;

    public function __construct()
    {
        parent::__construct(static::DEFAULT_SIZE);
        $this->nextAvailableOffset=0;
    }

    protected function increaseSize($quantity=1)
    {
        $this->nextAvailableOffset = $this->nextAvailableOffset + $quantity;
        $currentSize=$this->getSize();
        if ($this->nextAvailableOffset >= $currentSize)
        {
            $this->setSize($currentSize + static::DEFAULT_SIZE);
        }
    }

    protected function decreaseSize($quantity=1)
    {
        if ($quantity > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (='.$quantity.') greater than its size (='.$this->nextAvailableOffset.')');
        $this->nextAvailableOffset = $this->nextAvailableOffset - $quantity;

        //  Doit-on aussi redimensionner à la baisse pour économiser de la mémoire mais perdre de la perf à le faire ?    
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
/*    public static function fromArray(Array $array, $saves_indexes)
    {
        $total=count($array);
        for($i=0;$i<$total;$i++)
        {
            static::checkElementType($array[$i]);
        }
        $collection = new static($total);
        $parentCollection = parent::fromArray($array, FALSE);

        for($i=0;$i<$total;$i++)
        {
            $collection[$i]=$parentCollection[$i];
        }
        return $collection;
    }*/

    /**
     * clear empties current list.
     *
     */
    public function clear()
    {
        $this->nextAvailableOffset = 0;

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
            $this->add($elementCollection[$i-$currentSize]);
        }

    }

    public function add($element)
    {
        if ($this->indexOf($element) === -1)
        {
            $this->offsetSet($this->nextAvailableOffset, $element);
            $this->increaseSize();
            return true;
        }
        else
            return false;
    }


    public function remove($element)
    {
        $offset = $this->indexOf($element);
        if ($offset != -1) // A remplacer par une constante NOT_FOUND
        {
//            $this->offsetUnset($offset);
            $this->shift($offset);
            $this->decreaseSize();
            return true;
        }
        else
            return false;
    }


    protected function shift($fromOffset)
    {
        if ($fromOffset > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (='.$fromOffset.') greater than its size (='.$this->nextAvailableOffset.')');
        for($i=$fromOffset;$i<$this->nextAvailableOffset;$i++)
        {
            var_dump($this->offsetGet($i+1));
            $this->offsetSet($i, $this->offsetGet($i+1));
        }
    }

    public function contains($element)
    {
        return ($this->indexOf($element)!==-1);
    }


    public function isEmpty()
    {
        return($this->nextAvailableOffset==0);
    }

    public function size()
    {
        return $this->nextAvailableOffset;
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
        foreach ($elementCollection as $element) {
            $this->remove($element);
        }

    }


}

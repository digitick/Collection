<?php

namespace Digitick\Foundation\Collection;

/**
 * This class is used to create a fixed list of objects
 *
 */
use Digitick\Foundation\Collection\InterfaceSet;
use Digitick\Foundation\Collection\TraitTypedCollection;

abstract class AbstractSet implements InterfaceSet
{
    use TraitTypedCollection;
    const DEFAULT_SIZE = 500;
    protected $nextAvailableOffset=0;
    protected $storageArray;            // utilisé pour stocker les données réellement


    public function __construct()
    {
        $this->storageArray = new \SplFixedArray(static::DEFAULT_SIZE);
        $this->nextAvailableOffset=0;
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
        for($i=$size-1;$i>=0;$i--)
        {
            $this->removeOffset($i);
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
        $this->storageArray->setSize($newSize);
        for($i=$currentSize;$i<$newSize;$i++)
        {
            $this->add($elementCollection[$i-$currentSize]);
        }

    }

    public function add($element)
    {
        if ($this->indexOf($element) === -1)
        {
            $this->set($this->nextAvailableOffset, $element);
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
            $this->removeOffset($offset);
            return true;
        }
        else
            return false;
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

    /* Iterator interface methods override */
    public function current()
    {
        return $this->storageArray->current();
    }

    public function key()
    {
        return $this->storageArray->key();
    }

    public function next()
    {
        return $this->storageArray->next();
    }

    public function rewind()
    {
        return $this->storageArray->rewind();
    }

    public function valid()
    {
        return $this->storageArray->valid();
    }

    public function count()
    {
        return $this->storageArray->count();
    }


    protected function get($offset)
    {
        return $this->storageArray->offsetGet($offset);
    }

    protected function set($offset, $element)
    {
        static::checkElementType($element);

        $this->storageArray->offsetSet($offset, $element);
    }

    protected function increaseSize($quantity=1)
    {
        $this->nextAvailableOffset = $this->nextAvailableOffset + $quantity;
        $currentSize=$this->storageArray->getSize();
        if ($this->nextAvailableOffset >= $currentSize)
        {
            $this->storageArray->setSize($currentSize + static::DEFAULT_SIZE);
        }
    }

    protected function decreaseSize($quantity=1)
    {
        if ($quantity > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (='.$quantity.') greater than its size (='.$this->nextAvailableOffset.')');
        $this->nextAvailableOffset = $this->nextAvailableOffset - $quantity;

        //  Doit-on aussi redimensionner à la baisse pour économiser de la mémoire mais perdre de la perf à le faire ?
    }

    protected function shift($fromOffset)
    {
        if ($fromOffset > $this->nextAvailableOffset)
            throw new \InvalidArgumentException('Cannot decrease current set with value (='.$fromOffset.') greater than its size (='.$this->nextAvailableOffset.')');
        for($i=$fromOffset;$i<$this->nextAvailableOffset;$i++)
        {
            $this->set($i, $this->get($i+1));
        }
    }


    protected function removeOffset($offset)
    {
        $this->shift($offset);
        $this->decreaseSize();
    }
}

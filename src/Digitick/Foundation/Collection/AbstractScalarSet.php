<?php

namespace Digitick\Foundation\Collection;
use Digitick\Foundation\Collection\Exception\InvalidArgumentException;
use Digitick\Foundation\Collection\Exception\NotImplementedException;
use Digitick\Foundation\Collection\Exception\OutOfBoundException;
use Digitick\Foundation\Collection\Exception\UnexpectedTypeException;

/**
 * This class is used to create a fixed set of scalars
 * Class AbstractScalarSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractScalarSet implements InterfaceSet
{
    use TraitCollection {
        indexOf as traitIndexOf;
        contains as traitContains;
    }

    const DEFAULT_SIZE = 10;
    /**
     * @var int
     */
    protected $nextAvailableOffset = 0;
    /**
     * @var \SplFixedArray
     */
    protected $storageArray;
    /** @var int  */
    protected $iteratorPointer = 0;


    /**
     * AbstractScalarSet constructor.
     * The
     *
     * @param int $initialAllocation The size of the set.
     */
    public function __construct($initialAllocation = self::DEFAULT_SIZE)
    {
        $this->storageArray = new \SplFixedArray($initialAllocation);
        $this->nextAvailableOffset = 0;
    }

    /**
     * @inheritdoc
     * @throws OutOfBoundException InvalidArgumentException
     */
    public function clear()
    {
        $size = $this->nextAvailableOffset;
        for ($i = ($size-1); $i >= 0; $i--) {
            $this->removeOffset($i);
        }
        $this->nextAvailableOffset = 0;
        return true;
    }

    /**
     * Remove element at the given offset
     *
     * @param int $offset
     * @throws OutOfBoundException InvalidArgumentException
     */
    protected function removeOffset($offset)
    {
        $this->shift($offset);
        $this->decreaseSize();
    }

    /**
     * Shift from offset
     *
     * @param $fromOffset
     * @throws \InvalidArgumentException
     */
    protected function shift($fromOffset)
    {
        if ($fromOffset < 0) {
            throw new InvalidArgumentException("Offset must be >= 0 ($fromOffset given)");
        }
        if ($fromOffset > $this->nextAvailableOffset)
            throw new OutOfBoundException(OutOfBoundException::buildMessage($fromOffset, 0, $this->nextAvailableOffset));
        for ($i = $fromOffset; $i < $this->nextAvailableOffset; $i++) {
            $this->storageArray->offsetSet($i, $this->get($i + 1));
        }
    }

    /**
     * @inheritdoc
     */
    protected function get($offset)
    {
        try {
            return $this->storageArray->offsetGet($offset);
        } catch (\RuntimeException $exc) {
            throw new OutOfBoundException(OutOfBoundException::buildMessage($offset, 0, $this->storageArray->count()), 0, $exc);
        }
    }

    /**
     * Decrease list size
     *
     * @param int $quantity
     * @throws InvalidArgumentException
     */
    protected function decreaseSize($quantity = 1)
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException("Quantity must be >= 0 ($quantity given)");
        }
        if ($quantity > $this->nextAvailableOffset)
            throw new InvalidArgumentException('Cannot decrease current set with value (=' . $quantity . ') greater than its size (=' . $this->nextAvailableOffset . ')');
        $this->nextAvailableOffset -= $quantity;
    }

    /**
     * @inheritdoc
     */
    public function addAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $this->add($element);
        }
    }

    /**
     * @inheritdoc
     */
    public function add($element)
    {
        if (!is_scalar($element)) {
            throw new UnexpectedTypeException(gettype($element), 'scalar');
        }

        if (!$this->contains($element)) {
            $this->storageArray->offsetSet($this->nextAvailableOffset, $element);
            $this->increaseSize();
            return true;
        }

        return false;
    }

    /**
     * Return index of the element.
     * @param mixed $element
     * @return int
     */
    protected function indexOf($element)
    {
        return $this->traitIndexOf($element, $this->storageArray);
    }

    /**
     * Increase list size
     *
     * @param int $quantity
     */
    protected function increaseSize($quantity = 1)
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException("Quantity must be >= 0 ($quantity given)");
        }

        $this->nextAvailableOffset = $this->nextAvailableOffset + $quantity;
        $currentSize = $this->storageArray->getSize();
        if ($this->nextAvailableOffset >= $currentSize) {
            $this->storageArray->setSize($currentSize + static::DEFAULT_SIZE);
        }
    }

    /**
     * @inheritdoc
     */
    public function contains($element)
    {
        return $this->traitContains($element, $this->storageArray);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return ($this->count() === 0);
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $array = array();
        $size = $this->nextAvailableOffset;

        for ($i = 0; $i < $size; $i++) {
            $array[$i] = $this->get($i);
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        $found = true;
        foreach($elementCollection as $element) {
            $found = $this->contains($element);
            if (!$found)
                return false;
        }

        return $found;

    }

    /**
     * @inheritdoc
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {
        throw new NotImplementedException();
        foreach ($elementCollection as $element) {
            $this->remove($element);
        }

    }

    /**
     * @inheritdoc
     */
    public function remove($element)
    {
        $offset = $this->indexOf($element);
        if ($offset != -1) {
            $this->removeOffset($offset);
            return true;
        } else
            return false;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->storageArray[$this->iteratorPointer];
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->iteratorPointer;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->iteratorPointer++;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->iteratorPointer = 0;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->iteratorPointer < $this->nextAvailableOffset;
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return $this->nextAvailableOffset;
    }
}

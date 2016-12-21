<?php

namespace Digitick\Foundation\Collection;

use Digitick\Foundation\Collection\Exception\NotImplementedException;
use Digitick\Foundation\Collection\Exception\UnexpectedTypeException;
use Digitick\Foundation\Collection\Exception\UnexpectedValueException;

/**
 * This class is used to create a fixed set of objects
 *
 * Class AbstractObjectSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractObjectSet implements InterfaceSet
{
    /**
     * @var int
     */
    protected $nextAvailableOffset = 0;
    /**
     * @var \SplObjectStorage
     */
    protected $storageArray;


    /**
     * AbstractObjectSet constructor.
     */
    public function __construct()
    {
        $this->storageArray = new \SplObjectStorage();
        $this->nextAvailableOffset = 0;
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->storageArray->removeAll($this->storageArray);
        return true;
    }

    /**
     * @inheritdoc
     * @throws UnexpectedTypeException
     */
    public function addAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $this->add($element);
        }
    }

    /**
     * @inheritdoc
     * @throws UnexpectedTypeException
     */
    public function add($element)
    {
        if(!is_object($element)) {
            throw new UnexpectedTypeException(gettype($element), 'object');
        }

        if (!$this->contains($element)) {
            $this->storageArray->attach($element);
            return true;
        }
        return false;

    }

    /**
     * @inheritdoc
     */
    public function remove($element)
    {
        $this->storageArray->detach($element);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return ($this->storageArray->count() === 0);
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $array = [];
        $i = 0;
        foreach ($this->storageArray as $object) {
            $array[$i] = $object;
            $i++;
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function containsAll(InterfaceCollection $elementCollection)
    {
        foreach ($elementCollection as $element) {
            $isContained = $this->contains($element);
            if (!$isContained) {
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function contains($element)
    {
        return $this->storageArray->contains($element);
    }

    /**
     * @inheritdoc
     * TODO : Probleme SplObjectStorage::removeAll demande un SplObjectStorage mais on y passe un InterfaceCollection ce qui n'est rien pour lui.
     */
    public function removeAll(InterfaceCollection $elementCollection)
    {
        throw new NotImplementedException();
        $this->storageArray->removeAll($elementCollection);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->storageArray->current();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->storageArray->key();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->storageArray->next();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->storageArray->rewind();
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->storageArray->valid();
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return $this->storageArray->count();
    }

    /**
     * Return data associated to the given element.
     * @param object $element
     * @return mixed
     */
    public function getData($element)
    {
        try {
            return $this->storageArray->offsetGet($element);
        } catch (\UnexpectedValueException $exc) {
            throw new UnexpectedValueException("Unable to get data. Element not found in the set.", $exc->getCode(), $exc);
        }
    }

    /**
     * Set data to
     *
     * @param object $element
     * @param mixed $data
     */
    public function setData ($element, $data)
    {
        if (!$this->contains($element)) {
            throw new UnexpectedValueException("Unable to set data. Element not found in the set.");
        }
        $this->storageArray->offsetSet($element, $data);
    }
}

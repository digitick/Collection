<?php

namespace Digitick\Foundation\Collection;

use Digitick\Foundation\Collection\Exception\UnexpectedTypeException;

/**
 * This class is used to create a fixed list of scalars
 * Class AbstractTypedScalarSet
 * @package Digitick\Foundation\Collection
 */
abstract class AbstractTypedScalarSet extends AbstractScalarSet
{
    use TraitTypedCollection;

    /**
     * Build set from array
     *
     * @param array $array
     * @param bool $saves_indexes
     * @return static
     * @throws UnexpectedTypeException
     * TODO : un appel est fait à parent::fromArray($array, $saves_indexes); Or cette methode n'existe pas dans AbstractScalarSet. A remplacer par SplFixedArray::fromArray (a cause de $this->storageArray). Un cpoier/coller de AbstractTypedList ?
     */
    public static function fromArray(array $array, $saves_indexes = true)
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
     * @inheritdoc
     */
    public function indexOf($element)
    {
        static::checkElementType($element);
        return parent::indexOf($element);
    }
    
    /**
     * @inheritdoc
     */
    public function add($element)
    {
        static::checkElementType($element);
        parent::add($element);
    }

}

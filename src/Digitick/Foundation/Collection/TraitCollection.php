<?php

namespace Digitick\Foundation\Collection;


/**
 * This trait is used to gather common code about collection management
 * Class TraitCollection
 * @package Digitick\Foundation\Collection
 */
Trait TraitCollection
{

    /**
     * Return index of element in collection
     *
     * @param $element
     * @param $collectionObject
     * @return int
     */
    protected function indexOf($element, $collectionObject)
    {
        if ($this->contains($element, $collectionObject)) {
            return array_search($element, (array)$collectionObject, true);
        }

        return -1;
    }

    /**
     * Check element existence in collection
     *
     * @param $element
     * @param $collectionObject
     * @return mixed
     */
    protected function contains($element, $collectionObject)
    {
        return in_array($element, (array)$collectionObject, true);
    }
}

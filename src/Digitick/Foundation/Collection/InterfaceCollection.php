<?php

namespace Digitick\Foundation\Collection;

/**
 * Interface InterfaceCollection
 * @package Digitick\Foundation\Collection
 */
interface InterfaceCollection extends \Iterator, \Countable
{

    /**
     * @param InterfaceCollection $elementCollection
     * @return mixed
     */
    public function addAll(InterfaceCollection $elementCollection);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @param $element
     * @return mixed
     */
    public function contains($element);

    /**
     * @param InterfaceCollection $elementCollection
     * @return mixed
     */
    public function containsAll(InterfaceCollection $elementCollection);

    /**
     * @return mixed
     */
    public function isEmpty();

    /**
     * @param InterfaceCollection $elementCollection
     * @return mixed
     */
    public function removeAll(InterfaceCollection $elementCollection);

    /**
     * @return mixed
     */
    public function size();

    /**
     * @return mixed
     */
    public function toArray();

}
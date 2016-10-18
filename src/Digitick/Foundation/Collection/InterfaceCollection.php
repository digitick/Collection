<?php

namespace Digitick\Foundation\Collection;

interface InterfaceCollection extends \Iterator, \Countable
{

    public function addAll(InterfaceCollection $elementCollection);

    public function clear();

    public function contains($element);

    public function containsAll(InterfaceCollection $elementCollection);

    public function isEmpty();

    public function removeAll(InterfaceCollection $elementCollection);

    public function size();

    public function toArray();

}
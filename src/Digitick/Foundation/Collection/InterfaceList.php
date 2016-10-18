<?php

namespace Digitick\Foundation\Collection;


use Digitick\Foundation\Collection\InterfaceCollection;

interface InterfaceList extends InterfaceCollection, \ArrayAccess
{
/*
    public function add($element);

    public function addAll(CollectionInterface $elementCollection);

    public function clear();

    public function contains($element);

    public function containsAll(CollectionInterface $elementCollection);

    public function isEmpty();

    public function remove($element);

    public function removeAll(CollectionInterface $elementCollection);

    public function size();

    public function toArray();

*/

    public function add($offset, $element);
    public function remove($offset);

    public function get($offset);
    public function set($offset, $element);

    public function indexOf($element);
    public function subList($fromIndex, $toIndex);

    public static function fromArray($array, $saves_indexes=true);

}
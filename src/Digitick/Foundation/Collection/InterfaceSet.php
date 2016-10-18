<?php

namespace Digitick\Foundation\Collection;


use Digitick\Foundation\Collection\InterfaceCollection;

interface InterfaceSet extends InterfaceCollection
{
/*

    public function addAll(CollectionInterface $elementCollection);

    public function clear();

    public function contains($element);

    public function containsAll(CollectionInterface $elementCollection);

    public function isEmpty();

    public function removeAll(CollectionInterface $elementCollection);

    public function size();

    public function toArray();

*/

    public function add($element);
    public function remove($element);

    //public static function fromArray($array);

}
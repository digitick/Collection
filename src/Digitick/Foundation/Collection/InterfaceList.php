<?php

namespace Digitick\Foundation\Collection;


use Digitick\Foundation\Collection\InterfaceCollection;

interface InterfaceList extends InterfaceCollection, \ArrayAccess
{

    public function add($offset, $element);
    public function remove($offset);

    public function get($offset);
    public function set($offset, $element);

    public function indexOf($element);
    public function subList($fromIndex, $toIndex);

    public static function fromArray($array, $saves_indexes=true);

}
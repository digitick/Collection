<?php

namespace Digitick\Foundation\Collection;


use Digitick\Foundation\Collection\InterfaceCollection;

interface InterfaceSet extends InterfaceCollection
{

    public function add($element);
    public function remove($element);

    //public static function fromArray($array);

}
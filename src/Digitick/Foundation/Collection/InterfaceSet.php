<?php

namespace Digitick\Foundation\Collection;


/**
 * Interface InterfaceSet
 * @package Digitick\Foundation\Collection
 */
interface InterfaceSet extends InterfaceCollection
{

    public function add($element);
    public function get($element);
    public function remove($element);

}
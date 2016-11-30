<?php

namespace Digitick\Foundation\Collection;


/**
 * Interface InterfaceList
 * @package Digitick\Foundation\Collection
 */
interface InterfaceList extends InterfaceCollection, \ArrayAccess
{

    public function add($offset, $element);

    public function remove($offset);

    public function get($offset);

    public function set($offset, $element);

    public function indexOf($element);

    public function subList($fromIndex, $toIndex);

}
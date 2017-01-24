<?php


namespace Digitick\Foundation\Collection\Exception;


class OutOfBoundException extends \OutOfBoundsException
{
    public static function buildMessage ($offset, $min, $max) {
        return sprintf ("%s is out of bound. Values accepted : [%s, %s]",
            $offset,
            $min,
            $max
        );
    }
}
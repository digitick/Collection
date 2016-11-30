<?php

namespace Digitick\Foundation\Collection;


/**
 * This trait is used to gather common code about typed collection management
 * Class TraitTypedCollection
 * @package Digitick\Foundation\Collection
 */
Trait TraitTypedCollection
{
    /**
     * @var string
     */
    protected static $CLASSORTYPENAME = 'unknown';

    /**
     * Check the element type
     *
     * @param $element
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected static function checkElementType($element)
    {
        $type = 'unknown';
        $isValid = true;
        if (is_null($element))
            return true;

        if (is_object($element)) {
            if (!($element instanceof static::$CLASSORTYPENAME)) {
                $type = get_class($element);
                $isValid = false;
            }
        } else {
            $type = gettype($element);
            if ($type != static::$CLASSORTYPENAME)
                $isValid = false;
        }
        if (!$isValid)
            throw new \InvalidArgumentException('Item of class or type "' . static::$CLASSORTYPENAME . '" expected. "' . $type . '" given.');

        return $isValid;
    }
}

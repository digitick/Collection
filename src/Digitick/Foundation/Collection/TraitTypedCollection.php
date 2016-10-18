<?php

namespace Digitick\Foundation\Collection;
/**
 * This trait is used to gather common code about typed collection management
 *
 */

Trait TraitTypedCollection
{
    protected static $CLASSORTYPENAME = 'unknown';

    private static function checkElementType($element)
    {
        $type = 'unknown';
        $isValid = TRUE;
        if (is_null($element))
            return true;

        if (is_object($element))
        {
            if (!is_a($element, static::$CLASSORTYPENAME))
            {
                $type = get_class($element);
                $isValid = FALSE;
            }
        }
        else
        {
            $type = gettype($element);
            if ( $type != static::$CLASSORTYPENAME)
                $isValid = FALSE;
        }
        if (!$isValid)
            throw new \InvalidArgumentException('Item of class or type "' . static::$CLASSORTYPENAME . '" expected. "' . $type . '" given.');


    }


    protected function indexOf($element)
    {
        $size=$this->size();
        $found=false;
        $i=0;

        while(!$found and $i<$size)
        {
            $found=($element == $this->offsetGet($i));
            $i++;
        }

        if ($found)
            return $i-1;
        else
            return -1;
    }

}

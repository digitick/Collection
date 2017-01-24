<?php


namespace Digitick\Foundation\Collection\Exception;


use Exception;

class UnexpectedTypeException extends UnexpectedValueException
{
    /**
     * UnexpectedTypeException constructor.
     * @param string $givenType
     * @param string $expectedType
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($givenType, $expectedType, $code = 0, Exception $previous = null)
    {
        parent::__construct($this->buildMessage($givenType, $expectedType), $code, $previous);
    }

    /**
     * @param string $given
     * @param string $expected
     * @return string
     */
    protected function buildMessage ($given, $expected) {
        return sprintf ("Unexpected type, '$given' given but '$expected' expected.");
    }

}
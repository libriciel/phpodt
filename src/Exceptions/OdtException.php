<?php

namespace PhpOdt\Exceptions;

use Exception;

class OdtException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function __toString()
    {
        $class = new ReflectionClass($this);
        $trace = $this->getTrace();
        $errorMsg = 'Exception "' . $class->getName() . '" in ' . $trace[0]['file'] . '(' . $trace[0]['line'] . ')' .
                    ': <strong>' . $this->getMessage() . '</strong>';
        return $errorMsg;
    }
}

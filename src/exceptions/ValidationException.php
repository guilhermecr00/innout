<?php

class ValidationException extends Exception
{
    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous); //sobreescrevendo o método do pai
    }
}
<?php

class ValidationException extends AppException
{
    private $errors = [];

    public function __construct(
        $errors = [], //para poder passar vários erros para serem exibidos de uma mesma exceção
        $message = 'Erros de validação',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous); //sobreescrevendo o método do pai
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function get($att) //a partir do atribuo pega a mensagem de erro que está dentro do array $errors;
    {
        return $this->errors[$att];
    }
}
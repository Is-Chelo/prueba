<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

use Exception;

class BadRequestException extends Exception
{
    public function __construct($message = "Hubo un error", $code = Response::HTTP_FORBIDDEN, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

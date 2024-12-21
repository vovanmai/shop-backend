<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class BadRequestException extends Exception
{
    public function __construct($message = "Bad request exception", $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return response()->error($this->getMessage(), [], $this->getCode());
    }
}

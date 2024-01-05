<?php

namespace App\Exceptions;

use Exception;

class PostNotFoundException extends Exception
{
    public function __construct($message = "Post not found", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php


namespace App\Exception;


class NoCurrentUserException extends \RuntimeException
{
    public function __construct($message = "No current user", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

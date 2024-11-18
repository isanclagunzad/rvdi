<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DuplicateUsernameException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Duplicate usernames detected: ' .
            PHP_EOL .
            $message .
            PHP_EOL .
            '. Please ensure all usernames are unique before re-uploading',
            $code, $previous
        );
    }
}
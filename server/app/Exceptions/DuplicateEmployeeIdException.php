<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DuplicateEmployeeIdException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Duplicate employee id\'s detected: ' .
            PHP_EOL .
            $message .
            PHP_EOL .
            '. Please ensure all employee id are unique before re-uploading',
            $code, $previous
        );
    }
}
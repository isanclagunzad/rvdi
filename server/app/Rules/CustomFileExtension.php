<?php

namespace App\Rules;

class CustomFileExtension implements Rule
{
    protected $extensions;

    public function __construct($extensions)
    {
        $this->extensions = $extensions;
    }

    public function passes($attribute, $value)
    {
        // Ensure that the uploaded file has one of the specified extensions
        return in_array(strtolower($value->getClientOriginalExtension()), $this->extensions);
    }

    public function message()
    {
        return 'The :attribute must be a file of type: ' . implode(', ', $this->extensions);
    }
}

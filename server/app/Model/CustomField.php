<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'uses_file'
    ];
}

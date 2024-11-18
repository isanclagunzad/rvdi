<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeCustomField extends Model
{
    protected $fillable = [
        'employee_id', 'custom_field_id'
    ];
}

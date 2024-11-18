<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $fillable = [
        'value', 
        'custom_field_id',
        'employee_id'
    ];

    public function fieldtype() 
    {
        return $this->belongsTo(CustomField::class, 'custom_field_id', 'id');
    }
}

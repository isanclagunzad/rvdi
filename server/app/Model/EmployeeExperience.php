<?php

namespace App\Model;

class EmployeeExperience extends BaseModel
{
    protected $table = 'employee_experience';
    protected $primaryKey = 'employee_experience_id';
    protected $fillable = [
        'employee_experience_id','employee_id','organization_name','designation','from_date','to_date','skill','responsibility'
    ];
}

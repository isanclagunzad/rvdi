<?php

namespace App\Model;

class EmployeePerformanceDetails extends BaseModel
{
    protected $table = 'employee_performance_details';
    protected $primaryKey = 'employee_performance_details_id';

    protected $fillable = [
        'employee_performance_details_id','employee_performance_id', 'performance_criteria_id','rating'
    ];
}

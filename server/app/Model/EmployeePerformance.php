<?php

namespace App\Model;

class EmployeePerformance extends BaseModel
{
    protected $table = 'employee_performance';
    protected $primaryKey = 'employee_performance_id';

    protected $fillable = [
        'employee_performance_id', 'employee_id','month','remarks','created_by','updated_by','status'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

}

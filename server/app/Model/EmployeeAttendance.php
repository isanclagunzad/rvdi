<?php

namespace App\Model;

class EmployeeAttendance extends BaseModel
{
    protected $table = 'employee_attendance';
    protected $primaryKey = 'employee_attendance_id';

    protected $fillable = [
        'finger_print_id', 'in_out_time'
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'finger_print_id', 'finger_id');
    }

    public function inOutData() 
    {
        return $this->hasOne(EmployeeInOutdata::class, 'employee_attendance_id', 'employee_attendance_id');
    }
}
